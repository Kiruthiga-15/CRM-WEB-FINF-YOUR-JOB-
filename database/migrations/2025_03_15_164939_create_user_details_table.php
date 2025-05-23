<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
    if (!Schema::hasTable('user_details')) {  // ✅ Prevents duplicate table creation
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('id_proof');
            $table->string('address_proof');
            $table->timestamps();
        });
    }
}


    public function down()
    {
        Schema::dropIfExists('users');
    }
};
