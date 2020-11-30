<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class CompanyControllerTest extends TestCase
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
        $this->actingAs($this->user)->get(route('companies.index'))->assertOk()->assertStatus(200);
    }

    public function testStore()
    {
        $this->actingAs($this->user)->post(route('companies.store'), [
            'name' => $this->faker->company,
        ])->assertRedirect(route('companies.index'))
        ->assertStatus(302)
        ->assertSessionHas('newCompanyCreatedSuucessfully');
    }

    public function testShow()
    {
        Company::create([
            'name' => $this->faker->company,
        ]);
        $this->assertEquals(1, Company::count());
        $this->actingAs($this->user)->get(route('companies.show', ['company' => Company::first()]))
        ->assertOk()
        ->assertStatus(200);
    }

    public function testEdit()
    {
        Company::create([
            'name' => $this->faker->company,
        ]);
        $this->actingAs($this->user)->get(route('companies.edit', ['company' => Company::first()]))
        ->assertOk()
        ->assertStatus(200)
        ->assertSee(Company::first()->name);
    }

    public function testUpdate()
    {
        $this->withExceptionHandling();

        Company::factory()->create();

        $this->actingAs($this->user)->put(route('companies.update', ['company' => Company::first()]), [
            'name' => 'New company name',
        ])->assertRedirect(route('companies.index'))
        ->assertSessionHas('companyUpdatedSuccessfully');
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        Company::create(['name' => Str::random(8)]);
        $this->actingAs($this->user)->delete(route('companies.destroy', ['company' => Company::first()]))
        ->assertStatus(302)
        ->assertRedirect(route('companies.index'))
        ->assertSessionHas('companyDeletedSuccessfully');
    }
}
