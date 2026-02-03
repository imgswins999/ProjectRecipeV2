<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // ต้องเพิ่มบรรทัดนี้
use App\Models\User; // ต้องเพิ่มบรรทัดนี้

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // สร้างสิทธิ์ที่ชื่อ 'admin-only'
        Gate::define('admin-only', function (User $user) {
            // เช็คว่า role ในฐานข้อมูลต้องเป็น admin เท่านั้น
            return $user->role === 'admin';
        });
    }
}
