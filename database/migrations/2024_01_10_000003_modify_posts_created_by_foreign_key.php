<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Сначала добавляем столбец
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'created_by')) {
                $table->uuid('created_by')->nullable();
            }
        });

        // Проверяем существование внешнего ключа через прямой запрос
        $foreignKeyExists = DB::select("
            SELECT 1 
            FROM information_schema.table_constraints 
            WHERE table_name = 'posts' 
            AND constraint_type = 'FOREIGN KEY' 
            AND constraint_name LIKE '%created_by%'
        ");

        // Создаем внешний ключ только если его нет
        if (empty($foreignKeyExists)) {
            Schema::table('posts', function (Blueprint $table) {
                $table->foreign('created_by')
                      ->references('user_id')
                      ->on('users')
                      ->onDelete('SET NULL');
            });
        }
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
        });
    }
}; 