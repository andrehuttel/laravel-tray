<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Seller;

class SellerApiTest extends TestCase
{
    /** @test */
    public function getAllSellers()
    {
        $response = $this->get('/api/sellers');
        $response->assertStatus(200);

        $seller = new Seller;

        $expected = [
            'name',
            'email'
        ];

        $arrayCompared = array_diff($expected, $seller->getFillable());
        $this->assertEquals(0, count($arrayCompared));

    }

    /** @test */
    public function createSeller()
    {
        $data = [
            'name' => 'Created by Test',
            'email' => 'unittest@example.com',
        ];

        $response = $this->post('/api/sellers', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJsonFragment([
                'name' => 'Created by Test',
                'email' => 'unittest@example.com',
            ]);
    }

    /** @test */
    public function updateSeller()
    {
        $seller = Seller::factory()->create([
            'name' => 'Initial Name',
            'email' => 'initial@example.com',
            'created_at' => '2024-01-25T12:35:19.000000Z',
            'updated_at' => '2024-01-25T12:35:19.000000Z'
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'created_at' => '2024-01-25T12:35:19.000000Z',
            'updated_at' => '2024-01-25T12:35:19.000000Z'
        ];

        $response = $this->put('/api/sellers/'.$seller->id, $updatedData);

        $response->assertStatus(200);
    }

    /** @test */
    public function deleteSeller()
    {
        $seller = Seller::factory()->create([
            'name' => 'To be deleted',
            'email' => 'delete@example.com',
        ]);

        $response = $this->delete('/api/sellers/'.$seller->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('sellers', [
            'id' => $seller->id,
        ]);
    }
}
