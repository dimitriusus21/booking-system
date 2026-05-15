<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        // Проверяем, что все переменные, которые ждет Blade, здесь есть
        $stats = [
            'users' => User::count(),
            'organizations' => Organization::count(),
            'bookings' => Booking::count(),
            // ВОТ ТУТ МОЖЕТ БЫТЬ ОШИБКА, если в БД нет колонки is_verified
            'pending_orgs' => Organization::where('is_verified', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::with('role')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function organizations()
    {
        $organizations = Organization::with('user')->latest()->paginate(20);
        return view('admin.organizations', compact('organizations'));
    }

    public function verifyOrganization(Organization $organization)
    {
        $organization->update(['is_verified' => true]);
        return back()->with('success', 'Организация успешно верифицирована!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'Себя нельзя удалить!');
        $user->delete();
        return back()->with('success', 'Пользователь удален.');
    }
    public function categories()
    {
        $categories = Category::withCount('services')->get();
        return view('admin.categories', compact('categories'));
    }

// Создание категории
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50|unique:categories']);
        Category::create(['name' => $request->name]);
        return back()->with('success', 'Категория добавлена!');
    }

// Удаление категории
    public function deleteCategory(Category $category)
    {
        if ($category->services()->count() > 0) {
            return back()->with('error', 'Нельзя удалить категорию, в которой есть услуги!');
        }
        $category->delete();
        return back()->with('success', 'Категория удалена.');
    }

// Удаление ТОЛЬКО организации
    public function deleteOrganization(Organization $organization)
    {
        // 1. Опционально: можно сменить роль пользователя обратно на "клиента" (role_id = 3)
        $user = $organization->user;
        $user->update(['role_id' => 3]);

        // 2. Удаляем саму организацию
        $organization->delete();

        return back()->with('success', 'Организация удалена. Пользователь переведен в статус клиента.');
    }
}
