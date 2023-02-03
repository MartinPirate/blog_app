<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{
    /**
     * test welcome page is loaded.
     *
     * @return void
     */
    public function test_welcome_page_is_loaded(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * test welcome page has posts.
     *
     * @return void
     */
    public function test_welcome_page_have_posts(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(
            [
                'user_id' => $user->id
            ]

        );

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->description);
    }

    /**
     * test Dashboard Page is loaded.
     *
     * @return void
     */
    public function test_dashboard_page_is_loaded(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200);
    }

    /**
     * test Dashboard Page is loaded.
     *
     * @return void
     */
    public function test_dashboard_page_is_have_users_posts(): void
    {

        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->description);
    }


    /**
     *
     * test can load the post details page
     * @return void
     */
    public function test_post_details_can_be_found(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->get('posts/'. $post->id);
        $response->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->description);


    }

    /**
     * tests users can only see their posts on the dashboard
     *
     * @return void
     */

    public function test_other_users_posts_are_not_found_on_the_dashboard(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user2->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200)
            ->assertDontSee($post->title)
            ->assertDontSee($post->description);

    }

    /**
     * Test a user can a create a post
     * @return void
     */
    public function test_authenticated_user_can_save_a_valid_post(): void
    {


        $user = User::factory()->create();
        $post = [
            'title' => 'This is a post title',
            'description' => 'This is a post description',
            'publishedAt' => now(),
        ];

        $response = $this->actingAs($user)
            ->post('/posts', $post);

        $response->assertStatus(302);


    }

    /**
     * test Guests can not save a post
     * @return void
     */
    public function test_guests_can_not_save_post(): void
    {
        $post = [
            'title' => 'This is a post title',
            'description' => 'This is a post description',
            'publishedAt' => now(),
        ];
        $response = $this->post('/posts', $post);

        $response->assertStatus(302);

    }

    /**
     * Test all fields are required
     * @return void
     */
    public function test_all_fields_are_required()
    {

        $user = User::factory()->create();
        $post = [
            'title' => '',
            'description' => '',
            'publishedAt' => ''
        ];

        $response = $this->actingAs($user)
            ->post('/posts', $post);


        $response->assertStatus(302);


        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertSee('The title field is required.');

    }


}
