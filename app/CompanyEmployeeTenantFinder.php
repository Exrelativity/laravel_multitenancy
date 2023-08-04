<?php

namespace App;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class CompanyEmployeeTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?Tenant
    {

        $company_id = (Auth::check()) ? Auth::user()->company_id : User::orderBy('created_at', 'asc')->first();

        return Tenant::where("company_id", $company_id)->first();
    }
}
