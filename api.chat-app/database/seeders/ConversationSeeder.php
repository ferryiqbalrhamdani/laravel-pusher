<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            0 => ['user_one' => 1, 'user_two' => 2],
            1 => ['user_one' => 1, 'user_two' => 3],
            2 => ['user_one' => 1, 'user_two' => 4],
            3 => ['user_one' => 1, 'user_two' => 5],
            4 => ['user_one' => 2, 'user_two' => 3],
            5 => ['user_one' => 2, 'user_two' => 4],
            6 => ['user_one' => 2, 'user_two' => 5],
            7 => ['user_one' => 3, 'user_two' => 4],
            8 => ['user_one' => 3, 'user_two' => 5],
            9 => ['user_one' => 4, 'user_two' => 5],
        ];

        foreach ($users as $user) {
            DB::table('conversations')->insert([
                'user_one' => $user['user_one'],
                'user_two' => $user['user_two'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
