<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-4xl mx-auto flex items-center justify-between px-6 py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-900">My Checklist</h1>
            </div>

            <!-- User Profile Dropdown -->
            <div class="relative">
                <button 
                    wire:click="$toggle('showUserMenu')"
                    class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition duration-150"
                >
                    <div class="h-8 w-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ auth()->user()->name ?? 'User' }}</span>
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                @if($showUserMenu)
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <hr class="my-1">
                    <button wire:click="logout" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </button>
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-4xl mx-auto p-6">
        
        <!-- Add New Task -->
        <div class="mb-6">
            <form wire:submit.prevent="addTask" class="flex items-center space-x-3 bg-white rounded-lg border-2 border-gray-200 hover:border-blue-300 focus-within:border-blue-500 transition duration-150 px-4 py-3 shadow-sm">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <input 
                wire:model="newTaskTitle"
                type="text"
                placeholder="Add a new task..."
                class="flex-1 border-0 focus:ring-0 p-0 text-gray-900 placeholder-gray-400"
                >
            </form>
        </div>
        
        <!-- Task List -->
        <div class="space-y-3">
            @foreach($tasks as $task)
                    {{-- <span class="flex-1 {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }}">
                        {{ $task->getDisplayName() }}
                    </span> --}}
                    <div class="bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition duration-150 shadow-sm">
                        <div class="flex items-center px-4 py-3">
                            <!-- Checkbox -->
                            <button 
                                wire:click="toggleTask({{ $task->id }})"
                                class="flex-shrink-0 mr-3"
                            >
                                @if($task->completed)
                                <div class="h-5 w-5 bg-blue-500 rounded border-2 border-blue-500 flex items-center justify-center">
                                    <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                @else
                                <div class="h-5 w-5 bg-white rounded border-2 border-gray-300 hover:border-blue-500 transition duration-150"></div>
                                @endif
                            </button>

                            <!-- Task Title and edittask -->
                            @if($editingTaskId === $task->id)
                                <!-- Edit Mode -->
                                <input 
                                    wire:model="editingTaskTitle"
                                    wire:keydown.enter="updateTask"
                                    wire:keydown.escape="cancelEdit"
                                    type="text"
                                    class="flex-1 px-2 py-1 border border-blue-500 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    autofocus
                                >
                                <!-- Save Button -->
                                <button 
                                    wire:click="updateTask"
                                    class="flex-shrink-0 ml-2 p-1 text-green-600 hover:bg-green-50 rounded transition duration-150"
                                    title="Save"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <!-- Cancel Button -->
                                <button 
                                    wire:click="cancelEdit"
                                    class="flex-shrink-0 ml-1 p-1 text-gray-400 hover:bg-gray-100 rounded transition duration-150"
                                    title="Cancel"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @else
                                <!-- View Mode -->
                                <span 
                                    wire:click="startEdit({{ $task->id }})"
                                    class="flex-1 cursor-pointer {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }} hover:text-blue-600"
                                    title="Click to edit"
                                >
                                    {{ $task->title }}
                                </span>
                            @endif

                            <!-- Delete Button -->
                            <button 
                                wire:click="deleteTask({{ $task->id }})"
                                wire:confirm="Are you sure you want to delete this task?"
                                class="flex-shrink-0 ml-3 p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition duration-150"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach

                    @if(count($tasks) === 0)
                    <div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="mt-4 text-gray-500">No tasks yet. Add one to get started!</p>
                    </div>
                    @endif
                </div>
    </main>
</div>
