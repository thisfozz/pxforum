<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $constraints = DB::select("
            SELECT constraint_name 
            FROM information_schema.table_constraints 
            WHERE table_name = 'sessions' 
            AND constraint_type = 'FOREIGN KEY'
            AND constraint_name LIKE '%user_id%'
        ");

        Schema::table('sessions', function (Blueprint $table) use ($constraints) {
            if (!empty($constraints)) {
                foreach ($constraints as $constraint) {
                    $table->dropForeign($constraint->constraint_name);
                }
            }
            
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->name('fk_user_id');
        });
    }
}; 