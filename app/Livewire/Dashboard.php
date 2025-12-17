<?php

namespace App\Livewire;

use Exception;
use App\Models\Task;
use Livewire\Component;
use App\Models\ChecklistModel;
use function Pest\Laravel\session;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $newTaskTitle = '';
    public $showUserMenu = false;
    // ini adalah tipe data integer atau null
    public $listId = null;
    public $editingTaskId = null;
    public $editingTaskTitle = '';

    // ini adalah method 
    public function mount()
    {
        
        // Get or create a default list for the user
        $list = Auth::user()->lists()->first();
        
        $this->verifyDependencies();
        // struktur kontrol untuk membuat default list jika belum ada di database
        if (!$list) {
            $list = Auth::user()->lists()->create([
                'name' => 'My Tasks',
                'is_favorite' => false,
                'is_archived' => false,
                'order' => 0,
            ]);
        }
        
        $this->listId = $list->id;
    }
        /**
     * Verify required dependencies and versions
     * Called during mount to ensure compatibility
     */
    private function verifyDependencies(): void
    {
        // Check minimum Laravel version
        if (version_compare(app()->version(), '12.0.0', '<')) {
            throw new \RuntimeException('Laravel 12.x or higher required');
        }

        // Check Livewire is loaded
        if (!class_exists(Component::class)) {
            throw new \RuntimeException('Livewire component not found');
        }

        // Log dependency versions for debugging
        Log::info('Dependencies verified', [
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
        ]);
    }
    /**
     * Algoritma addTask():
     * 1. Validasi input newTaskTitle (required, max 255)
     * 2. Mulai database transaction
     * 3. Cek apakah title tidak kosong setelah trim
     * 4. Hitung order maksimum dari task yang ada + 1
     * 5. Simpan task baru ke database
     * 6. Reset input field
     * 7. Commit transaction
     * 8. Tangani error jika ada
     */
    public function addTask()
    {
        try {
            $this->validate([
                'newTaskTitle' => 'required|string|max:255',
            ]);

            DB::transaction(function (){
                // struktur kontrol if untuk memeriksa apakah properti newTaskTitle tidak kosong setelah di-trim
                // jika tidak kosong, maka buat task baru di database
                if (trim($this->newTaskTitle)) {
                    Task::create([
                        'list_id' => $this->listId,
                        'title' => $this->newTaskTitle,
                        'completed' => false,
                        'order' => Task::where('list_id', $this->listId)->max('order') + 1,
                    ]);
                    
                    $this->newTaskTitle = '';
                }
            });
            // ini adalah error handling untuk menangkap exception yang mungkin terjadi selama proses penambahan task
            return redirect()->back()->with('success', 'Task berhasil ditambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan task: ' . $e->getMessage());
        }
        
    }

    public function startEdit($taskId)
    {
        $task = Task::whereHas('list', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($taskId);
        
        if ($task) {
            $this->editingTaskId = $taskId;
            $this->editingTaskTitle = $task->title;
        }
    }

    public function updateTask()
    {
        $this->validate([
            'editingTaskTitle' => 'required|string|max:255',
        ]);

        $task = Task::whereHas('list', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($this->editingTaskId);
        
        if ($task) {
            $task->update(['title' => $this->editingTaskTitle]);
            $this->editingTaskId = null;
            $this->editingTaskTitle = '';
        }
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->editingTaskTitle = '';
    }

    public function toggleTask($taskId)
    {
        // mengaskses databaese untuk mendapatkan task berdasarkan taskId dan user yang sedang login
        $task = Task::whereHas('list', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($taskId);
        
        if ($task) {
            // ternary operator digunakan untuk membalikkan nilai properti completed
            $task->update(['completed' => !$task->completed]);
        }
    }

    public function deleteTask($taskId)
    {
        // mengaskses databaese untuk mendapatkan task berdasarkan taskId dan user yang sedang login
        $task = Task::whereHas('list', function ($query) {
            // memastikan hanya task milik user yang sedang login yang dapat diakses
            $query->where('user_id', Auth::id());
        })->find($taskId);
        
        if ($task) {
            $task->delete();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    
    public function render()
    {
        // mengakses database untuk mendapatkan list berdasarkan listId milik user yang sedang login
        $list = ChecklistModel::find($this->listId);
        $tasks = $list->tasks;

        // dd($tasks);
        return view('livewire.dashboard', [
            'tasks' => $tasks,
        ]);
    }
}
