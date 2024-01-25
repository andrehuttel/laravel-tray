<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Sale;

class SaleApiTest extends TestCase
{

    /** @test */
    public function getAllSales()
    {
        $response = $this->get('/api/sales');
        $response->assertStatus(200);

        $sale = new Sale;

        $expected = [
            'seller_id',
            'value',
            'commission', 
            'sale_date'
        ];

        $arrayCompared = array_diff($expected, $sale->getFillable());
        $this->assertEquals(0, count($arrayCompared));
    }

    /** @test */
    public function createSale()
    {
        $data = [
            'seller_id' => 1,
            'value' => 100.00,
            'sale_date' => '2024-01-25',
        ];

        $response = $this->post('/api/sales', $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function updateSale()
    {
        $sale = Sale::factory()->create();

        $updatedData = [
            'value' => 200.00,
        ];

        $response = $this->put('/api/sales/'.$sale->id, $updatedData);

        $response->assertStatus(200);
    }

    /** @test */
    public function deleteSale()
    {
        $sale = Sale::factory()->create();

        $response = $this->delete('/api/sales/'.$sale->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('sales', [
            'id' => $sale->id,
        ]);
    }
}