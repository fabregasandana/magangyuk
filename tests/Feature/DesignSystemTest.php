<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DesignSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_keeps_the_authentication_form_and_theme_control(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('data-theme="light"', false)
            ->assertSee('data-theme-toggle', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="remember"', false)
            ->assertSee('data-action="toggle-password"', false)
            ->assertSee('data-split-text', false)
            ->assertSee('data-anime-stagger', false)
            ->assertSee('login-spinner', false)
            ->assertDontSee('fonts.googleapis.com', false);
    }

    public function test_landing_page_wires_each_animation_layer_to_a_distinct_element(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('data-split-text', false)
            ->assertSee('data-anime-stagger', false)
            ->assertSee('data-anime-draw', false)
            ->assertSee('data-webgl-bg', false)
            ->assertSee('data-canvas-ripple', false)
            ->assertSee('data-parallax', false)
            ->assertSee('data-flow-stage', false)
            ->assertSee('data-flow-card', false)
            ->assertSee('data-activity-stage', false)
            ->assertSee('data-activity-reset', false)
            ->assertSee('data-gallery-accordion', false)
            ->assertSee('data-gallery-panel', false)
            ->assertSee('data-dot-grid', false)
            ->assertSee('data-footer-reveal', false)
            ->assertSee('data-footer-wordmark', false)
            ->assertSee('data-tilt', false);
    }

    public function test_all_dashboard_layouts_start_light_and_share_accessible_navigation(): void
    {
        foreach (['layouts.dashboardUser', 'layouts.pembimbing', 'layouts.admin'] as $layout) {
            $this->withViewErrors([])->view($layout)
                ->assertSee('data-theme="light"', false)
                ->assertSee('app-shell', false)
                ->assertSee('x-data="appChrome"', false)
                ->assertSee('komdigi-theme', false)
                ->assertSee('komdigi-sidebar-pinned', false)
                ->assertSee("root.dataset.sidebarCollapsed = 'true'", false)
                ->assertSee('data-sidebar-pin', false)
                ->assertSee('sidebar-account', false)
                ->assertSee('id="main-content"', false)
                ->assertSee('aria-controls="app-sidebar"', false)
                ->assertSee('data-theme-toggle', false)
                ->assertSee('command-backdrop', false)
                ->assertSee('Menu lainnya')
                ->assertDontSee('@fonts', false)
                ->assertDontSee('fonts.googleapis.com', false);
        }
    }

    public function test_shared_editorial_header_preserves_data_and_actions(): void
    {
        $this->view('layouts.dashboard-hero', [
            'kicker' => 'Ruang kerja',
            'title' => 'Halo, peserta',
            'description' => 'Ringkasan aktivitas magang.',
            'meta' => [['icon' => 'calendar-days', 'label' => 'Hari ini']],
            'mini' => [['label' => 'Peserta', 'value' => 3]],
            'actions' => [['label' => 'Buka', 'href' => '/dashboard', 'icon' => 'arrow-right']],
        ])
            ->assertDontSee('data-dashboard-webgl', false)
            ->assertSee('data-split-text', false)
            ->assertSee('Halo, peserta')
            ->assertSee('Hari ini')
            ->assertSee('dash-hero-mini', false)
            ->assertSee('dash-hero-actions', false)
            ->assertSee('href="/dashboard"', false);
    }

    public function test_mobile_navigation_does_not_hide_secondary_role_features(): void
    {
        $routes = [
            'peserta' => ['peserta.izin', 'peserta.sertifikat', 'peserta.grafik', 'peserta.profil'],
            'pembimbing' => ['pembimbing.penilaianpeserta', 'pembimbing.laporanbimbingan', 'pembimbing.profile'],
            'admin' => ['admin.cms', 'admin.kelola-penilaian', 'admin.feature-pendukung'],
        ];

        foreach ($routes as $role => $names) {
            $view = $this->view('layouts.navigation', ['role' => $role]);
            foreach ($names as $name) {
                $view->assertSee(route($name), false);
            }
            $view->assertSee('data-navigation-close', false);
        }
    }
}
