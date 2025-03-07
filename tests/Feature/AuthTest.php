<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

use App\Models\User;

class AuthTest extends TestCase
{
    
    use RefreshDatabase;
    
    /**
     * Login test.
     */
    public function test_login(): void
    {
        // 0 - Credentials mocking
        $email = fake()->unique()->safeEmail();
        $password = Str::random(10)."**72";
        
        // 1 - Mocking user's data
        $userData = [
            'fullname' => fake()->name(),
            'email' => $email,
            'email_verified_at' => null,
            'password' => $password,
            'remember_token' => Str::random(10),
        ];
        
        // 2 - Register a new user
        $response = $this->post('/api/register', $userData);
        $response->assertStatus(201);
        
        // 3 - Credentials
        $credentials = array(
            'email' => $email,
            'password' => $password,
        );
        
        // 4 - Login
        $response = $this->post('/api/login', $credentials);
        $response->assertStatus(200);
    }
    
    /**
     * Registration test.
     */
    public function test_register(): void
    {
        $email = fake()->unique()->safeEmail();
        $password = Str::random(10);
        
        // 0 - Mocking user data
        $userData = [
            'fullname' => fake()->name(),
            'email' => $email,
            'email_verified_at' => now(),
            'password' => bcrypt($password),
            'remember_token' => Str::random(10),
        ];
        
        // 1 - Register a new user
        $response = $this->post('/api/register', $userData);
        $response->assertStatus(201);
    }
}
