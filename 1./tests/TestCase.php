<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function get($uri, array $parameters = [], array $headers = []): TestResponse
    {
        $server = $this->transformHeadersToServerVars($headers);
        $cookies = $this->prepareCookiesForRequest();

        return $this->call('GET', $uri, $parameters, $cookies, [], $server);
    }
}
