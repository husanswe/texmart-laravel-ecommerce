<?php

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('ping returns pong', function () {
    $response = $this->getJson('/api/v1/ping');

    $response->assertStatus(200);
});