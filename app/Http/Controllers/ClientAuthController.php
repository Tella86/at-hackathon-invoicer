<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\User;

class ClientAuthController extends Controller
{
    /**
     * Display the client login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // We'll create this view later. It's just a simple form with email and password fields.
        return view('auth.client-login');
    }

    /**
     * Handle a login request for a client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // We explicitly use the 'client' guard to attempt authentication.
        if (Auth::guard('client')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect to the client's dedicated dashboard.
            return redirect()->intended(route('client.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display the form for an invited client to accept the invitation and set a password.
     *
     * @param string $token
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showAcceptForm(string $token)
    {
        // Find the client by the invitation token.
        $client = Client::where('invitation_token', $token)->first();

        // Ensure a client was found and the token has not expired.
        if (!$client || $client->invitation_expires_at < now()) {
            // You can create a dedicated view for this error message.
            return redirect()->route('client.login.form')->with('error', 'This invitation link is invalid or has expired.');
        }

        // Pass the token to the view so we can include it in the form.
        return view('auth.client-invitation-accept', ['token' => $token]);
    }

    /**
     * Process the invitation acceptance and set the client's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processAcceptForm(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:clients,invitation_token',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $client = Client::where('invitation_token', $request->token)->firstOrFail();

        // Double-check expiration here as well, in case the user sat on the form for a long time.
        if ($client->invitation_expires_at < now()) {
            return redirect()->route('client.login.form')->with('error', 'This invitation link has expired.');
        }

        // Set the password and update the client's record.
        $client->password = Hash::make($request->password);
        $client->email_verified_at = now(); // The act of setting a password verifies their email.
        $client->invitation_token = null;      // Invalidate the token so it can't be used again.
        $client->invitation_expires_at = null;
        $client->save();

        // Log the newly registered client in using the 'client' guard.
        Auth::guard('client')->login($client);

        // Redirect them to their new dashboard.
        return redirect()->route('client.dashboard')->with('success', 'Your account has been activated!');
    }

    /**
     * Log the client out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the client login page after logout.
        return redirect()->route('client.login.form');
    }
    /**
 * Display the client registration form, linked to a specific business.
 *
 * @param string $code
 * @return \Illuminate\View\View
 */
public function showRegistrationForm(string $code)
{
    // Find the business user by their unique registration code.
    $business = User::where('registration_code', $code)->firstOrFail();

    return view('auth.client-register', ['business' => $business]);
}

/**
 * Handle a registration request for a new client.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function register(Request $request)
{
    $request->validate([
        'business_id' => 'required|exists:users,id', // Hidden field to pass the business ID
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:clients,email', // Ensure email is unique in the clients table
        'phone' => 'required|string|max:255',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Find the business this client is registering under
    $business = User::findOrFail($request->business_id);

    // Create the client and associate it with the business
    $client = $business->clients()->create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'email_verified_at' => now(), // Auto-verify on registration
    ]);

    // Log the new client in
    Auth::guard('client')->login($client);

    return redirect()->route('client.dashboard')->with('success', 'Welcome! Your account has been created.');
}
}
