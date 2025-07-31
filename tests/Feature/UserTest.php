<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->postJson('api/register', [
            'name' => 'User test',
            'email' => 'usertest@gmail.com',
            'password' => 'test12345',
            'password_confirmation' => 'test12345'
        ]);
        
        $response->assertCreated()
                ->assertJsonStructure(['success', 'message', 'data']);
    }

    public function test_user_can_view_own_profile()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('api/users/me');

        $response->assertOk()
                ->assertJson([
                    'email' => $user->email
                ]);
    }

    public function test_user_can_update_own_profile()
    {
        $user = User::factory()->create();
        $tokenUser = $user->createToken('auth_token')->plainTextToken;

        $response = $this->putJson('api/users/me', [
            'email' => 'testeNovo@gmail.com',
            'name' => $user->name
        ], ['Authorization' => "Bearer $tokenUser"]);

        $response->assertOk();
    }

    /*public function test_user_cannot_update_other_user_profile() 
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Sanctum::actingAs($otherUser);

        $response = $this->putJson('api/users/me', [
            'email' => 'testeNovo@gmail.com',
            'name' => $user->name
        ], ['Authorization' => "Bearer $tokenUser"]);

        $response->assertForbidden();
    }*/

    public function test_user_client_cannot_create_moderator()
    {
        //
    }
}