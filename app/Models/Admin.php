<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Admin extends Model
{
    use HasFactory, UsesLandlordConnection, HasUuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // tables becomes admins for admin app.
    protected $table = 'admins';


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
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
            $user->company_id = $model->current_company_id;
            $user->save();
            // }
            $model->user_id = $user->id;
            $model->save();
        });

        static::updating(function ($model) {
            $admin = new AdminCompanyLog;
            $admin->user_id = $model->user_id;
            $admin->admin_id = $model->id;
            $admin->company_id = $model->current_company_id;
            $admin->save();
        });
    }



}
