<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $users = DB::table('users')->whereNotNull('display_name')->get();
        
        foreach ($users as $user) {
            DB::table('user_details')->updateOrInsert(
                ['user_id' => $user->user_id],
                ['display_name' => $user->display_name]
            );
        }
    }

    public function down(): void
    {
        $userDetails = DB::table('user_details')->whereNotNull('display_name')->get();
        
        foreach ($userDetails as $detail) {
            DB::table('users')
                ->where('user_id', $detail->user_id)
                ->update(['display_name' => $detail->display_name]);
        }
    }
}; 