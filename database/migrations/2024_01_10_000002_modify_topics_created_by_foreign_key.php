<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign('topics_created_by_fkey');
            
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('SET NULL');
        });
    }

    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign('topics_created_by_fkey');
            
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('users');
        });
    }
};