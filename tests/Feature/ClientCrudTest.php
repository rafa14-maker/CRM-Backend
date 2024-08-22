<?php

namespace Tests\Feature;

use App\Models\Client;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_data_is_posted(){

        $client = Client::factory()->create()->toArray();
    
        $response = $this->post(route('client.store'), $client);

        $response->assertStatus(200); // Adjust the status code as per your application

        $this->assertDatabaseHas('clients', $client); // Assuming 'queries' is the table name
        
    }
}
