<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_company_logs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("description")->default("set as admin for company whose id is attached to this row");
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(Admin::class, 'admin_id');
            $table->foreignIdFor(Company::class, 'company_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_company_logs');
    }
};
