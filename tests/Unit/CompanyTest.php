<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Company;
use App\Models\Medicine;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllCompany()
    {
        $this->withoutExceptionHandling();

        $this->assertEmpty(Company::all());
    }

    public function testCreateNewCompany()
    {
        Company::create([
            'name' => 'Company 1',
        ]);

        $this->assertEquals(1, Company::count());
    }

    public function testCreateMoreThanOneNewCompany()
    {
        Company::factory()->count(100)->create();
        $this->assertEquals(100, Company::count());
    }

    public function testUpdateCompany()
    {
        Company::factory()->create();
        Company::first()->update([
            'name' => 'Updated company name',
        ]);

        $this->assertEquals(1, Company::count());
        $this->assertEquals(Company::first()->name, 'Updated company name');
    }

    public function testDeleteACompany()
    {
        Company::create([
            'name' => 'Company 1',
        ]);
        Company::first()->delete();

        $this->assertEquals(0, Company::count());
    }

    public function testSpecificCompanyIsExists()
    {
        $this->withoutExceptionHandling();

        $this->assertNull(Company::find(1));
    }

    public function testCompanyHasManyMedicines()
    {
        $this->withoutExceptionHandling();

        Company::factory()->create();
        Medicine::factory()->create();
        $medicine = Medicine::first();
        $medicine->company_id = Company::first()->id;
        $medicine->save();

        $this->assertEquals(1, Company::count());
        $this->assertEquals(1, Medicine::count());

        $this->assertNotEmpty(Company::first()->medicines());

        $this->assertEquals(Company::first()->name, Medicine::first()->company->name);
        $this->assertEquals(Company::first()->id, Medicine::first()->company_id);
        $this->assertEquals(Company::first()->medicines[0]->id, Medicine::first()->id);
    }
}
