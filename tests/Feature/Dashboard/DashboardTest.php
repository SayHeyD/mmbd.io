<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_dashboard_page_returns_200_status_code(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
