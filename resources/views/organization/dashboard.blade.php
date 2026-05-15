@extends('layouts.app')

@section('title', 'Панель организации')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - ORGANIZATION DASHBOARD
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-muted: #94a3b8; /* Светло-серый, читаемый */

            --accent-primary: #0066ff;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
            --neon-danger: #ef476f;
            --neon-info: #00d2ff;
            --neon-purple: #7b2cbf;
        }

        /* Переопределяем Bootstrap, чтобы текст не был невидимым */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 4rem; }
        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 80%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.1) 0%, transparent 60%);
            pointer-events: none; z-index: -1;
        }

        /* Предупреждение о профиле */
        .neon-alert-warning {
            background: rgba(255, 209, 102, 0.05); border: 1px solid rgba(255, 209, 102, 0.3);
            border-radius: 1rem; padding: 1.25rem; margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(255, 209, 102, 0.1); color: var(--text-main);
            display: flex; align-items: center; justify-content: space-between;
        }
        .neon-alert-warning i { color: var(--neon-warning); font-size: 1.5rem; text-shadow: 0 0 10px rgba(255, 209, 102, 0.4); }
        .btn-alert-action {
            background: var(--neon-warning); color: #000; padding: 0.5rem 1.5rem;
            border-radius: 99px; font-weight: 700; text-decoration: none; transition: 0.2s;
        }
        .btn-alert-action:hover { background: #ffdf80; box-shadow: 0 0 15px rgba(255, 209, 102, 0.5); color: #000; }

        /* Карточки статистики */
        .stat-card {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 1.5rem; transition: all 0.3s ease; position: relative; overflow: hidden;
            animation: fadeUp 0.5s ease-out calc(var(--delay) * 0.1s) both; height: 100%;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--stat-color); opacity: 0.7; box-shadow: 0 0 15px var(--stat-color);
        }
        .stat-card:hover { transform: translateY(-5px); border-color: rgba(255,255,255,0.15); box-shadow: 0 15px 30px rgba(0,0,0,0.4); }

        .stat-label { font-size: 0.8rem; color: var(--text-description); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; margin-bottom: 0.5rem; }
        .stat-value { font-size: 2.2rem; font-weight: 800; color: var(--text-main); margin: 0; text-shadow: 0 0 15px rgba(var(--stat-rgb), 0.2); line-height: 1; }
        .stat-icon { font-size: 2.5rem; opacity: 0.6; color: var(--stat-color); filter: drop-shadow(0 0 10px rgba(var(--stat-rgb), 0.3)); }

        .urgent-badge {
            background: rgba(239, 71, 111, 0.15); border: 1px solid var(--neon-danger);
            color: var(--neon-danger); padding: 0.3rem 0.8rem; border-radius: 99px;
            font-size: 0.75rem; font-weight: 700; display: inline-block; margin-top: 0.5rem;
            box-shadow: inset 0 0 10px rgba(239, 71, 111, 0.2), 0 0 10px rgba(239, 71, 111, 0.3);
            animation: pulseDanger 2s infinite;
        }

        /* Стеклянные панели (Услуги и Записи) */
        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 1.5rem; animation: fadeUp 0.6s ease-out 0.4s both; height: 100%;
        }
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem; }
        .panel-title { color: var(--text-main); font-weight: 800; font-size: 1.25rem; margin: 0; display: flex; align-items: center; gap: 0.75rem; }
        .panel-title i { color: var(--accent-primary); }

        /* Кнопки "Добавить/Все" в панелях */
        .btn-panel-action {
            background: rgba(0, 102, 255, 0.1); color: var(--accent-primary); border: 1px solid rgba(0, 102, 255, 0.3);
            border-radius: 99px; padding: 0.4rem 1rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: 0.3s;
        }
        .btn-panel-action:hover { background: var(--accent-primary); color: #fff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        .link-view-all {
            color: var(--text-description); font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: 0.2s;
        }
        .link-view-all:hover {
            color: #fff; text-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
        }

        /* Элементы списка услуг */
        .service-item {
            padding: 1rem; background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 1rem; margin-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center; transition: 0.2s;
        }
        .service-item:hover { background: rgba(255, 255, 255, 0.03); border-color: rgba(255, 255, 255, 0.1); }
        .service-item-title { font-weight: 700; color: var(--text-main); margin-bottom: 0.2rem; }
        .service-item-meta { font-size: 0.85rem; color: var(--text-description); }

        .btn-icon-glass {
            background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-main);
            width: 35px; height: 35px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s;
            text-decoration: none;
        }
        .btn-icon-glass.schedule:hover { color: var(--neon-info); border-color: var(--neon-info); background: rgba(0, 210, 255, 0.1); box-shadow: 0 0 10px rgba(0, 210, 255, 0.2); }
        .btn-icon-glass.edit:hover { color: var(--neon-warning); border-color: var(--neon-warning); background: rgba(255, 209, 102, 0.1); box-shadow: 0 0 10px rgba(255, 209, 102, 0.2); }

        /* Элементы списка записей */
        .booking-item {
            padding: 1.25rem; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem; margin-bottom: 1rem; transition: 0.2s;
        }
        .booking-item:hover { border-color: rgba(255, 255, 255, 0.15); transform: translateX(5px); }

        .booking-client { font-weight: 700; color: var(--neon-info); display: flex; align-items: center; gap: 0.4rem; font-size: 0.95rem; margin-bottom: 0.25rem; }
        .booking-service { font-weight: 800; color: var(--text-main); font-size: 1.1rem; margin-bottom: 0.4rem; }
        .booking-date { font-size: 0.85rem; color: var(--text-description); display: flex; align-items: center; gap: 0.75rem; }

        /* Кнопки управления записью */
        .action-btns-group { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem; }
        .btn-action-solid { padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700; border: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 0.3rem; }

        .btn-accept { background: rgba(6, 214, 160, 0.15); color: var(--neon-success); border: 1px solid var(--neon-success); }
        .btn-accept:hover { background: var(--neon-success); color: #000; box-shadow: 0 0 15px rgba(6, 214, 160, 0.4); }

        .btn-reject { background: rgba(239, 71, 111, 0.15); color: var(--neon-danger); border: 1px solid var(--neon-danger); }
        .btn-reject:hover { background: var(--neon-danger); color: #fff; box-shadow: 0 0 15px rgba(239, 71, 111, 0.4); }

        .btn-complete { background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-purple) 100%); color: #fff; box-shadow: 0 5px 15px rgba(0, 102, 255, 0.3); }
        .btn-complete:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(123, 44, 191, 0.4); }

        .status-badge { padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid transparent; display: inline-block; margin-top: 0.5rem; }
        .status-confirmed { background: rgba(6, 214, 160, 0.1); color: var(--neon-success); border-color: rgba(6, 214, 160, 0.3); }
        .status-completed { background: rgba(0, 210, 255, 0.1); color: var(--neon-info); border-color: rgba(0, 210, 255, 0.3); }
        .status-cancelled, .status-rejected { background: rgba(255, 255, 255, 0.05); color: var(--text-description); border-color: var(--glass-border); }

        @keyframes pulseDanger { 0% { box-shadow: inset 0 0 10px rgba(239,71,111,0.2), 0 0 0 0 rgba(239,71,111,0.4); } 70% { box-shadow: inset 0 0 10px rgba(239,71,111,0.2), 0 0 0 10px rgba(239,71,111,0); } 100% { box-shadow: inset 0 0 10px rgba(239,71,111,0.2), 0 0 0 0 rgba(239,71,111,0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper container py-4">
        <div class="ambient-glow"></div>

        @if(!$organization)
            <div class="neon-alert-warning">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <strong class="d-block mb-1">Профиль не заполнен!</strong>
                        <span style="color: var(--text-description); font-size: 0.9rem;">Сначала создайте профиль организации, чтобы добавлять услуги и принимать клиентов.</span>
                    </div>
                </div>
                <a href="{{ route('organization.profile.create') }}" class="btn-alert-action">Заполнить профиль <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card" style="--stat-color: var(--accent-primary); --stat-rgb: 0, 102, 255; --delay: 1;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Организация</div>
                        <i class="bi bi-building stat-icon"></i>
                    </div>
                    <h4 class="stat-value text-truncate" style="font-size: 1.5rem;" title="{{ $organization->name ?? auth()->user()->name }}">
                        {{ $organization->name ?? auth()->user()->name }}
                    </h4>
                    <div style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem;">Ваш рабочий профиль</div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card" style="--stat-color: var(--neon-info); --stat-rgb: 0, 210, 255; --delay: 2;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Услуги в каталоге</div>
                        <i class="bi bi-grid-3x3-gap stat-icon"></i>
                    </div>
                    <h2 class="stat-value">{{ $servicesCount }}</h2>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card" style="--stat-color: var(--neon-success); --stat-rgb: 6, 214, 160; --delay: 3;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Записей сегодня</div>
                        <i class="bi bi-calendar-check stat-icon"></i>
                    </div>
                    <h2 class="stat-value">{{ $todayBookings }}</h2>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <a href="{{ route('organization.reviews.index') }}" style="text-decoration: none; display: block; height: 100%;">
                    <div class="stat-card" style="--stat-color: var(--neon-warning); --stat-rgb: 255, 209, 102; --delay: 4;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="stat-label">Отзывы клиентов</div>
                            <i class="bi bi-star stat-icon"></i>
                        </div>
                        @php
                            $reviewsCount = $organization ? \App\Models\Review::where('organization_id', $organization->id)->count() : 0;
                            $unansweredCount = $organization ? \App\Models\Review::where('organization_id', $organization->id)->whereNull('reply')->count() : 0;
                        @endphp
                        <h2 class="stat-value">{{ $reviewsCount }}</h2>
                        @if($unansweredCount > 0)
                            <div class="urgent-badge">Ждут ответа: {{ $unansweredCount }}</div>
                        @else
                            <div style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem;"><i class="bi bi-check2-all text-success"></i> Все отвечены</div>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-5">
                <div class="glass-panel">
                    <div class="panel-header">
                        <h5 class="panel-title"><i class="bi bi-layers"></i> Услуги</h5>
                        <a href="{{ route('organization.services.create') }}" class="btn-panel-action"><i class="bi bi-plus-lg"></i> Добавить</a>
                    </div>

                    @if($recentServices->count() > 0)
                        <div class="services-list">
                            @foreach($recentServices as $service)
                                <div class="service-item">
                                    <div>
                                        <div class="service-item-title">{{ $service->title }}</div>
                                        <div class="service-item-meta">{{ number_format($service->price, 0, '', ' ') }} ₽ <span class="mx-1">•</span> <i class="bi bi-clock"></i> {{ $service->duration }} мин</div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('organization.schedule.index', $service->id) }}" class="btn-icon-glass schedule" title="Настроить расписание"><i class="bi bi-calendar-week"></i></a>
                                        <a href="{{ route('organization.services.edit', $service->id) }}" class="btn-icon-glass edit" title="Редактировать услугу"><i class="bi bi-pencil"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('organization.services.index') }}" class="link-view-all">
                                Все услуги <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-grid-3x3-gap fs-1 opacity-25"></i>
                            <p class="mt-2 mb-0" style="color: var(--text-description);">У вас пока нет добавленных услуг.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-xl-7">
                <div class="glass-panel">
                    <div class="panel-header">
                        <h5 class="panel-title"><i class="bi bi-calendar-check"></i> Записи (Action Center)</h5>
                        <div style="color: var(--text-description); font-size: 0.9rem;">Очередь клиентов</div>
                    </div>

                    @if($recentBookings->count() > 0)
                        <div class="bookings-list">
                            @foreach($recentBookings as $booking)
                                <div class="booking-item">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="booking-client"><i class="bi bi-person-circle"></i> {{ $booking->client->name }}</div>

                                            @if($booking->status === 'confirmed')
                                                <span class="status-badge status-confirmed">Ожидает визита</span>
                                            @elseif($booking->status === 'rejected')
                                                <span class="status-badge status-rejected">Отклонена вами</span>
                                            @elseif($booking->status === 'cancelled')
                                                <span class="status-badge status-cancelled">Отменена клиентом</span>
                                            @elseif($booking->status === 'completed')
                                                <span class="status-badge status-completed">Успешно завершена</span>
                                            @endif
                                        </div>

                                        <div class="booking-service">{{ $booking->service->title }}</div>
                                        <div class="booking-date">
                                            <span><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</span>
                                            <span><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</span>
                                        </div>

                                        @if($booking->status === 'pending')
                                            <div class="action-btns-group border-top border-secondary border-opacity-10 pt-3 mt-3">
                                                <form action="{{ route('bookings.accept', $booking) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn-action-solid btn-accept"><i class="bi bi-check-lg"></i> Подтвердить запись</button>
                                                </form>
                                                <form action="{{ route('bookings.reject', $booking) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn-action-solid btn-reject" onclick="return confirm('Вы уверены, что хотите отказать клиенту?')"><i class="bi bi-x-lg"></i> Отказать</button>
                                                </form>
                                            </div>
                                        @elseif($booking->status === 'confirmed')
                                            <div class="action-btns-group border-top border-secondary border-opacity-10 pt-3 mt-3">
                                                <form action="{{ route('bookings.complete', $booking) }}" method="POST" class="w-100">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn-action-solid btn-complete w-100 justify-content-center py-2" onclick="return confirm('Услуга оказана? Отметить как завершенную?')">
                                                        <i class="bi bi-stars"></i> Отметить как выполненную
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 opacity-25 text-muted"></i>
                            <p class="mt-3 mb-0" style="color: var(--text-description); font-size: 1.1rem;">В очереди пока нет записей.</p>
                            <p class="small opacity-75" style="color: var(--text-muted);">Когда клиенты запишутся, они появятся здесь.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
