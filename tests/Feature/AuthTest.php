<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_register_with_duplicate_email()
    {
        $response = $this->postJson('api/register', [
            'name' => 'User test1',
            'email' => 'usertest@gmail.com',
            'password' => 'test1234567',
            'password_confirmation' => 'test1234567'
        ]);

        $response = $this->postJson('api/register', [
            'name' => 'User test2',
            'email' => 'usertest@gmail.com',
            'password' => 'test1234567',
            'password_confirmation' => 'test1234567'
        ]);
        
        $response->assertStatus(422);
    }

    public function test_authenticated_user_can_login()
    {
        User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $response = $this->postJson('api/login', [
            'email' => 'test@gmail.com',
            'password' => '12345678'
        ]);

        $response->assertOk();
    }

    public function test_login_fails_with_wrong_email()
    {
        User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $response = $this->postJson('api/login', [
            'email' => 'testerror@gmail.com',
            'password' => '12345678'
        ]);

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_access_protected_route()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('api/users/me');

        $response->assertOk();
    }

    public function test_unauthenticated_user_cannot_access_protected_route()
    {
        $response = $this->getJson('api/users/me');

        $response->assertUnauthorized();
    }
}
