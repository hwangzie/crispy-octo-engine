# Dependency Documentation

## Core Dependencies
- **Laravel Framework**: ^12.x
  - Used for: Application structure, routing, authentication
  
- **Livewire**: ^3.x
  - Used for: Reactive components (Dashboard)
  - Components: `Dashboard.php` → `dashboard.blade.php`

- **Tailwind CSS**: ^4.x
  - Used for: UI styling

## Dependency Tree
```
Dashboard.php (Livewire Component)
├── Auth (Laravel)
├── ChecklistModel (Eloquent Model)
│   ├── User (Eloquent Model)
│   └── Task (Eloquent Model)
├── DB (Laravel Facade)
└── View (Blade Template)
    └── dashboard.blade.php
```

## Model Relationships
- User → hasMany → ChecklistModel
- ChecklistModel → belongsTo → User
- ChecklistModel → hasMany → Task
- Task → belongsTo → ChecklistModel