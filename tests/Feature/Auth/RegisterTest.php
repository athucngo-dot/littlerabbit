<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_successfully()
    {
        $response = $this->post('/auth/register', [
            'firstname' => 'James',
            'lastname' => 'Bond',
            'register_email' => 'james.bond@gmail.com',
            'register_password' => 'Agent*007',
            'register_password_confirmation' => 'Agent*007',
        ]);

        $response->assertRedirect('/dashboard'); // Assert redirected to dashboard
        
        // Assert the customer is created in the database
        $this->assertDatabaseHas('customers', ['email' => 'james.bond@gmail.com']);
    }

    public function test_registration_requires_valid_data()
    {
        $response = $this->post('/auth/register', [
            'firstname' => '',
            'lastname' => '',
            'register_email' => 'invalid',
            'register_password' => 'nopass',
            'register_password_confirmation' => 'nopasswrong',
        ]);

        // Assert validation errors
        $response->assertSessionHasErrors(['firstname', 'lastname', 'register_email', 'register_password']);
    }
}