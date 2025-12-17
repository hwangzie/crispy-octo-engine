# Library Update Guide

## How to Update Dependencies

### 1. Check Current Versions
```bash
composer show | grep laravel
composer show | grep livewire
```

### 2. Update Laravel
```bash
composer update laravel/framework
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

### 3. Update Livewire
```bash
composer update livewire/livewire
php artisan livewire:publish --config
```

### 4. Update Tailwind CSS
```bash
npm update tailwindcss
npm run build
```

### 5. Testing After Update
```bash
php artisan test
php artisan serve
```

## Version Compatibility Matrix
| Laravel | Livewire | PHP | Tailwind |
|---------|----------|-----|----------|
| 12.x    | 3.x      | 8.2+| 4.x      |
