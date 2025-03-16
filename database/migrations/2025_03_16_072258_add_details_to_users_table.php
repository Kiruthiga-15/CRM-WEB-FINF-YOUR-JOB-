<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the 'phone' column doesn't exist before adding it
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('address_proof'); // Adds phone column
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'phone' column if rolling back the migration
            $table->dropColumn('phone');
        });
    }
}
