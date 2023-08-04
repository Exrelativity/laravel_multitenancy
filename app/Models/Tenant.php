<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use  HasFactory,  UsesLandlordConnection, HasUuids;

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->database ="TENANT_DB_" . date("d") . date("m") . date("Y") . random_int(1000, 9999);
        });
        static::created(function ($model) {
        DB::statement('CREATE DATABASE '. $model->database);

        $model->configure()->use();
        Artisan::call('tenants:artisan "migrate --database=tenant"');

        });
    }


    protected function configure()
    {
        config([
            'database.connections.tenant.database' => $this->database,
            'database.connections.tenant.company_id' => $this->company_id,
        ]);

        DB::purge('tenant');

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

        return $this;
    }

    /**
     *
     */
    protected function use()
    {
        app()->forgetInstance('tenant');

        app()->instance('tenant', $this);

        return $this;
    }
}

