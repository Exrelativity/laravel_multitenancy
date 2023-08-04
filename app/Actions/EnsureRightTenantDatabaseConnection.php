<?php

namespace App\Actions;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


trait EnsureRightTenantDatabaseConnection
{
    protected static $currentdatabase;
    protected static $company_id;
    protected static function bootEnsureRightTenantDatabaseConnection()
    {

        static::makeCurrent();
    }

    protected static function makeCurrent()
    {
        if (Auth::check()) {
            if (config('database.connections.tenant.company_id') !== Auth::user()->company_id) {
                static::$currentdatabase = Tenant::where("company_id", Auth::user()->company_id)->first()->database;
                static::$company_id = Auth::user()->company_id;
            }
        }

        static::configure()::use();
    }

    protected static function forgetCurrent()
    {
        DB::purge('tenant');

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
    }

    protected static function configure()
    {
        if (Auth::check()) {
            config([
                'database.connections.tenant.database' => static::$currentdatabase,
                'database.connections.tenant.company_id' => static::$company_id,
            ]);

            DB::purge('tenant');

            DB::reconnect('tenant');

            Schema::connection('tenant')->getConnection()->reconnect();

        } else {
            DB::purge('landlord');

            DB::reconnect('landlord');

            Schema::connection('landlord')->getConnection()->reconnect();

        }

        return Static::class;

    }

    /**
     *
     */
    protected static function use ()
    {
        if (Auth::check()) {
            app()->forgetInstance('tenant');

            app()->instance('tenant', Static::class);
        } else {
            app()->forgetInstance('landlord');

            app()->instance('landlord', Static::class);
        }
    }
}
