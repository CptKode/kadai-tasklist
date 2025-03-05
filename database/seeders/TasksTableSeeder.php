<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 100; $i++) {
            DB::table('tasks')->insert([
                'status' => 'status ' . $i,
                'content' => 'test content ' . $i
            ]);
        }
    }
}