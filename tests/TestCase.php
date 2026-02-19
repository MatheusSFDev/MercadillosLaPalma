<?php

namespace Tests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Iluminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
{
    parent::setUp();

    // Forzar MySQL durante todos los tests
    config()->set('database.default', 'mysql');

    // Opcional: reconectar para asegurarse
    DB::purge('mysql');
    DB::reconnect('mysql');
}
}
