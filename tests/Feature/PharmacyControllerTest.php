<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class PharmacyControllerTest extends TestCase
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
        $this->actingAs($this->user)->get('/pharmacies')
        ->assertOk();
    }

    public function testCreate()
    {
        $this->actingAs($this->user)
            ->get(route('pharmacies.create'))
            ->assertOk()
            ->assertStatus(200)
            ->assertViewIs('pharmacy.create');
    }


    public function testStore()
    {
        Location::factory()->create();

        $this->actingAs($this->user)->post(route('pharmacies.store'), [
            'name' => Str::random(8),
            'location_id' => Location::first()->id,
        ])->assertRedirect(route('dashboard'));
    }


    public function testShow()
    {
//        $this->actingAs($this->user)->post(route('pharmacies.store'), [
//            'name' => Str::random(8),
//            'location_id' => null,
//        ]);
        Pharmacy::factory()->create();

        $this->actingAs($this->user)
            ->get(route('pharmacies.show', ['pharmacy' => Pharmacy::first()]))
            ->assertOk();
    }

    public function testEdit()
    {
//        $this->actingAs($this->user)->post(route('pharmacies.index'), [
//            'name' => Str::random(8),
//        ]);
        Pharmacy::factory()->create();
        $this->actingAs($this->user)->get(route('pharmacies.edit', Pharmacy::first()))->assertOk();
    }

    public function testUpdate()
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

        $r = new Role();
        $r->name = 'administrator';
        $r->user_id = $user->id;
        $r->save();

        $p = new Pharmacy();
        $p->name = $this->faker->name;
        $p->user_id = $user->id;
        $p->save();

        Location::factory()->create();

        $this->actingAs($user)->put(route('pharmacies.update', ['pharmacy' => Pharmacy::first()]), [
            'name' => $this->faker->name,
            'location_id' => Location::first()->id,
        ])->assertStatus(302)
        ->assertSessionHas('pharmacyUpdatedSuccessfully');
    }

    public function testDelete()
    {
        $this->withoutExceptionHandling();

        Pharmacy::factory()->create();
        $p = Pharmacy::first();
        $this->actingAs($this->user)->delete(route('pharmacies.destroy', $p))
        ->assertRedirect(route('pharmacies.index'))
        ->assertSessionHas('pharmacyDeleteSuccessfully');
    }
}
