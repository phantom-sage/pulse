<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Country;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCountry()
    {
        Country::factory()->create();

        $this->assertNotEmpty(Country::all());
        $this->assertEquals(1, Country::count());
    }

    public function testShowCountry()
    {
        Country::factory()->create();

        $this->assertNotEmpty(Country::all());
        $this->assertEquals(1, Country::count());

        $this->assertEquals(Country::first()->name_en, Country::first()->name_en);
    }

    public function testUpdateCountry()
    {
        Country::factory()->create();

        $this->assertNotEmpty(Country::all());
        $this->assertEquals(1, Country::count());

        Country::first()->update([
            'name' => 'Updated name',
        ]);

        $this->assertNotEmpty(Country::all());
        $this->assertEquals(1, Country::count());
        $this->assertEquals(Country::first()->name, 'Updated name');
    }

    public function testDeleteCountry()
    {
        Country::factory()->create();

        $this->assertNotEmpty(Country::all());
        $this->assertEquals(1, Country::count());

        Country::first()->delete();

        $this->assertEmpty(Country::all());
        $this->assertEquals(0, Country::count());
    }

}
