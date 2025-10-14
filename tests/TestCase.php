<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
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
