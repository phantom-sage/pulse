<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomeTest extends DuskTestCase
{
    use RefreshDatabase;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->withoutExceptionHandling();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Trade');
        });
    }

    public function testDashboard()
    {
        $this->withoutExceptionHandling();

        $this->browse(function (Browser $browser) {
            $browser->visit(route('dashboard'))
                    ->assertSee('LOGIN')
                    ->screenshot('dashboard');
        });
    }
}
