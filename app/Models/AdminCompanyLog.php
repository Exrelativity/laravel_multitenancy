<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class AdminCompanyLog extends Model
{
    use  HasFactory,  UsesLandlordConnection, HasUuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // tables becomes admins for admin app.
    protected $table = 'admin_company_logs';

}
