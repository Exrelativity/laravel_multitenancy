<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


trait EnsureLandLordDatabaseConnection
{
    protected static function bootEnsureRightLandLordDatabaseConnection()
    {
        $x = new self();
        $x->makeCurrent();
    }

    protected function makeCurrent()
    {

        $this->configure()->use();
    }

    protected static function forgetCurrent()
    {
        DB::purge('landlord');

        DB::reconnect('landlord');

        Schema::connection('landlord')->getConnection()->reconnect();
    }

    protected function configure()
    {
        DB::purge('landlord');

        DB::reconnect('landlord');

        Schema::connection('landlord')->getConnection()->reconnect();

        return $this;

    }

    protected function use ()
    {
        app()->forgetInstance('landlord');

        app()->instance('landlord', $this);

    }
}
