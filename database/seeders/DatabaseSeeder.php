<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        /* $user = User::factory()->create([ */
        /*     'name' => 'Leo', */
        /*     'email' => 'leo@innovit.co.za', */
        /*     'password' => "password", */
        /* ]); */

        //seed the questions
        $this->call(QuestionSeeder::class);




    }
}
