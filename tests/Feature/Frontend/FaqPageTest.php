<?php

declare(strict_types=1);

test('faq page loads successfully with 200 OK', function () {
    $response = $this->get(route('faq'));

    $response->assertOk()
        ->assertSee('Frequently Asked Questions')
        ->assertSee('HELP &amp; CORRIDOR GUIDE', false)
        ->assertSee('How do I pay for my trip?')
        ->assertSee('Station Métro Namur')
        ->assertSee('Yorkdale Mall')
        ->assertSee('Yonge Station')
        ->assertSee('647-655-1884');
});

test('header and footer link to faq page', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee(route('faq'));
});

test('faq page includes authentication modal and seat picker modal globally', function (): void {
    $response = $this->get(route('faq'));

    $response->assertOk()
        ->assertSee('id="auth-booking-modal"', false)
        ->assertSee('id="seat-picker-modal"', false)
        ->assertSee('handleGlobalBookNow', false);
});
