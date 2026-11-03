<?php

declare(strict_types=1);

test('contact page loads successfully with 200 OK', function () {
    $response = $this->get(route('contact'));

    $response->assertOk()
        ->assertSee('Contact Oliver Transport')
        ->assertSee('647-655-1884')
        ->assertSee('info@olivertransport.ca')
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
