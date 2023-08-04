<?php

namespace App\Models;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
// use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Company extends Model
{
    use  HasFactory,  UsesLandlordConnection, HasUuids;
    // UsesTenantConnection
    protected $fillable = [
        'name','email','password'
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function($model){
            $model->password = Hash::make($model->password);
        });

        static::created(function ($model) {
            // if (User::where('email', $model->email)->exists()) {
            //     User::where('email', $model->email)->update(
            //         [
            //         "password" => $model->password,
            //         "email" => $model->email,
            //         "name" => $model->name,
            //         "company_id" => $model->id,
            //         ]
            //     );

            // $user = User::where('email', $model->email)->get();

            //     $tenant = new Tenant;
            //     $tenant->name = $model->name;
            //     $model->user_id = $user->id;
            //     $tenant->domain = $model->email;
            //     $tenant->company_id =$model->id;
            //     $tenant->save();

            // } else {
                // The record does not exist

                $user = new User;
                $user->password = $model->password;
                $user->email = $model->email;
                $user->name = $model->name;
                $user->company_id = $model->id;
                $user->save();

                $tenant = new Tenant;
                $tenant->name = $model->name;
                $model->user_id = $user->id;
                $tenant->domain = $model->email;
                $tenant->company_id =$model->id;
                $tenant->save();
            // }
            $model->user_id = $user->id;
            $model->tenant_id = $tenant->id;
            $model->save();
        });
    }
}
