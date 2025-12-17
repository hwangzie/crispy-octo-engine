<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ChecklistModel;
use App\Models\Task;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        
        if ($user) {
            // Create Favorite List
            $favoriteList = $user->lists()->create([
                'name' => 'Important Tasks',
                'is_favorite' => true,
                'is_archived' => false,
                'order' => 1,
            ]);

            $favoriteList->tasks()->createMany([
                ['title' => 'Review project proposal', 'completed' => false, 'order' => 1],
                ['title' => 'Call client', 'completed' => true, 'order' => 2],
            ]);

            // Create Work Projects List
            $workList = $user->lists()->create([
                'name' => 'Work Projects',
                'is_favorite' => false,
                'is_archived' => false,
                'order' => 2,
            ]);

            $workList->tasks()->createMany([
                ['title' => 'Complete documentation', 'completed' => false, 'order' => 1],
                ['title' => 'Code review', 'completed' => false, 'order' => 2],
                ['title' => 'Deploy to staging', 'completed' => true, 'order' => 3],
            ]);

            // Create Personal Goals List
            $personalList = $user->lists()->create([
                'name' => 'Personal Goals',
                'is_favorite' => false,
                'is_archived' => false,
                'order' => 3,
            ]);

            $personalList->tasks()->createMany([
                ['title' => 'Exercise 3 times a week', 'completed' => false, 'order' => 1],
                ['title' => 'Read one book', 'completed' => false, 'order' => 2],
            ]);

            // Create Grocery List
            $groceryList = $user->lists()->create([
                'name' => 'Grocery List',
                'is_favorite' => false,
                'is_archived' => false,
                'order' => 4,
            ]);

            $groceryList->tasks()->createMany([
                ['title' => 'Buy Milk', 'completed' => false, 'order' => 1],
                ['title' => 'Eggs', 'completed' => false, 'order' => 2],
                ['title' => 'Bread', 'completed' => true, 'order' => 3],
                ['title' => 'Fresh vegetables', 'completed' => false, 'order' => 4],
            ]);
        }
    }
}
