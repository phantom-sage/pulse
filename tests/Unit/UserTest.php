<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\Pharmacy;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUserHasManyPharmacies()
    {
        $this->withoutExceptionHandling();

        User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phonenumber' => $this->faker->unique()->numberBetween(0, 10),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $pharmacy = new Pharmacy();
        $pharmacy->name = $this->faker->company;
        $pharmacy->user_id = User::first()->id;
        $pharmacy->save();

        $this->assertNotNull(Pharmacy::first()->user_id);

        $this->assertEquals(Pharmacy::first()->user->name, User::first()->name);
    }


    public function testUserHasOneRole()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phonenumber' => $this->faker->unique()->numberBetween(0, 10),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $role = new Role();
        $role->name = 'adminstrator';
        $role->user_id = $user->id;
        $role->save();

        $this->assertNotNull($user->role());
        $this->assertNotNull(Role::first()->user_id);

        $this->assertEquals(User::first()->name, Role::first()->user->name);
    }
}
