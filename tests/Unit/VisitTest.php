<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Visit;

class VisitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a Visit record can be created.
     */
    public function test_visit_can_be_created()
    {
        // Define sample data for creating a Visit record.
        $visitData = [
            'start_date' => '2030-11-25 05:00:00',
            'end_date' => '2030-11-25 07:00:00',
            'description' => fake()->sentence(),
            'status' => Visit::STATUS_PENDING,
        ];

        // Create a Visit record using the model's create method.
        $visit = Visit::create($visitData);

        // Assert the instance is of type Visit.
        $this->assertInstanceOf(Visit::class, $visit);

        // Assert the database has a record with the provided data.
        $this->assertDatabaseHas('visits', [
            'id'           => $visit->id,
            'start_date' => '2030-11-25 05:00:00',
        ]);
    }

    /**
     * Test that a Visit record can be read.
     */
    public function test_visit_can_be_read()
    {
        // Create a Visit record using the factory.
        $visit = Visit::factory()->create([
            'start_date' => '2030-11-25 05:00:00',
            'end_date' => '2030-11-25 07:00:00',
            'description' => fake()->sentence(),
            'status' => Visit::STATUS_PENDING,
        ]);

        // Retrieve the Visit record from the database.
        $foundVisit = Visit::find($visit->id);

        // Assert the record is found and its attributes match.
        $this->assertNotNull($foundVisit);
        $this->assertEquals('2030-11-25 07:00:00', $foundVisit->end_date);
    }

    /**
     * Test that a Visit record can be updated.
     */
    public function test_visit_can_be_updated()
    {
        // Create a Visit record.
        $visit = Visit::factory()->create([
            'start_date' => '2030-11-25 05:00:00',
            'end_date' => '2030-11-25 07:00:00',
            'description' => fake()->sentence(),
            'status' => Visit::STATUS_ACTIVE,
        ]);

        // Update the visitor_name field.
        $visit->update([
            'end_date' => '2030-11-25 06:30:00',
        ]);

        // Assert that the updated data exists in the database.
        $this->assertDatabaseHas('visits', [
            'id'           => $visit->id,
            'end_date' => '2030-11-25 06:30:00',
        ]);
    }

    /**
     * Test that a Visit record can be deleted.
     */
    public function test_visit_can_be_deleted()
    {
        // Create a Visit record.
        $visit = Visit::factory()->create();

        // Store the ID to verify deletion.
        $visitId = $visit->id;

        // Delete the Visit record.
        $visit->delete();

        // Assert the record has been deleted.
        $this->assertDatabaseMissing('visits', ['id' => $visitId]);
    }
}
