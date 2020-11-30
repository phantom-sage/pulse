<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Tests\Browser\Pages\Login;

use App\Models\User;

class LoginTest extends DuskTestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->typeSlowly('@email', $this->faker->unique()->safeEmail, 300)
                    ->pause(1000)
                    ->typeSlowly('@password', 'password', 300)
                    ->pause(1000)
                    ->check('@rememberMeCheckBox')
                    ->screenshot('login')
                    ->pause(1000)
                    ->press('@loginButton')
                    ->assertPathIs('/login')
                    ->assertSee('LOGIN')
                    ->assertTitle('Pulse')
                    ->pause(1000);
            $this->assertEquals(0, User::count());
        });
    }
}
