<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_contact()
    {
        $data = Contact::factory()->make()->toArray();

        $response = $this->postJson('/api/contacts', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('contacts', [
            'email' => $data['email'],
        ]);
    }

    public function test_it_updates_a_contact()
    {
        $contact = Contact::factory()->create();
        $data = ['name' => 'Jane Doe'];

        $response = $this->putJson("/api/contacts/{$contact->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('contacts', $data);
    }

    public function test_it_deletes_a_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->deleteJson("/api/contacts/{$contact->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_it_lists_contacts()
    {
        Contact::factory()->count(3)->create();

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }
}
