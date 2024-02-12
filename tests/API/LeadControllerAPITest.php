<?php

namespace Tests\API;

use App\Models\Client;
use App\Models\Lead;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeadControllerAPITest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * it test a new lead creation from a new client
     */
    public function test_store_lead_new_client(): void
    {
        $lead = Lead::factory()->make()->attributesToArray();
        $lead['name'] = $this->faker->firstName();
        $lead['phone'] = $this->faker->phoneNumber;

        $response = $this->json('post', route('leads.store'), $lead);
        $response->assertStatus(201);
    }

    /**
     * it test a new lead creation from an existing client
     */
    public function test_store_lead_from_existing_client(): void
    {
        $client = Client::factory()->create();
        $clientNewPhoneNumber = $this->faker->phoneNumber;
        $lead = Lead::factory()->make([
            'client_id' => $client->id,
            'email' => $client->email,
            'phone' => $clientNewPhoneNumber
        ])->attributesToArray();
        $lead['name'] = $client->name;
        $response = $this->json('post', route('leads.store'), $lead);
        $this->assertEquals($response->decodeResponseJson()['data']['client']['phone'], $clientNewPhoneNumber);

        $response->assertStatus(201);
    }

    /**
     * it test a new lead update
     */
    public function test_update_lead(): void
    {
        $client = Client::factory()->create();
        $lead = Lead::factory()->create(['client_id' => $client->id])->attributesToArray();
        $newMortgageRequestAmount = 251;
        $lead['mortgage_request_amount'] = $newMortgageRequestAmount;
        $response = $this->json('patch', route('leads.update', $lead['id']), $lead);
        $this->assertEquals($response->decodeResponseJson()['data']['mortgage_request_amount'], $newMortgageRequestAmount);

        $response->assertStatus(200);
    }

    /**
     * it test a get lead json details
     */
    public function test_get_lead(): void
    {
        $client = Client::factory()->create();
        $lead = Lead::factory()->create(['client_id' => $client->id])->attributesToArray();
        $response = $this->json('get', route('leads.show', $lead['id']));
        $responseData = $response->decodeResponseJson()['data'];
        $this->assertEquals($lead['email'], $responseData['email']);

        $response->assertStatus(200);
    }

    /**
     * it tests a 404 for a non existing Lead
     */
    public function test_show_for_no_existing_lead(): void
    {
        $response = $this->json('get', route('leads.show', 150));
        $response->assertStatus(404);
    }

    /**
     * it test a destroy existing lead
     */
    public function test_destroy_lead(): void
    {
        $client = Client::factory()->create();
        $lead = Lead::factory()->create(['client_id' => $client->id])->attributesToArray();
        $response = $this->json('delete', route('leads.destroy', $lead['id']), $lead);
        $response->assertStatus(200);
    }
}
