<?php
// app/Http/Controllers/Admin/ProductController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Addon;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function index()
    {
        $products   = Product::with(['category', 'photos', 'addons'])->latest()->paginate(15);
        $categories = Category::all();
        $addons     = Addon::all();
        return view('admin.products.index', compact('products', 'categories', 'addons'));
    }

    public function create()
    {
        $categories = Category::all();
        $addons     = Addon::all();
        return view('admin.products.create', compact('categories', 'addons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'category_id'   => ['required', 'exists:categories,id'],
            'size'          => ['required', 'in:Tall (16oz),Grande (22oz),Both'],
            'price_tall'    => ['required', 'numeric', 'min:0'],
            'price_grande'  => ['nullable', 'numeric', 'min:0'],
            'photos'        => ['nullable', 'array'],
            'photos.*'      => ['image', 'max:2048'],
            'addon_ids'     => ['nullable', 'array'],
            'addon_ids.*'   => ['exists:addons,id'],
        ]);

        $product = Product::create($validated);

        // Handle multiple photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('products', 'public');
                $product->photos()->create([
                    'path'    => $path,
                    'is_main' => $index === 0,
                ]);
                if ($index === 0) {
                    $product->update(['main_photo' => $path]);
                }
            }
        }

        // Sync add-ons
        if ($request->has('addon_ids')) {
            $product->addons()->sync($request->addon_ids);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product "' . $product->name . '" created successfully!');
    }

    public function edit(Product $product)
    {
        $product->load(['category', 'photos', 'addons']);
        $categories = Category::all();
        $addons     = Addon::all();
        return view('admin.products.edit', compact('product', 'categories', 'addons'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'category_id'  => ['required', 'exists:categories,id'],
            'size'         => ['required'],
            'price_tall'   => ['required', 'numeric', 'min:0'],
            'price_grande' => ['nullable', 'numeric', 'min:0'],
            'photos'       => ['nullable', 'array'],
            'photos.*'     => ['image', 'max:2048'],
            'addon_ids'    => ['nullable', 'array'],
        ]);

        $product->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('products', 'public');
                $isMain = ($index === 0); // first uploaded photo is always the new main
                $product->photos()->create(['path' => $path, 'is_main' => $isMain]);
                // Always update main_photo with the first new photo uploaded
                if ($index === 0) {
                    $product->update(['main_photo' => $path]);
                }
            }
        }

        $product->addons()->sync($request->addon_ids ?? []);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete(); // Soft delete
        return back()->with('success', 'Product archived. You can restore it from the trash.');
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->with('category')->latest()->paginate(15);
        return view('admin.products.trashed', compact('products'));
    }

    public function restore(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return back()->with('success', '"' . $product->name . '" has been restored.');
    }

    // ── Excel Import ───────────────────────────────────────
    public function import(Request $request)
    {
        $request->validate(['file' => ['required', 'mimes:xlsx,xls,csv', 'max:5120']]);

        $import = new ProductsImport;
        Excel::import($import, $request->file('file'));

        $msg = "Successfully imported {$import->imported} product(s).";

        if ($import->skipped > 0) {
            $msg .= " Skipped {$import->skipped} row(s).";
        }
        if (!empty($import->errors)) {
            // Show first error as a warning
            $msg .= ' Note: ' . $import->errors[0];
        }

        if ($import->imported === 0) {
            return back()->with('error', 'No products were imported. ' . implode(' ', $import->errors));
        }

        return back()->with('success', $msg);
    }

    // ── Delete single photo ──────────────────────────────────
    public function deletePhoto(ProductPhoto $photo)
    {
        $product = $photo->product;

        // Delete the file from storage disk
        Storage::disk('public')->delete($photo->path);

        if ($photo->is_main) {
            // Deleting the main photo — promote the next available photo
            $photo->delete();
            $next = $product->photos()->first();
            if ($next) {
                $next->update(['is_main' => true]);
                $product->update(['main_photo' => $next->path]);
            } else {
                // No photos left — clear main_photo
                $product->update(['main_photo' => null]);
            }
        } else {
            // Non-main photo — just delete it
            $photo->delete();
        }

        // Redirect explicitly back to the product edit page
        // (using back() can cause issues if the referrer header is missing)
        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Photo removed successfully.');
    }

    // ── Excel Export ───────────────────────────────────────
    public function export()
    {
        return Excel::download(new ProductsExport, 'products-' . now()->format('Y-m-d') . '.xlsx');
    }
}