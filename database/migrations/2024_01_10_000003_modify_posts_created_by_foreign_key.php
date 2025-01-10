<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Сначала проверяем существование ограничения
        $constraints = DB::select("
            SELECT constraint_name 
            FROM information_schema.table_constraints 
            WHERE table_name = 'posts' 
            AND constraint_type = 'FOREIGN KEY'
            AND constraint_name LIKE '%created_by%'
        ");

        Schema::table('posts', function (Blueprint $table) use ($constraints) {
            // Если ограничение существует, удаляем его
            if (!empty($constraints)) {
                foreach ($constraints as $constraint) {
                    $table->dropForeign($constraint->constraint_name);
                }
            }
            
            // Создаем новое ограничение с ON DELETE SET NULL
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('SET NULL');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('users');
        });
    }
}; 