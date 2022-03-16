<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseMigrations;

    public function __construct()
    {
        parent::__construct();
    }

    /** @test */
    public function deposit_into_existing_account()
    {
        $this->post('/reset');

        $data = [
            'type' => 'deposit',
            'destination' => "100",
            'amount' => 10
        ];

        $return = [
            "destination" => [
                "id" => "100",
                "balance" => 10
            ]
        ];

        
        $response = $this->post('/event', $data);

        $response->assertExactJson($return);

        $response->assertStatus(201);
    }
}
