<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_proof')->nullable()->after('email'); // Stores file path
            $table->string('address_proof')->nullable()->after('id_proof'); // Stores file path
           
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('address_proof');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_proof', 'address_proof','status']);
        });
    }
};
