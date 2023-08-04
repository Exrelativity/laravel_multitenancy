<?php

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('name')->unique();
            $table->foreignIdFor(User::class, 'user_id')->nullable();
            $table->foreignIdFor(Company::class, 'company_id')->unique();
            $table->string('domain')->unique();
            $table->string('database')->unique();
            $table->timestamps();
        });
    }

     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $alltenant = Tenant::all();
        forEach($alltenant as $tenants){
            DB::statement('DROP DATABASE '. $tenants->database);
        }
        Schema::dropIfExists('tenants');
    }
};
