<?php

test('ping returns pong', function () {
    $response = $this->getJson('/api/v1/ping');

    $response->assertOk();
    $response->assertJson(['message' => 'pong']);
});