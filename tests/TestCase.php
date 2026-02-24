<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MockeryPHPUnitIntegration;
    use RefreshDatabase;

    /**
     * Generic helper to create multiple rows for any model.
     */
    protected function createNew(string $className, array $data = [])
    {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $className::create($dt);
            }
        }
    }
}
