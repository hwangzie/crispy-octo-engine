<?php

namespace Tests\Unit;

use App\Livewire\Dashboard;
use App\Models\ChecklistModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;


class UK9Test extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_checklist()
    {
        // arrange
        $user = User::factory()->create();
        
        // act
        $checklist = $user->lists()->create([
            'name' => 'My Tasks',
            'is_favorite' => false,
            'is_archived' => false,
            'order' => 0,
        ]);
        
        // assert
        $this->assertDatabaseHas('lists', [
            'name' => 'My Tasks',
            'user_id' => $user->id,
        ]);
    }
    
    public function test_user_bisa_menambah_data()
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        // act and assert
        Livewire::test(Dashboard::class)
            ->set('newTaskTitle', 'New Task')
            ->call('addTask')
            ->assertSet('newTaskTitle', '');

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task'
        ]);
    }
}


