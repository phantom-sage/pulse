<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function testHomeRoute()
    {
        $this->get('/')
        ->assertOk()
        ->assertViewIs('welcome');
    }

    public function testDashboard()
    {
        $this->get(route('dashboard'))
        ->assertRedirect(route('login'))
        ->assertStatus(302);
    }
}
