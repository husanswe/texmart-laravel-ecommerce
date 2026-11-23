<?php

use App\Models\Cart;

it('', function () {
    
    
    $response = $this->get('/');

    $response->assertOk();
});
