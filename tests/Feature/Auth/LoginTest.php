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
        // Create customers
        $this->createNewCustomers();

        // Attempt login
        $response = $this->post('/auth/login', [
            'email' => 'james.bond@gmail.com',
            'password' => 'Agent*007',
        ]);

        // fetch the user
        $customer = Customer::where('email', 'james.bond@gmail.com')
            ->where('is_active', true)
            ->first();

        // Assert redirected to dashboard
        $response->assertRedirect('/dashboard');

        // Assert user is authenticated
        $this->assertAuthenticatedAs($customer, 'customer');
    }

    public function test_login_in_active_customer()
    {
        // Create customers
        $this->createNewCustomers();

        // Make one customer inactive
        Customer::where('email', 'captain.america@gmail.com')->update(['is_active' => false]);
          
        $response = $this->post('/auth/login', [
            'email' => 'captain.america@gmail.com',
            'password' => Hash::make('Shield*01'),
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_login_requires_valid_data()
    {
        // Create customers
        $this->createNewCustomers();

        $response = $this->post('/auth/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /**
     * Helper to create customers
     */
    private function createNewCustomers(array $customers = []): void
    {
        if (empty($customers)) {
            $customers = [
                [
                    'first_name' => 'James',
                    'last_name' => 'Bond',
                    'email' => 'james.bond@gmail.com',
                    'password' => Hash::make('Agent*007'),
                    'is_active' => true,
                ],
                [
                    'first_name' => 'Captain',
                    'last_name' => 'America',
                    'email' => 'captain.america@gmail.com',
                    'password' => Hash::make('Shield*01'),
                    'is_active' => true,
                ],
                [
                    'first_name' => 'Iron',
                    'last_name' => 'Man',
                    'email' => 'iron.man@gmail.com',
                    'password' => Hash::make('Jarvis*123'),
                    'is_active' => true,
                ],
            ];
        }

        $this->createNew(Customer::class, $customers);
    }
}