<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;


class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testRegister()
    {
        $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'phonenumber' => '0123456789',
        ])->assertRedirect(route('dashboard'));
        $this->assertEquals(Role::first()->user_id, User::first()->id);
    }
}
