<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected function setUpTenant($tenant): void
    {
        // Run tenant migrations for the test tenant
        Artisan::call('tenants:migrate', [
            '--tenants' => [$tenant->id],
        ]);
    }
}
