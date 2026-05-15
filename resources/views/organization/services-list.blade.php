@extends('layouts.app')

@section('title', 'Управление услугами')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - ORGANIZATION SERVICES LIST
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --neon-info: #00d2ff;
            --neon-danger: #ef476f;
            --neon-success: #06d6a0;
        }

        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 80%; height: 400px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.1) 0%, transparent 60%);
            pointer-events: none; z-index: -1;
        }

        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2.5rem; animation: slideDown 0.5s ease-out;
        }

        .page-title {
            font-size: 2.2rem; font-weight: 800; color: #fff; margin: 0;
            display: flex; align-items: center; gap: 1rem;
        }

        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        /* Кнопка добавить */
        .btn-add-glow {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1.75rem; background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff; font-weight: 600; border-radius: 99px; text-decoration: none;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.3); transition: all 0.3s ease;
        }
        .btn-add-glow:hover { transform: translateY(-2px); box-shadow: 0 0 25px rgba(0, 102, 255, 0.5); color: #fff; }

        /* Стеклянная панель с таблицей */
        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s ease-out both;
        }

        .glass-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .glass-table th {
            background: rgba(0, 0, 0, 0.2); color: var(--text-secondary);
            text-transform: uppercase; font-size: 0.75rem; font-weight: 700;
            padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--glass-border);
        }
        .glass-table td { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03); color: #fff; vertical-align: middle; }
        .glass-table tr:hover { background: rgba(255, 255, 255, 0.02); }

        /* Бейджи и текст */
        .service-title-main { font-weight: 700; font-size: 1.1rem; color: #fff; }
        .cat-badge { background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 0.3rem 0.7rem; border-radius: 99px; font-size: 0.75rem; }
        .price-tag { color: var(--neon-success); font-weight: 800; font-size: 1.1rem; }

        /* Кнопки действий */
        .action-btn-group { display: flex; gap: 0.5rem; }
        .btn-action-glass {
            width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
            border-radius: 10px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.03);
            color: var(--text-secondary); transition: all 0.3s ease; text-decoration: none;
        }

        .btn-schedule:hover { color: var(--neon-info); border-color: var(--neon-info); background: rgba(0, 210, 255, 0.1); box-shadow: 0 0 15px rgba(0, 210, 255, 0.2); }
        .btn-edit:hover { color: var(--accent-primary); border-color: var(--accent-primary); background: rgba(0, 102, 255, 0.1); box-shadow: 0 0 15px rgba(0, 102, 255, 0.2); }
        .btn-delete:hover { color: var(--neon-danger); border-color: var(--neon-danger); background: rgba(239, 71, 111, 0.1); box-shadow: 0 0 15px rgba(239, 71, 111, 0.2); }

        /* Пустое состояние */
        .empty-state { padding: 5rem 2rem; text-align: center; color: var(--text-secondary); }
        .empty-state i { font-size: 4rem; opacity: 0.1; margin-bottom: 1rem; display: block; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-grid-3x3-gap"></i> Мои услуги</h1>
            <a href="{{ route('organization.services.create') }}" class="btn-add-glow">
                <i class="bi bi-plus-lg"></i> Добавить услугу
            </a>
        </div>

        @if($services->count() > 0)
            <div class="glass-panel">
                <div class="table-responsive">
                    <table class="glass-table">
                        <thead>
                        <tr>
                            <th>Название и категория</th>
                            <th>Стоимость</th>
                            <th>Длительность</th>
                            <th class="text-end">Управление</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>
                                    <div class="service-title-main">{{ $service->title }}</div>
                                    <span class="cat-badge">{{ $service->category->name ?? 'Без категории' }}</span>
                                </td>
                                <td><span class="price-tag">{{ number_format($service->price, 0, '', ' ') }} ₽</span></td>
                                <td style="color: var(--text-secondary);">
                                    <i class="bi bi-clock me-1"></i> {{ $service->duration }} мин
                                </td>
                                <td>
                                    <div class="action-btn-group justify-content-end">
                                        <a href="{{ route('organization.schedule.index', $service->id) }}" class="btn-action-glass btn-schedule" title="Расписание">
                                            <i class="bi bi-calendar-week"></i>
                                        </a>
                                        <a href="{{ route('organization.services.edit', $service->id) }}" class="btn-action-glass btn-edit" title="Редактировать">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('organization.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Удалить эту услугу навсегда?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action-glass btn-delete" title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $services->links() }}
            </div>
        @else
            <div class="glass-panel empty-state">
                <i class="bi bi-layers"></i>
                <h3>Услуг пока нет</h3>
                <p>Создайте свою первую услугу, чтобы клиенты могли начать записываться к вам.</p>
                <a href="{{ route('organization.services.create') }}" class="btn-add-glow mt-3">Создать услугу</a>
            </div>
        @endif
    </div>
@endsection
