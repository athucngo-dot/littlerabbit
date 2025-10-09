<?php
namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Customer;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_login_successfully()
    {
        // Create a customer
        $customer = Customer::create([
            'first_name' => 'James',
            'last_name' => 'Bond',
            'email' => 'james.bond@gmail.com',
            'password' => Hash::make('Agent*007'),
            'is_active' => true,
        ]);

        // Attempt login
        $response = $this->post('/auth/login', [
            'email' => 'james.bond@gmail.com',
            'password' => 'Agent*007',
        ]);

        // Assert redirected to home
        $response->assertRedirect('/');

        // Assert user is authenticated
        $this->assertAuthenticatedAs($customer, 'customer');
    }

    public function test_login_in_active_customer()
    {
          // Create a customer
          $customer = Customer::create([
            'first_name' => 'James',
            'last_name' => 'Bond',
            'email' => 'james.bond@gmail.com',
            'password' => Hash::make('Agent*007'),
            'is_active' => false,
        ]);

        $response = $this->post('/auth/login', [
            'email' => 'james.bond@gmail.com',
            'password' => Hash::make('Agent*007'),
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_login_requires_valid_data()
    {
          // Create a customer
          $customer = Customer::create([
            'first_name' => 'James',
            'last_name' => 'Bond',
            'email' => 'james.bond@gmail.com',
            'password' => Hash::make('Agent*007'),
            'is_active' => true,
        ]);

        $response = $this->post('/auth/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }
}