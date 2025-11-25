<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserCanRegister()
    {
        $this->browse(function (Browser $browser) {
            $password = $this->faker->password(8);
            $browser->visit('/register')
                ->type('name', $this->faker->name)
                ->type('email', $this->faker->unique()->safeEmail)
                ->type('password', $password)
                ->type('password_confirmation', $password)
                ->press('Register')
                ->assertPathIs('/dashboard')
                ->assertSee('Dashboard');
        });
    }

    /**
     * Test user login and logout.
     *
     * @return void
     */
    public function testUserCanLoginAndLogout()
    {
        $user = User::factory()->create([
            'email' => 'tester@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Login
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password123')
                ->press('Login')
                ->assertPathIs('/dashboard')
                ->assertSee("Welcome, {$user->name}");

            // Logout
            $browser->press('Log Out')
                ->assertPathIs('/')
                ->assertGuest();
        });
    }
}