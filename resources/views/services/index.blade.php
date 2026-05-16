@extends('layouts.app')

@section('title', 'Каталог услуг')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - SERVICES CATALOG (FIXED CONTRAST)
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-hover: rgba(255, 255, 255, 0.15);

            /* Цвета текста с повышенным контрастом */
            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
        }

        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 90%; height: 600px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.12) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        /* Заголовок страницы */
        .page-header h1 { color: var(--text-main); font-weight: 800; }
        .page-header p { color: var(--text-description); font-size: 1.1rem; }

        /* Панель фильтров */
        .filter-panel {
            background: var(--glass-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 2rem; margin-bottom: 3rem; animation: slideDown 0.6s ease-out;
        }

        .filter-label {
            color: var(--text-main); font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;
        }

        /* === БАЗОВЫЕ ИНПУТЫ (ТЁМНАЯ ТЕМА) === */
        .glass-input, .glass-select {
            background: rgba(0, 0, 0, 0.4); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 0.75rem; padding: 0.75rem 1rem; width: 100%;
            transition: all 0.3s ease;
        }
        .glass-input:focus, .glass-select:focus {
            outline: none; border-color: var(--accent-primary); box-shadow: 0 0 15px rgba(0, 102, 255, 0.2);
        }

        /* === АДАПТАЦИЯ ИНПУТОВ (СВЕТЛАЯ ТЕМА) === */
        html[data-theme="light"] .glass-input,
        html[data-theme="light"] .glass-select {
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
        }
        html[data-theme="light"] .glass-input:focus,
        html[data-theme="light"] .glass-select:focus {
            border-color: var(--accent-primary) !important;
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1) !important;
        }
        /* Фикс текста внутри инпутов (чтобы не было белым на белом) */
        html[data-theme="light"] .glass-input::placeholder {
            color: #94a3b8 !important;
        }
        html[data-theme="light"] .glass-select option {
            background: #ffffff !important;
            color: #0f172a !important;
        }

        /* Кнопки */
        .btn-search {
            background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff !important; border: none; border-radius: 99px; padding: 0.75rem 2rem;
            font-weight: 700; transition: all 0.3s ease; text-decoration: none; display: inline-flex; justify-content: center;
        }
        .btn-search:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,102,255,0.3); color: #fff !important; }

        .btn-reset {
            background: rgba(255, 255, 255, 0.08); color: var(--text-main);
            border: 1px solid var(--glass-border); border-radius: 99px; padding: 0.75rem 1.5rem;
            transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;
        }
        html[data-theme="light"] .btn-reset {
            background: #f1f5f9 !important; color: #475569 !important; border-color: #cbd5e1 !important;
        }
        html[data-theme="light"] .btn-reset:hover {
            background: #e2e8f0 !important; color: #0f172a !important;
        }

        /* Карточка услуги */
        .service-card {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 1.75rem; height: 100%; display: flex; flex-direction: column;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            animation: fadeUp 0.6s ease-out both; position: relative; overflow: hidden;
        }
        .service-card:hover { transform: translateY(-8px); border-color: rgba(255,255,255,0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }

        html[data-theme="light"] .service-card:hover {
            border-color: rgba(0,102,255,0.2) !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        }

        .cat-badge {
            background: rgba(0, 102, 255, 0.15); color: #60a5fa;
            padding: 0.3rem 0.8rem; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        }
        html[data-theme="light"] .cat-badge { color: #0066ff !important; }

        .duration-tag { color: var(--text-description); font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.4rem; }

        .service-title { font-size: 1.4rem; font-weight: 800; color: var(--text-main); margin: 1.25rem 0 0.5rem; }

        .rating-box { display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-main); }
        .star-active { color: var(--neon-warning); }
        html[data-theme="light"] .star-active { color: #f59e0b !important; }

        .service-description-text {
            color: var(--text-description);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        .price-glow { font-size: 1.6rem; font-weight: 800; color: var(--neon-success); text-shadow: 0 0 15px rgba(6, 214, 160, 0.2); }
        html[data-theme="light"] .price-glow { color: #059669 !important; text-shadow: none; }

        .org-name-text { font-size: 0.85rem; color: var(--text-description); font-weight: 500; }

        /* Пагинация */
        .custom-pagination-container { margin-top: 4rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; }
        .pagination-info { color: var(--text-description); font-size: 0.875rem; }
        .pagination-info b { color: var(--text-main); }
        .custom-pagination { display: flex; gap: 0.5rem; list-style: none; padding: 0; }
        .custom-pagination .page-link { background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-description); border-radius: 0.5rem; padding: 0.5rem 1rem; text-decoration: none; transition: 0.2s; }
        .custom-pagination .page-item.active .page-link { background: var(--accent-primary) !important; border-color: var(--accent-primary) !important; color: #fff !important; box-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        html[data-theme="light"] .custom-pagination .page-link { background: #ffffff; border-color: #cbd5e1; color: #475569; }
        html[data-theme="light"] .custom-pagination .page-link:hover { background: #f1f5f9; color: #0f172a; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header mb-5">
            <h1 class="display-5"><i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Каталог услуг</h1>
            <p>Найдите идеальное время для вашего преображения и запишитесь онлайн</p>
        </div>

        <div class="filter-panel">
            <form method="GET" action="{{ route('services.index') }}" class="row g-4 align-items-end">
                <div class="col-lg-4">
                    <div class="filter-label">Поиск</div>
                    <input type="text" name="search" class="glass-input" placeholder="Название или ключевое слово..." value="{{ request('search') }}">
                </div>
                <div class="col-lg-3">
                    <div class="filter-label">Категория</div>
                    <select name="category_id" class="glass-select">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <div class="filter-label">Сортировка</div>
                    <select name="sort" class="glass-select">
                        <option value="">Сначала новые</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-search w-100"><i class="bi bi-search"></i></button>
                        <a href="{{ route('services.index') }}" class="btn-reset" title="Сбросить"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($services as $index => $service)
                <div class="col">
                    <div class="service-card" style="animation-delay: {{ $index * 0.05 }}s;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="cat-badge">{{ $service->category->name ?? 'Общее' }}</span>
                            <span class="duration-tag"><i class="bi bi-clock"></i> {{ $service->duration }} мин</span>
                        </div>

                        <h5 class="service-title">{{ $service->title }}</h5>

                        <div class="rating-box">
                            @php
                                $svcRating = \App\Models\Review::whereHas('booking', fn($q) => $q->where('service_id', $service->id))->avg('rating') ?: 0;
                                $svcCount = \App\Models\Review::whereHas('booking', fn($q) => $q->where('service_id', $service->id))->count();
                            @endphp
                            @if($svcCount > 0)
                                <i class="bi bi-star-fill star-active"></i>
                                <span>{{ number_format($svcRating, 1) }}</span>
                                <span class="text-description" style="margin-left: 5px;">({{ $svcCount }} отз.)</span>
                            @else
                                <span class="text-description"><i class="bi bi-star me-1"></i>Нет оценок</span>
                            @endif
                        </div>

                        <p class="service-description-text">{{ Str::limit($service->description, 120) }}</p>

                        <div class="mt-auto pt-4 border-top border-secondary border-opacity-10 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price-glow">{{ number_format($service->price, 0, '', ' ') }} ₽</div>
                                <div class="org-name-text"><i class="bi bi-building me-1"></i>{{ $service->organization->name }}</div>
                            </div>
                            <a href="{{ route('services.show', $service) }}" class="btn-search py-2 px-4" style="font-size: 0.9rem;">Записаться</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="service-card text-center py-5">
                        <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                        <h4 class="text-main mt-3">Услуги не найдены</h4>
                        <p class="service-description-text">Попробуйте изменить параметры поиска или фильтрации</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($services->hasPages())
            <div class="custom-pagination-container">
                <div class="pagination-info">Показаны услуги с <b>{{ $services->firstItem() }}</b> по <b>{{ $services->lastItem() }}</b> из <b>{{ $services->total() }}</b></div>
                <ul class="custom-pagination">
                    <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $services->previousPageUrl() ?? '#' }}"><i class="bi bi-chevron-left"></i> Назад</a>
                    </li>
                    @foreach ($services->getUrlRange(1, min(5, $services->lastPage())) as $page => $url)
                        <li class="page-item {{ $page == $services->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ !$services->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $services->nextPageUrl() ?? '#' }}">Дальше <i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
@endsection
