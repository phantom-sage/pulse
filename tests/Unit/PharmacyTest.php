<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;


use App\Models\Pharmacy;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Location;

class PharmacyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreatePharmacy()
    {
        $this->withoutExceptionHandling();

        Pharmacy::create([
            'name' => $this->faker->company,
        ]);

        $this->assertEquals(1, Pharmacy::count());
    }

    public function testPharmacyHasAtLeaseOneMedicine()
    {
        $this->withoutExceptionHandling();

        $pharmacy = new Pharmacy();
        $pharmacy->name = $this->faker->company;
        $pharmacy->save();

        $medicine = new Medicine();
        $medicine->trade_name = $this->faker->unique()->name;
        $medicine->scientist_name = $this->faker->unique()->name;
        $medicine->amount = random_int(5, 100);
        $medicine->weight = random_int(5, 100);
        $medicine->status = 'Available';
        $medicine->pharmacy_id = $pharmacy->id;
        $medicine->save();

        $this->assertEquals($pharmacy->medicines[0]->id, $medicine->id);
        $this->assertNotEmpty($pharmacy->medicines);
    }

    public function testPharmacyBelongsToOwner()
    {
        $this->withoutExceptionHandling();

        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phonenumber' => $this->faker->unique()->numberBetween(0, 10),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $pharmacy = new Pharmacy();
        $pharmacy->name = $this->faker->company;
        $pharmacy->user_id = $user->id;
        $pharmacy->save();

        $this->assertEquals($pharmacy->user->name, $user->name);
        $this->assertNotNull($pharmacy->user());
        $this->assertEquals(1, Pharmacy::count());
        $this->assertEquals(1, User::count());
    }

    public function testPharmacyHasManyLocations()
    {
        $pharmacy = new Pharmacy();
        $pharmacy->name = $this->faker->company;
        $pharmacy->save();

        $location = new Location();
        $location->address = $this->faker->address;
        $location->longitude = $this->faker->numberBetween(10, 50);
        $location->latitude = $this->faker->numberBetween(10, 50);
        $location->pharmacy_id = $pharmacy->id;
        $location->save();

        $this->assertEquals($pharmacy->locations[0]->id, $location->id);
        $this->assertEquals($pharmacy->id, $location->pharmacy_id);
        $this->assertNotEmpty($pharmacy->locations);

        $this->assertEquals(1, Pharmacy::count());
        $this->assertEquals(1, Location::count());

    }
}
