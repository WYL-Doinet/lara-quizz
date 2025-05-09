<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        Role::create(['name' => 'admin']);
 
        $admin->assignRole('admin');

        User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User', 'password' => bcrypt('password')]
        );


        Quiz::factory(50)->create(['created_by' => $admin->id])->each(function ($quiz) {
            Question::factory(30)->create(['quiz_id' => $quiz->id])->each(function ($question) {
                $choices = Choice::factory(4)->create(['question_id' => $question->id]);
                $choices->random()->update(['is_correct' => true]);
            });
        });
    }
}
