<?php

namespace Tests\Feature\Index;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexPageTest extends TestCase
{
    /**
     * Test if the index page returns a 200 status code
     *
     * @test
     */
    public function index_route_returns_a_200_status_code(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_ci_failure_step() {
        $this->fail();
    }
}
