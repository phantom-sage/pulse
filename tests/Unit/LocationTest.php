<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Location;
use App\Models\Pharmacy;

class LocationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateLocation()
    {
        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        $this->assertEquals(1, Location::count());
    }

    public function testUpdateLocation()
    {
        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        Location::first()->update([
            'address' => 'Updated address',
        ]);

        $this->assertEquals('Updated address', Location::first()->address);
    }

    public function testDeleteLocation()
    {
        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        Location::first()->delete();
        $this->assertEquals(0, Location::count());
    }

    public function testLocationBelongsToPharmacy()
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

        $this->assertNotNull($location->pharmacy_id);
        $this->assertNotEmpty($pharmacy->locations());

        $this->assertEquals(Location::first()->pharmacy_id, Pharmacy::first()->id);
        $this->assertEquals(Pharmacy::first()->locations[0]->id, Location::first()->id);

    }
}
