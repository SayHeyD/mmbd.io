<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexPageTest extends TestCase
{
    /**
     * A basic test example.
     */

    public function test_if_the_index_route_returns_a_200_status_code(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
