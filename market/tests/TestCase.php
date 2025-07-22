<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup part
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        if (app()->environment() !== 'testing') {
            if (app()->runningUnitTests()) {
                abort(500, 'Running tests in non-testing environment is not allowed!');
            }
        }
    }

    /**
     * Gets API headers
     *
     * @return string[]
     */
    protected function getHeaders()
    {
        return ['Authorization' => 'Bearer ' . env('API_TOKEN')];
    }
}
