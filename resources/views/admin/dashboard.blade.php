@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <style>
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --neon-warning: #ffd166;
            --neon-success: #06d6a0;
            --neon-purple: #9d4edd;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 2rem; }

        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 80%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.1) 0%, transparent 60%);
            pointer-events: none; z-index: -1;
        }

        .page-header { margin-bottom: 2.5rem; animation: slideDown 0.5s ease-out; }
        .page-title {
            font-size: 2.2rem; font-weight: 800;
            color: var(--text-main); /* ИСПРАВЛЕНО: было #fff */
            margin: 0;
            display: flex; align-items: center; gap: 1rem;
        }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        /* Статистика (Стеклянные карточки с разными свечениями) */
        .stat-card {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.25rem;
            padding: 1.5rem; text-align: center;
            transition: all 0.3s ease; position: relative; overflow: hidden;
            animation: fadeUp 0.5s ease-out calc(var(--delay) * 0.1s) both;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--stat-color); opacity: 0.7; box-shadow: 0 0 15px var(--stat-color);
        }
        .stat-card:hover {
            transform: translateY(-5px); border-color: var(--glass-hover);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 30px rgba(var(--stat-rgb), 0.15);
        }

        .stat-label { font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; }
        .stat-value {
            font-size: 2.5rem; font-weight: 800;
            color: var(--text-main); /* ИСПРАВЛЕНО: было #fff */
            margin: 0; text-shadow: 0 0 20px rgba(var(--stat-rgb), 0.3);
        }

        /* Панель быстрых действий */
        .action-card {
            background: var(--glass-bg); /* ИСПРАВЛЕНО: был жесткий черный цвет */
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem; padding: 2rem;
        }
        .action-card-title {
            color: var(--text-main); /* ИСПРАВЛЕНО: было #fff */
            font-weight: 700; margin-bottom: 1.5rem; font-size: 1.25rem;
        }

        .btn-action-glow {
            display: flex; align-items: center; gap: 1rem;
            width: 100%; padding: 1rem 1.5rem;
            background: var(--glass-bg); border: 1px solid var(--glass-border);
            color: var(--text-main); /* ИСПРАВЛЕНО: было #fff */
            font-weight: 500; border-radius: 1rem;
            transition: all 0.3s ease; text-decoration: none;
        }
        .btn-action-glow i { font-size: 1.25rem; color: var(--accent-primary); transition: all 0.3s ease; }

        .btn-action-glow:hover {
            background: rgba(0, 102, 255, 0.1); border-color: rgba(0, 102, 255, 0.3);
            color: var(--accent-primary); /* ИСПРАВЛЕНО: было #fff */
            transform: translateX(5px); box-shadow: 0 0 20px rgba(0, 102, 255, 0.1);
        }
        .btn-action-glow:hover i { text-shadow: 0 0 10px rgba(0, 102, 255, 0.5); transform: scale(1.1); }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-shield-lock"></i> Центр управления</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card" style="--stat-color: var(--accent-primary); --stat-rgb: 0, 102, 255; --delay: 1;">
                    <div class="stat-label">Пользователи</div>
                    <h3 class="stat-value">{{ $stats['users'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="--stat-color: var(--neon-purple); --stat-rgb: 157, 78, 221; --delay: 2;">
                    <div class="stat-label">Организации</div>
                    <h3 class="stat-value">{{ $stats['organizations'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="--stat-color: var(--neon-success); --stat-rgb: 6, 214, 160; --delay: 3;">
                    <div class="stat-label">Всего записей</div>
                    <h3 class="stat-value">{{ $stats['bookings'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="--stat-color: var(--neon-warning); --stat-rgb: 255, 209, 102; --delay: 4;">
                    <div class="stat-label">Ожидают проверку</div>
                    <h3 class="stat-value">{{ $stats['pending_orgs'] }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="action-card">
                    <h5 class="action-card-title">Быстрые действия</h5>
                    <div class="d-flex flex-column gap-3">
                        <a href="{{ route('admin.users') }}" class="btn-action-glow">
                            <i class="bi bi-people"></i> Управление пользователями
                        </a>
                        <a href="{{ route('admin.organizations') }}" class="btn-action-glow">
                            <i class="bi bi-buildings"></i> Управление организациями
                        </a>
                        <a href="{{ route('admin.categories') }}" class="btn-action-glow">
                            <i class="bi bi-tags"></i> Управление категориями
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
