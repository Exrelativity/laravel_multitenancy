<?php


use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('name');
            $table->foreignIdFor(User::class, 'user_id')->nullable();
            $table->foreignIdFor(Tenant::class, 'tenant_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Company::create([
        //     'name' => 'Demo Company1',
        //     'email' => 'example1@gmail.com',
        //     'password' => '123456',
        // ]);

        // Company::create([
        //     'name' => 'Demo Company2',
        //     'email' => 'example2@gmail.com',
        //     'password' => '123456',
        // ]);

        // Company::create([
        //     'name' => 'Demo Company3',
        //     'email' => 'example3@gmail.com',
        //     'password' => '123456',
        // ]);

    }

     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
