<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\RateLimiter;

class LoginRateLimitUnitTest extends TestCase
{
    public function test_too_many_attempts_blocks_user()
    {
        $key = 'test@example.com|127.0.0.1';

        // Reset limiter
        RateLimiter::clear($key);

        // Hit limiter 5 times
        for ($i = 1; $i <= 5; $i++) {
            RateLimiter::hit($key, 60); // 60 seconds decay
        }

        // Now should be blocked
        $this->assertTrue(RateLimiter::tooManyAttempts($key, 5));

        // Available seconds should be <= 60
        $this->assertLessThanOrEqual(60, RateLimiter::availableIn($key));
    }

    public function test_attempt_under_limit_is_allowed()
    {
        $key = 'test2@example.com|127.0.0.1';

        RateLimiter::clear($key);

        // Hit limiter 3 times (limit is 5)
        for ($i = 1; $i <= 3; $i++) {
            RateLimiter::hit($key, 60);
        }

        $this->assertFalse(RateLimiter::tooManyAttempts($key, 5));
    }
}
