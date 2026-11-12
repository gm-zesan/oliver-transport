<?php

declare(strict_types=1);

use Database\Seeders\CouponSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\PricingSettingSeeder;
use Database\Seeders\RouteSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\VehicleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed([
        LocationSeeder::class,
        VehicleSeeder::class,
        RouteSeeder::class,
        ScheduleSeeder::class,
        CouponSeeder::class,
        PricingSettingSeeder::class,
    ]);
});

test('switching locale to fr updates session and redirects back', function (): void {
    $response = $this->get(route('locale.switch', ['locale' => 'fr']));

    $response->assertRedirect();
    $response->assertSessionHas('locale', 'fr');
    $response->assertCookie('locale', 'fr');
});

test('switching locale to an invalid language defaults back to en', function (): void {
    $response = $this->get(route('locale.switch', ['locale' => 'es']));

    $response->assertRedirect();
    $response->assertSessionHas('locale', 'en');
});

test('homepage renders french translations when session locale is fr', function (): void {
    $response = $this->withSession(['locale' => 'fr'])->get(route('home'));

    $response->assertOk()
        ->assertSee('Accueil')
        ->assertSee('À propos')
        ->assertSee('Services')
        ->assertSee('Contact')
        ->assertSee('FAQ')
        ->assertSee('Connexion')
        ->assertSee('Montréal → Toronto')
        ->assertSee('Toronto → Montréal');
});

test('homepage renders english translations by default', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Home')
        ->assertSee('About')
        ->assertSee('Services')
        ->assertSee('Contact')
        ->assertSee('Sign In')
        ->assertSee('Montreal → Toronto')
        ->assertSee('Toronto → Montreal');
});

test('lang query parameter dynamically switches locale', function (): void {
    $response = $this->get('/?lang=fr');

    $response->assertOk()
        ->assertSee('Accueil')
        ->assertSessionHas('locale', 'fr');
});

test('about page renders french translations when locale is fr', function (): void {
    $response = $this->withSession(['locale' => 'fr'])->get(route('about'));

    $response->assertOk()
        ->assertSee('À PROPOS DE PICKMEROUTE')
        ->assertSee('Redéfinir le voyage Montréal ↔ Toronto')
        ->assertSee('POURQUOI NOUS CHOISIR');
});

test('services page renders french translations when locale is fr', function (): void {
    $response = $this->withSession(['locale' => 'fr'])->get(route('services'));

    $response->assertOk()
        ->assertSee('Services de Navette Interurbaine')
        ->assertSee('NOS SERVICES DE CORRIDOR')
        ->assertSee('Montréal → Toronto')
        ->assertSee('Toronto → Montréal');
});

test('faq page renders french translations when locale is fr', function (): void {
    $response = $this->withSession(['locale' => 'fr'])->get(route('faq'));

    $response->assertOk()
        ->assertSee('Foire Aux Questions')
        ->assertSee('Comment puis-je payer mon voyage ?')
        ->assertSee('Tarifs &amp; Paiement', false);
});
