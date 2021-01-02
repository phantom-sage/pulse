<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Tests\Browser\Pages\Register;
use App\Models\User;

class RegisterTest extends DuskTestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                    ->assertPathIs('/register')
                    ->assertSee('REGISTER')
                    ->typeSlowly('@name', $this->faker->name, 300)
                    ->pause(300)
                    ->typeSlowly('@email', $this->faker->unique()->safeEmail, 300)
                    ->pause(300)
                    ->typeSlowly('@password', 'password', 300)
                    ->pause(300)
                    ->typeSlowly('@passwordConfirmation', 'password', 300)
                    ->pause(300)
                    ->screenshot('register')
                    ->press('@submitButton')
                    ->assertSee('Dashboard')
                    ->assertPathIs('/dashboard')
                    ->screenshot('dashboard_after_register')
                    ->pause(1000);
        });
    }
}
