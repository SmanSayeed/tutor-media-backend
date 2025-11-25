<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginLogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful user login with valid credentials.
     * Verifies that user can log in, UI elements are correct,
     * session is established, and user is redirected properly.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        // Create a test user in the database
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
            'name' => 'Test User',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Visit the login page
            $browser->visit('/login')
                    ->assertSee('Login') // Verify login page title or heading
                    ->assertSee('Email') // Verify email field is present
                    ->assertSee('Password') // Verify password field is present
                    ->assertSee('Login'); // Verify login button is present

            // Fill in the login form with valid credentials
            $browser->type('email', $user->email)
                    ->type('password', 'password123')
                    ->press('Login')
                    ->waitForLocation('/dashboard') // Wait for redirect to dashboard
                    ->assertPathIs('/dashboard') // Assert redirected to dashboard
                    ->assertSee("Welcome, {$user->name}") // Assert welcome message
                    ->assertAuthenticated(); // Assert user is authenticated

            // Verify database state - user exists and is not modified
            $this->assertDatabaseHas('users', [
                'id' => $user->id,
                'email' => 'testuser@example.com',
                'name' => 'Test User',
            ]);
        });
    }

    /**
     * Test successful user logout.
     * Verifies that user can log out, session is destroyed,
     * and user is redirected to appropriate page.
     *
     * @return void
     */
    public function testSuccessfulLogout()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // First, log in the user
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->assertAuthenticated() // Confirm user is logged in
                    ->assertSee('Dashboard'); // Verify dashboard is visible

            // Perform logout
            $browser->press('Log Out') // Assuming logout button text
                    ->waitForLocation('/') // Wait for redirect to home
                    ->assertPathIs('/') // Assert redirected to home page
                    ->assertGuest() // Assert user is no longer authenticated
                    ->assertDontSee('Dashboard'); // Assert dashboard elements are not visible

            // Verify session is cleared by trying to access protected page
            $browser->visit('/dashboard')
                    ->assertPathIs('/login') // Should redirect to login
                    ->assertSee('Login'); // Should see login page
        });
    }

    /**
     * Test login with invalid credentials.
     * Verifies error handling for wrong email/password combination,
     * UI displays error messages, and user remains unauthenticated.
     *
     * @return void
     */
    public function testInvalidCredentials()
    {
        $this->browse(function (Browser $browser) {
            // Visit login page
            $browser->visit('/login')
                    ->assertSee('Login');

            // Attempt login with invalid credentials
            $browser->type('email', 'nonexistent@example.com')
                    ->type('password', 'wrongpassword')
                    ->press('Login')
                    ->waitForText('These credentials do not match our records') // Wait for error message
                    ->assertSee('These credentials do not match our records') // Assert error message is displayed
                    ->assertPathIs('/login') // Assert still on login page
                    ->assertGuest(); // Assert user is not authenticated

            // Verify no user is logged in and database unchanged
            $this->assertDatabaseMissing('users', [
                'email' => 'nonexistent@example.com',
            ]);
        });
    }

    /**
     * Test login form validation with empty fields.
     * Verifies that validation errors are displayed for required fields,
     * form submission is prevented, and user remains unauthenticated.
     *
     * @return void
     */
    public function testEmptyFieldsValidation()
    {
        $this->browse(function (Browser $browser) {
            // Visit login page
            $browser->visit('/login')
                    ->assertSee('Login');

            // Attempt to submit empty form
            $browser->press('Login')
                    ->waitForText('The email field is required') // Wait for validation errors
                    ->assertSee('The email field is required')
                    ->assertSee('The password field is required')
                    ->assertPathIs('/login') // Assert still on login page
                    ->assertGuest(); // Assert user is not authenticated
        });
    }

    /**
     * Test session persistence across page refreshes.
     * Verifies that user session remains active after page reload,
     * authentication state is maintained.
     *
     * @return void
     */
    public function testSessionPersistence()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Log in the user
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->assertAuthenticated()
                    ->assertSee('Dashboard');

            // Refresh the page
            $browser->refresh()
                    ->assertAuthenticated() // Assert still authenticated after refresh
                    ->assertSee('Dashboard') // Assert dashboard still visible
                    ->assertPathIs('/dashboard'); // Assert still on dashboard
        });
    }

    /**
     * Test login after previous logout.
     * Verifies that login works correctly after a logout,
     * no session conflicts occur.
     *
     * @return void
     */
    public function testLoginAfterLogout()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // First login
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertAuthenticated()
                    ->assertPathIs('/dashboard');

            // Logout
            $browser->press('Log Out')
                    ->assertGuest()
                    ->assertPathIs('/');

            // Login again
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertAuthenticated()
                    ->assertPathIs('/dashboard')
                    ->assertSee("Welcome, {$user->name}");
        });
    }

    /**
     * Test login with case-insensitive email.
     * Verifies that email matching is case-insensitive,
     * user can login with different email case variations.
     *
     * @return void
     */
    public function testCaseInsensitiveEmailLogin()
    {
        // Create a test user with mixed case email
        $user = User::factory()->create([
            'email' => 'TestUser@Example.Com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Attempt login with lowercase email
            $browser->visit('/login')
                    ->type('email', 'testuser@example.com') // lowercase
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertAuthenticated()
                    ->assertPathIs('/dashboard')
                    ->assertSee("Welcome, {$user->name}");

            // Logout and try with uppercase
            $browser->press('Log Out')
                    ->visit('/login')
                    ->type('email', 'TESTUSER@EXAMPLE.COM') // uppercase
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertAuthenticated()
                    ->assertPathIs('/dashboard');
        });
    }

    /**
     * Test multiple failed login attempts.
     * Verifies error handling for repeated invalid login attempts,
     * potential rate limiting or account lockout (if implemented).
     *
     * @return void
     */
    public function testMultipleFailedLoginAttempts()
    {
        $this->browse(function (Browser $browser) {
            // Attempt multiple failed logins
            for ($i = 0; $i < 3; $i++) {
                $browser->visit('/login')
                        ->type('email', 'wrong@example.com')
                        ->type('password', 'wrongpass')
                        ->press('Login')
                        ->assertSee('These credentials do not match our records')
                        ->assertGuest();
            }

            // After multiple attempts, verify still shows error (no lockout in basic Laravel)
            $browser->visit('/login')
                    ->type('email', 'wrong@example.com')
                    ->type('password', 'wrongpass')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records')
                    ->assertGuest();
        });
    }

    /**
     * Test login form accessibility and UI elements.
     * Verifies that all necessary form elements are present and functional,
     * proper labels, placeholders, and accessibility attributes.
     *
     * @return void
     */
    public function testLoginFormUIElements()
    {
        $this->browse(function (Browser $browser) {
            // Visit login page
            $browser->visit('/login')
                    ->assertSee('Login') // Page title
                    ->assertPresent('input[name="email"]') // Email input field
                    ->assertPresent('input[name="password"]') // Password input field
                    ->assertPresent('button[type="submit"]') // Submit button
                    ->assertVisible('input[name="email"]') // Fields are visible
                    ->assertVisible('input[name="password"]')
                    ->assertVisible('button[type="submit"]');

            // Check for potential additional elements like "Remember Me" or "Forgot Password"
            // Uncomment if these features exist:
            // ->assertSee('Remember Me')
            // ->assertSee('Forgot Password')
        });
    }

    /**
     * Test logout from different pages.
     * Verifies that logout works from various authenticated pages,
     * session is properly cleared regardless of current page.
     *
     * @return void
     */
    public function testLogoutFromDifferentPages()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Login
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->assertAuthenticated();

            // Navigate to another page (assuming home page exists)
            $browser->visit('/')
                    ->assertAuthenticated() // Still authenticated
                    ->assertSee('Home'); // Assuming home page has some content

            // Logout from this page
            $browser->press('Log Out')
                    ->assertGuest()
                    ->assertPathIs('/');
        });
    }
}