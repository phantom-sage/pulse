<?php

namespace Tests\Feature\Api;

use App\Models\Medicine;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicineControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        $this->withoutExceptionHandling();

        Medicine::factory()->count(10)->create();

        $this->actingAs(User::factory()->create())->post('/api/medicine/all', [
            'medicineName' => 'scientist',
            'medicineSearchType' => 'scientist',
        ], [
            'Accept' => 'application/json',
            //'Authorization' => "Bearer",
        ])->assertStatus(200);
    }
}
