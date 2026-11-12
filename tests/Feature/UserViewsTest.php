<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserViewsTest extends TestCase
{
    public function test_guests_are_redirected_to_login_when_visiting_home(): void
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_home_page(): void
    {
        $user = new User([
            'nama' => 'Test Gamer',
            'email' => 'gamer@vortexplay.id',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSee('PLAY AND REPEAT');
        $response->assertSee('About us');
        $response->assertSee('VORTEX PLAY');
    }

    public function test_authenticated_user_can_view_rent_page(): void
    {
        $user = new User([
            'nama' => 'Test Gamer',
            'email' => 'gamer@vortexplay.id',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/rent');

        $response->assertStatus(200);
        $response->assertSee('Rent');
        $response->assertSee('Continue to Payment');
        $response->assertSee('Back to Homepage');
    }

    public function test_authenticated_user_can_view_about_page(): void
    {
        $user = new User([
            'nama' => 'Test Gamer',
            'email' => 'gamer@vortexplay.id',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Tentang Vortex Play');
    }
}
