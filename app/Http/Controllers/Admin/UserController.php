<?php
// app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users'],
            'password'   => ['required', 'min:8', 'confirmed'],
            'role'       => ['required', Rule::in(['admin', 'cashier', 'customer'])],
            'status'     => ['required', Rule::in(['active', 'inactive'])],
            'photo'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // Send verification email
        $user->sendEmailVerificationNotification();

        return redirect()->route('admin.users.index')
            ->with('success', 'User created and verification email sent!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user)],
            'password'   => ['nullable', 'min:8', 'confirmed'],
            'role'       => ['required', Rule::in(['admin', 'cashier', 'customer'])],
            'status'     => ['required', Rule::in(['active', 'inactive'])],
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

        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate(['status' => [Rule::in(['active', 'inactive'])]]);
        $user->update(['status' => $request->status]);
        return response()->json(['success' => true, 'status' => $user->status]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => [Rule::in(['admin', 'cashier', 'customer'])]]);
        $user->update(['role' => $request->role]);
        return response()->json(['success' => true, 'role' => $user->role]);
    }
}