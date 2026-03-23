<?php
// app/Http/Controllers/Admin/ProfileController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'   => ['nullable', 'min:8', 'confirmed'],
            'photo'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        unset($validated['password_confirmation']);
        $user->update($validated);

        $redirect = $user->isCustomer()
            ? route('customer.dashboard')
            : url()->previous();

        return redirect($redirect)->with('success', 'Profile updated successfully!');
    }
}