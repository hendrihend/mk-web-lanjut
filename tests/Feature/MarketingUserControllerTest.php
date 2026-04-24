<?php

namespace Tests\Feature;

use App\Models\MarketingUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index page dapat diakses
     */
    public function test_index_page_loads_successfully(): void
    {
        $response = $this->get('/marketing-users');
        $response->assertStatus(200);
        $response->assertViewIs('marketing-users.index');
    }

    /**
     * Test create page dapat diakses
     */
    public function test_create_page_loads_successfully(): void
    {
        $response = $this->get('/marketing-users/create');
        $response->assertStatus(200);
        $response->assertViewIs('marketing-users.create');
    }

    /**
     * Test store user baru berhasil
     */
    public function test_store_creates_new_marketing_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'position' => 'Marketing Manager',
            'department' => 'Marketing',
            'territory' => 'Jakarta',
            'status' => 'active',
            'notes' => 'Test user',
        ];

        $response = $this->post('/marketing-users', $data);
        $response->assertRedirect('/marketing-users');
        $this->assertDatabaseHas('marketing_users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    /**
     * Test store validasi email unique
     */
    public function test_store_fails_with_duplicate_email(): void
    {
        MarketingUser::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'status' => 'active',
        ]);

        $data = [
            'name' => 'John Doe',
            'email' => 'jane@example.com',
            'status' => 'active',
        ];

        $response = $this->post('/marketing-users', $data);
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test show detail user
     */
    public function test_show_displays_user_details(): void
    {
        $user = MarketingUser::factory()->create();

        $response = $this->get("/marketing-users/{$user->id}");
        $response->assertStatus(200);
        $response->assertViewIs('marketing-users.show');
        $response->assertViewHas('marketingUser', $user);
    }

    /**
     * Test edit page loads
     */
    public function test_edit_page_loads_successfully(): void
    {
        $user = MarketingUser::factory()->create();

        $response = $this->get("/marketing-users/{$user->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('marketing-users.edit');
        $response->assertViewHas('marketingUser', $user);
    }

    /**
     * Test update user berhasil
     */
    public function test_update_modifies_user(): void
    {
        $user = MarketingUser::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'email' => $user->email,
            'status' => 'inactive',
        ];

        $response = $this->put("/marketing-users/{$user->id}", $data);
        $response->assertRedirect("/marketing-users/{$user->id}");

        $this->assertDatabaseHas('marketing_users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'status' => 'inactive',
        ]);
    }

    /**
     * Test delete user
     */
    public function test_destroy_deletes_user(): void
    {
        $user = MarketingUser::factory()->create();

        $response = $this->delete("/marketing-users/{$user->id}");
        $response->assertRedirect('/marketing-users');

        $this->assertModelMissing($user);
    }

    /**
     * Test search functionality
     */
    public function test_search_filters_users_by_name(): void
    {
        MarketingUser::factory()->create(['name' => 'John Doe']);
        MarketingUser::factory()->create(['name' => 'Jane Smith']);

        $response = $this->get('/marketing-users?search=John');
        $response->assertStatus(200);
    }

    /**
     * Test filter by status
     */
    public function test_filter_by_status(): void
    {
        MarketingUser::factory()->create(['status' => 'active']);
        MarketingUser::factory()->create(['status' => 'inactive']);

        $response = $this->get('/marketing-users?status=active');
        $response->assertStatus(200);
    }
}
