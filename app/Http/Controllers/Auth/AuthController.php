<?php
// app/Http/Controllers/Auth/AuthController.php — Laravel 10
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Login ────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        if ($user->status === 'inactive') {
            return back()->withErrors(['email' => 'Your account has been deactivated. Contact your administrator.'])->onlyInput('email');
        }

        if (is_null($user->email_verified_at)) {
            return back()->withErrors(['email' => 'Please verify your email address before logging in.'])->onlyInput('email');
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Role-based redirect
        return match(Auth::user()->role) {
            'admin'    => redirect()->intended(route('admin.dashboard')),
            'cashier'  => redirect()->intended(route('cashier.orders.index')),
            'customer' => redirect()->intended(route('customer.dashboard')),
            default    => redirect()->intended(route('home')),
        };
    }

    // ── Register (Staff — Admin creates, sets role manually) ─
    // ── Register (Customer — self-registration from home page) ─

    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Public registration — always creates a 'customer' account.
     * Staff accounts (admin/cashier) are created by the admin via /admin/users.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users'],
            'password'   => ['required', 'min:8', 'confirmed'],
            'photo'      => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'photo'      => $photoPath,
            'role'       => 'customer',   // always customer from public registration
            'status'     => 'active',
        ]);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('success', 'Account created! Please check your email and click the verification link before logging in.');
    }

    // ── Email Verification ───────────────────────────────────

    public function verifyEmail(Request $request, int $id, string $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403, 'Invalid verification link.');
        }

        if (!$request->hasValidSignature()) {
            abort(403, 'This verification link has expired. Please request a new one.');
        }

        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            $request->session()->regenerate();
            return $this->redirectByRole($user, 'Your email is already verified. Welcome back!');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        event(new Verified($user));

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user, 'Email verified! Welcome to Kafé Lumière, ' . $user->first_name . '!');
    }

    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectByRole($request->user());
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent! Please check your inbox.');
    }

    public function resendVerificationGuest(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        $user = User::where('email', $request->email)->first();
        if ($user && is_null($user->email_verified_at)) {
            $user->sendEmailVerificationNotification();
        }
        return redirect()->route('login')
            ->with('success', 'If that email exists and is unverified, a new link has been sent.')
            ->withInput(['email' => $request->email]);
    }

    // ── Logout ───────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    // ── Helper ───────────────────────────────────────────────

    private function redirectByRole(User $user, string $message = '')
    {
        $route = match($user->role) {
            'admin'    => route('admin.dashboard'),
            'cashier'  => route('cashier.orders.index'),
            'customer' => route('customer.dashboard'),
            default    => route('home'),
        };
        return $message ? redirect($route)->with('success', $message) : redirect($route);
    }
}