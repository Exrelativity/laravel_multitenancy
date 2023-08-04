<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\PersonalAccessToken as BasePersonalAccessToken;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
// use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class PersonalAccessToken extends BasePersonalAccessToken
{
    use  UsesLandlordConnection,  HasUuids;
}
