<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Visitor;

class VisitorTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test that a Visitor record can be created.
     */
    public function test_visitor_can_be_created()
    {
        $visitorData = [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ];

        // Create a visitor record.
        $visitor = Visitor::create($visitorData);

        // Verify that the instance is a Visitor and data exists in the database.
        $this->assertInstanceOf(Visitor::class, $visitor);
        $this->assertDatabaseHas('visitors', $visitorData);
    }

    /**
     * Test that a Visitor record can be read.
     */
    public function test_visitor_can_be_read()
    {
        // Use the factory to create a visitor record.
        $visitor = Visitor::factory()->create([
            'name'  => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        // Retrieve the visitor record by its id.
        $foundVisitor = Visitor::find($visitor->id);

        $this->assertNotNull($foundVisitor);
        $this->assertEquals('Jane Doe', $foundVisitor->name);
        $this->assertEquals('jane@example.com', $foundVisitor->email);
    }

    /**
     * Test that a Visitor record can be updated.
     */
    public function test_visitor_can_be_updated()
    {
        // Create a visitor record.
        $visitor = Visitor::factory()->create([
            'name'  => 'Alice',
            'email' => 'alice@example.com',
        ]);

        // Update the visitor's information.
        $visitor->update([
            'name'  => 'Alice Updated',
            'email' => 'alice_updated@example.com',
        ]);

        // Verify that the database has the updated values.
        $this->assertDatabaseHas('visitors', [
            'id'    => $visitor->id,
            'name'  => 'Alice Updated',
            'email' => 'alice_updated@example.com',
        ]);
    }

    /**
     * Test that a Visitor record can be deleted.
     */
    public function test_visitor_can_be_deleted()
    {
        // Create a visitor record.
        $visitor = Visitor::factory()->create([
            'name'  => 'Bob',
            'email' => 'bob@example.com',
        ]);

        $visitorId = $visitor->id;

        // Delete the visitor record.
        $visitor->delete();

        // Verify that the record has been removed from the database.
        $this->assertDatabaseMissing('visitors', ['id' => $visitorId]);
    }
}
