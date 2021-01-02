<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

use App\Models\Role;
use App\Models\User;

class RoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateRole()
    {
        Role::factory()->create();
        $this->assertEquals(1, Role::count());
    }

    public function testShowRole()
    {
        Role::factory()->create();
        $this->assertEquals(Role::first()->name, Role::first()->name);
        $this->assertNotEmpty(Role::all());
        $this->assertEquals(1, Role::count());
    }


    public function testUpdateRole()
    {
        Role::factory()->create();
        Role::first()->update([
            'name' => 'My New Role name',
        ]);

        $this->assertNotEmpty(Role::all());
        $this->assertEquals(1, Role::count());
        $this->assertEquals(Role::first()->name, 'My New Role name');
    }


    public function testDeleteRole()
    {
        Role::factory()->create();

        $this->assertNotEmpty(Role::all());
        $this->assertEquals(1, Role::count());

        Role::first()->delete();
        $this->assertEmpty(Role::all());
        $this->assertEquals(0, Role::count());
    }

    public function testRoleBelongsToUser()
    {
        User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $role = new Role();
        $role->name = 'adminstrator';
        $role->user_id = User::first()->id;
        $role->save();

        $this->assertNotNull(Role::first()->user());
        $this->assertNotNull(User::first()->role());

        $this->assertEquals(Role::first()->user_id, User::first()->id);
        $this->assertEquals(Role::first()->user->name, User::first()->name);
    }

}
