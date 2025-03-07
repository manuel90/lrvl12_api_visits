<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Visit;
use App\Models\Visitor;

class VisitTest extends TestCase
{
    
    use RefreshDatabase;
    
    /**
     * Create visit test.
     */
    public function test_create_visit(): void
    {
        // 0 - User for authentication
        $user = User::factory()->make();
        
        // 1 - Generates fake visit data
        $testVisit = Visit::factory()->make();
        
        // 2 - Creates a visit with the fake visit data
        $response = $this->actingAs($user)->post('/api/visits', $testVisit->toArray());
        $response->assertStatus(201);
    }
    
    
    /**
     * Update visit test.
     */
    public function test_update_visit(): void
    {
        // 0 - User for authentication
        $user = User::factory()->make();
        
        // 1 - First create a visit
        $visit = Visit::factory()->create();
        
        // 2 - Generates fake visit data
        $testVisit = Visit::factory()->make();
        
        // 3 - Update the visit created with the fake visit data
        $response = $this->actingAs($user)->put("/api/visits/{$visit->id}", $testVisit->toArray());
        $response->assertStatus(200);
        
        // 4 - Get the data of the original visit
        $response = $this->actingAs($user)->get("/api/visits/{$visit->id}");
        $response->assertStatus(200);
        $data = $response->getData();
        
        // 5 - Check if the the original visit was udpated comparing the visits' descriptions
        $this->assertEquals($data->description, $testVisit->description);
    }
    
    /**
     * Delete visit test.
     */
    public function test_delete_visit(): void
    {
        // 0 - User for authentication
        $user = User::factory()->make();
        
        // 1 - First create a visit
        $visit = Visit::factory()->create();
        
        // 2 - Delete the visit created
        $response = $this->actingAs($user)->delete("/api/visits/{$visit->id}");
        $response->assertStatus(200);
    }
    
    /**
     * Get all visits test.
     */
    public function test_get_all_visits(): void
    {
        // 0 - User for authentication
        $user = User::factory()->make();
        
        // 1 - Request all the current visits
        $response = $this->actingAs($user)->get('/api/visits');
        $response->assertStatus(200);
        
        $listBefore = $response->getData();
        // 2 - Keep the amount of records
        $countBefore = count($listBefore);
        
        // 3 - Generates fake visit data
        $testVisit = Visit::factory()->make();
        
        // 4 - Creates a visit with the fake visit data
        $response = $this->actingAs($user)->post('/api/visits', $testVisit->toArray());
        $response->assertStatus(201);
        
        // 5 - Request all the current visits
        $response = $this->actingAs($user)->get('/api/visits');
        $response->assertStatus(200);
        $listCurrent = $response->getData();
        
        // 6 - Keep the amount of current records
        $countCurrent = count($listCurrent);
        
        // 7 - Request the visit created
        $this->assertEquals($countBefore + 1, $countCurrent);
    }
    
    
    /**
     * Get single visit test.
     */
    public function test_get_single_visit(): void
    {
        // 0 - User for authentication
        $user = User::factory()->make();
        
        // 1 - Generates fake visit data
        $testVisit = Visit::factory()->make();
        
        // 2 - Creates a visit with the fake visit data
        $response = $this->actingAs($user)->post('/api/visits', $testVisit->toArray());
        $response->assertStatus(201);
        
        $visit = $response->getData();
        
        // 3 - Request all the current visits
        $response = $this->actingAs($user)->get("/api/visits/{$visit->id}");
        $response->assertStatus(200);
        
        $this->assertEquals($testVisit->description, $visit->description);
    }
    
    /**
     * Add visitor to visit test.
     */
    public function test_add_visitor_to_visit(): void
    {
        // 0 - User for authentication
        $user = User::factory()->make();
        
        // 1 - First create a visit
        $visit = Visit::factory()->create();
        
        // 2 - Create a visitor information
        $visitor = Visitor::factory()->make();
        $data = array(
            ...$visitor->toArray(),
            'fullname' => $visitor->name,
        );
        
        // 3 - Delete the visit created
        $response = $this->actingAs($user)->post("/api/visits/{$visit->id}/visitors", $data);
        $response->assertStatus(200);
    }
    
}
