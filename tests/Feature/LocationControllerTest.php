<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var \App\Models\User $user
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $this->withoutExceptionHandling();

        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        $this->actingAs($this->user)->get(route('locations.index'))
        ->assertOk()
        ->assertStatus(200);

        $this->assertEquals(1, Location::count());
    }

    public function testStore()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user)->post(route('locations.store'), [
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ])->assertRedirect(route('locations.index'))->assertSessionHas('newLocationCreatedSuccessfully');
    }

    public function testCreate()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user)->get(route('locations.create'))
        ->assertOk()
        ->assertStatus(200)
        ->assertSee('create new location');
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();

        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        $this->actingAs($this->user)->put(route('locations.update', ['location' => Location::first()]), [
            'address' => 'Updated address',
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ])->assertRedirect(route('locations.index'))
        ->assertSessionHas('locationUpdatedSuccessfully');

        $this->assertEquals('Updated address', Location::first()->address);
    }

    public function testShow()
    {
        $this->withoutExceptionHandling();

        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        $this->actingAs($this->user)->get(route('locations.show', ['location' => Location::first()]))
        ->assertOk()
        ->assertStatus(200);
    }

    public function testEdit()
    {
        $this->withoutExceptionHandling();

        Location::create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        $this->actingAs($this->user)->get(route('locations.edit', ['location' => Location::first()]))
        ->assertOk()
        ->assertStatus(200);
    }


    public function testDestroy()
    {
        $this->withExceptionHandling();

        Location::Create([
            'address' => $this->faker->address,
            'longitude' => $this->faker->numberBetween(10, 1000),
            'latitude' => $this->faker->numberBetween(10, 1000),
        ]);

        $this->actingAs($this->user)->delete(route('locations.destroy', Location::first()))
        ->assertRedirect(route('locations.index'))
        ->assertSessionHas('locationDeletedSuccessfully');
    }
}
