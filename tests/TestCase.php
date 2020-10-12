<?php

namespace Tests;

use App\Core\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Notification;
use Queue;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use AttachJwtToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setLocale('id_ID');
        Queue::fake();
        Notification::fake();
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {
                //
            }

            public function report(\Throwable $exception)
            {
                //
            }

            public function render($request, \Throwable $exception)
            {
                throw $exception;
            }
        });
    }
}
