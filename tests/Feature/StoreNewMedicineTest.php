<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Medicine;
use App\Models\User;

class StoreNewMedicineTest extends TestCase
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

    /**
     * 0,N/A
     */
    public function testStore00()
    {
        Pharmacy::factory()->create();
        Company::factory()->create();
        $this->actingAs($this->user)->post(route('medicines.store'), [
            'trade_name' => $this->faker->unique()->name,
            'scientist_name' => $this->faker->unique()->name,
            'amount' => 0,
            'weight' => random_int(5, 100),
            'status' => 'N/A',
            'pharmacy_id' => Pharmacy::first()->id,
            'company_id' => Company::first()->id,
        ])->assertSessionHas('newMedicineCreatedSuccessfully');
        $this->assertEquals(1, Medicine::count());
        $this->assertEquals(0, Medicine::first()->amount);
        $this->assertEquals('N/A', Medicine::first()->status);
    }

    /**
     * 1, Available
     */
    public function testStore01()
    {
        Pharmacy::factory()->create();
        Company::factory()->create();

        $this->actingAs($this->user)->post(route('medicines.store'), [
            'trade_name' => $this->faker->unique()->name,
            'scientist_name' => $this->faker->unique()->name,
            'amount' => 1,
            'weight' => random_int(5, 100),
            'status' => 'Available',
            'pharmacy_id' => Pharmacy::first()->id,
            'company_id' => Company::first()->id,
        ])->assertSessionHas('newMedicineCreatedSuccessfully');
        $this->assertEquals(1, Medicine::count());
        $this->assertEquals(1, Medicine::first()->amount);
        $this->assertEquals('Available', Medicine::first()->status);
    }

    /**
     * number, N/A
     */
    public function testStore02()
    {
        Pharmacy::factory()->create();
        Company::factory()->create();
        $this->actingAs($this->user)->post(route('medicines.store'), [
            'trade_name' => $this->faker->unique()->name,
            'scientist_name' => $this->faker->unique()->name,
            'amount' => $this->faker->numberBetween(50, 100),
            'weight' => random_int(5, 100),
            'status' => 'N/A',
            'pharmacy_id' => Pharmacy::first()->id,
            'company_id' => Company::first()->id,
        ])->assertSessionHas('errors');
        $this->assertEquals(0, Medicine::count());
    }
}
