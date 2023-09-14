<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


trait EnsureLandLordDatabaseConnection
{
    protected static function bootEnsureRightLandLordDatabaseConnection()
    {
      
        static::makeCurrent();
    }

    protected static function makeCurrent()
    {

        static::configure()::use();
    }

    protected static function forgetCurrent()
    {
        DB::purge('landlord');

        DB::reconnect('landlord');

        Schema::connection('landlord')->getConnection()->reconnect();
    }

    protected static function configure()
    {
        DB::purge('landlord');

        DB::reconnect('landlord');

        Schema::connection('landlord')->getConnection()->reconnect();

        return static::class;

    }

    protected function use ()
    {
        app()->forgetInstance('landlord');

        app()->instance('landlord', Static::class);

    }
}
