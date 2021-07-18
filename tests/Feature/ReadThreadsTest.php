<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Thread|Collection|Model|mixed
     */
    protected Thread $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }
    /**
     * @test
     *
     * A basic test example.
     *
     * @return void
     */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_reply_in_a_thread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }
}
