<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a User record can be created.
     */
    public function test_user_can_be_created()
    {
        $userData = [
            'name'              => 'John Doe',
            'email'             => 'john@example.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('secret'),
            'remember_token'    => Str::random(10),
        ];

        // Create a new user record.
        $user = User::create($userData);

        // Assert the instance is a User and that the record exists in the database.
        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'id'    => $user->id,
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Test that a User record can be read.
     */
    public function test_user_can_be_read()
    {
        // Create a user using the factory.
        $user = User::factory()->create([
            'name'              => 'Jane Doe',
            'email'             => 'jane@example.com',
            'email_verified_at' => now(),
        ]);

        // Retrieve the user from the database.
        $foundUser = User::find($user->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals('Jane Doe', $foundUser->name);
        $this->assertEquals('jane@example.com', $foundUser->email);
    }

    /**
     * Test that a User record can be updated.
     */
    public function test_user_can_be_updated()
    {
        // Create a user record.
        $user = User::factory()->create([
            'name' => 'Alice',
        ]);

        // Update the user's name.
        $user->update([
            'name' => 'Alice Updated',
        ]);

        // Verify that the updated record exists in the database.
        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => 'Alice Updated',
        ]);
    }

    /**
     * Test that a User record can be deleted.
     */
    public function test_user_can_be_deleted()
    {
        // Create a user record.
        $user = User::factory()->create();

        $userId = $user->id;

        // Delete the user record.
        $user->delete();

        // Assert that the record is deleted.
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}
