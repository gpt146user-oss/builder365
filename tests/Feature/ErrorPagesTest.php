<?php

namespace Tests\Feature;

use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    public function test_custom_error_pages_render_successfully(): void
    {
        $codes = ['404', '419', '403', '500', '203'];

        foreach ($codes as $code) {
            $this->assertTrue(view()->exists("errors.{$code}"), "View errors.{$code} should exist.");
            
            $rendered = view("errors.{$code}")->render();
            $this->assertStringContainsString($code, $rendered);
            $this->assertStringContainsString('Builder360 ERP CRM', $rendered);
        }
    }

    public function test_error_preview_route_renders_view(): void
    {
        $response = $this->get('/errors/404');
        $response->assertStatus(404);
        $response->assertSee('Page Not Found');

        $response = $this->get('/errors/419');
        $response->assertStatus(419);
        $response->assertSee('Page Session Expired');

        $response = $this->get('/errors/403');
        $response->assertStatus(403);
        $response->assertSee('Access Forbidden');

        $response = $this->get('/errors/500');
        $response->assertStatus(500);
        $response->assertSee('Internal Server Error');

        $response = $this->get('/errors/203');
        $response->assertStatus(203);
        $response->assertSee('Non-Authoritative Information');
    }
}
