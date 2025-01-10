<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE posts ALTER COLUMN created_at TYPE TIMESTAMP USING created_at::TIMESTAMP');
        
        DB::statement('ALTER TABLE posts ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE posts ALTER COLUMN created_at TYPE DATE USING created_at::DATE');
        DB::statement('ALTER TABLE posts ALTER COLUMN created_at SET DEFAULT CURRENT_DATE');
    }
};