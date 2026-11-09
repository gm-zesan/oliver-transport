<?php

declare(strict_types=1);

test('contact page loads successfully with 200 OK', function () {
    $response = $this->get(route('contact'));

    $response->assertOk()
        ->assertSee('Contact PickMeRoute')
        ->assertSee('647-655-1884')
        ->assertSee('info@pickmeroute.com')
        ->assertSee('Station Métro Namur')
        ->assertSee('Yorkdale Mall')
        ->assertSee('Yonge Station')
        ->assertSee('Send Us an Inquiry');
});

test('header and footer link to contact page', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee(route('contact'));
});

test('contact page includes authentication modal and seat picker modal globally', function (): void {
    $response = $this->get(route('contact'));

    $response->assertOk()
        ->assertSee('id="auth-booking-modal"', false)
        ->assertSee('id="seat-picker-modal"', false)
        ->assertSee('handleGlobalBookNow', false);
});
