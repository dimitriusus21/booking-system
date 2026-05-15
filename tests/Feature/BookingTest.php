<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\Organization;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_loads()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(302); // редирект после регистрации
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_services_page_loads()
    {
        $response = $this->get('/services');
        $response->assertStatus(200);
    }

    public function test_organizations_page_loads()
    {
        $response = $this->get('/organizations');
        $response->assertStatus(200);
    }
}
