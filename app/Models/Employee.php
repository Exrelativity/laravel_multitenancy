<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Employee extends Model
{
    use HasFactory, HasUuids, \App\Actions\UseMyTenantDatabaseConnection;

    protected $fillable = [
        'name',
        'email',
        'company_id',
        'password',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function($model){
            $model->password = Hash::make($model->password);
        });

        static::created(function ($model) {
            // if (User::where('email', $model->email)->exists()) {
            // User::where('email', $model->email)->update(
            //         [
            //         "password" => $model->password,
            //         "email" => $model->email,
            //         "name" => $model->name,
            //         "company_id" => $model->id,
            //         ]
            //     );

            // $user = User::where('email', $model->email)->first();
            // } else {
                $user = new User;
                $user->password = $model->password;
                $user->email = $model->email;
                $user->name = $model->name;
                $user->company_id = Auth::user()->company_id;
                $user->save();
            // }


        $model->user_id = $user->id;
        $model->save();
        });
    }
}
