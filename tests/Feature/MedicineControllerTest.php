<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class MedicineControllerTest extends TestCase
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

        Medicine::factory()->create();
        $this->assertEquals(1, Medicine::count());
        $this->assertNotEmpty(Medicine::all());
    }

    public function testCreate()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user)->get(route('medicines.create'))->assertOk();
        $this->assertEquals(0, Medicine::count());
    }


    public function testStore()
    {
        $this->withoutExceptionHandling();

        Pharmacy::factory()->create();
        Company::factory()->create();

        $this->actingAs($this->user)
            ->post(route('medicines.store'), [
                'trade_name' => $this->faker->name,
                'scientist_name' => $this->faker->name,
                'amount' => $this->faker->randomDigit,
                'weight' => $this->faker->randomDigit,
                'status' => 'Available',
                'pharmacy_id' => Pharmacy::first()->id,
                'company_id' => Company::first()->id,
            ])
            ->assertRedirect(route('dashboard'))
            ->assertStatus(302);
    }

    public function testShow()
    {
        Medicine::create([
            'trade_name' => Str::random(8),
            'scientist_name' => Str::random(8),
            'amount' => 10,
            'weight' => random_int(5, 100),
            'status' => 'Available',
        ]);
        $this->assertEquals(Medicine::first()->id, Medicine::first()->id);
        $this->assertNull(Medicine::first()->pharmacy_id);
        $this->actingAs($this->user)->get(route('medicines.show', ['medicine' => Medicine::first()]))->assertOk();
    }

    public function testEdit()
    {
        Medicine::create([
            'trade_name' => Str::random(8),
            'scientist_name' => Str::random(8),
            'amount' => 10,
            'weight' => random_int(5, 100),
            'status' => 'Available',
        ]);
        $this->actingAs($this->user)->get(route('medicines.edit', ['medicine' => Medicine::first()]))->assertOk()->assertSee('trade_name');
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();

        Medicine::create([
            'trade_name' => Str::random(8),
            'scientist_name' => Str::random(8),
            'amount' => 10,
            'weight' => random_int(5, 100),
            'status' => 'Available',
        ]);

        $this->actingAs($this->user)->put(route('medicines.update', ['medicine' => Medicine::first()]), [
            'trade_name' => 'Trade name',
            'scientist_name' => Str::random(8),
            'amount' => 10,
            'weight' => random_int(5, 100),
            'status' => 'Available',
        ])->assertRedirect(route('medicines.index'))->assertSessionHas('medicineUpdatedSuccessfully');

        $this->assertEquals(Medicine::first()->trade_name, 'Trade name');
        $this->assertEquals(1, Medicine::count());
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        Medicine::create([
            'trade_name' => Str::random(8),
            'scientist_name' => Str::random(8),
            'amount' => 10,
            'weight' => random_int(5, 100),
            'status' => 'Available',
        ]);

        $this->actingAs($this->user)->delete(route('medicines.destroy', ['medicine' => Medicine::first()]))
        ->assertRedirect(route('medicines.index'))
        ->assertSessionHas('medicineDeletedSuccessfully');

        $this->assertNull(Medicine::first());
        $this->assertEquals(0, Medicine::count());
    }
}
