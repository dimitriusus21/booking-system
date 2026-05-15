<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['organization', 'category'])
            ->where('is_active', true);

        // Поиск по названию
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Фильтр по категории
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Сортировка
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->latest();
        }

        $services = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('services.index', compact('services', 'categories'));
    }

    public function show(Service $service)
    {
        // Проверка на активность услуги
        if (!$service->is_active) {
            abort(404);
        }

        // Подгружаем связанные модели, чтобы не делать лишних запросов в БД (Eager Loading)
        $service->load(['organization', 'category']);

        // Получаем все отзывы для конкретной услуги через её бронирования
        $reviews = Review::whereHas('booking', function ($query) use ($service) {
            $query->where('service_id', $service->id);
        })->with('client')->latest()->get();

        // Считаем среднюю оценку именно этой услуги
        $averageRating = $reviews->avg('rating');

        return view('services.show', compact('service', 'reviews', 'averageRating'));
    }
}
