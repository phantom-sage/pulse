<?php

namespace Tests\Unit;

use App\Models\Company;
use Tests\TestCase;
use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class MedicineTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateNewMedicine()
    {
        Medicine::factory()->create();

        $this->assertEquals(1, Medicine::count());
    }

    public function testUpdateExistingMedicineModel()
    {

        Medicine::factory()->create();

        $this->assertEquals(1, Medicine::count());
        $medicine = Medicine::first();
        $medicine->update(['trade_name' => 'Updated Trade name']);
        $medicine->refresh();
        $this->assertEquals('Updated Trade name', $medicine->trade_name);
    }

    public function testMedicineCanBelongsToPharmacy()
    {
        $this->withoutExceptionHandling();

        $pharmacy = Pharmacy::create([
            'name' => $this->faker->company,
        ]);

        $medicine = new Medicine();
        $medicine->trade_name = $this->faker->unique()->name;
        $medicine->scientist_name = $this->faker->unique()->name;
        $medicine->amount = random_int(5, 100);
        $medicine->weight = random_int(5, 100);
        $medicine->pharmacy_id = $pharmacy->id;
        $medicine->status = 'Available';
        $medicine->save();

        $this->assertEquals(Medicine::first()->pharmacy_id, Pharmacy::first()->id);
        $this->assertNotNull(Medicine::first()->pharmacy_id);
        $this->assertCount(1, Medicine::all());
        $this->assertCount(1, Pharmacy::all());
    }

    public function testMedicineBelongsToCompany()
    {
        Medicine::factory()->create();
        Company::factory()->create();

        $medicine = Medicine::first();
        $medicine->company_id = Company::first()->id;
        $medicine->save();

        $this->assertNotNull(Medicine::first()->company_id);
        $this->assertEquals(1, Medicine::count());
        $this->assertEquals(1, Company::count());

        $this->assertNotEmpty(Company::first()->medicines());

        $this->assertEquals(Medicine::first()->company->name, Company::first()->name);
        $this->assertEquals(Medicine::first()->company_id, Company::first()->id);
        $this->assertEquals(Medicine::first()->id, Company::first()->medicines[0]->id);

    }
}
