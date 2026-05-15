@extends('layouts.app')

@section('title', 'Мастер управления временем')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - ELITE SLOT ORCHESTRATOR (RU)
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #ffffff;
            --text-description: #e2e8f0;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
            --neon-danger: #ef476f;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 4rem; }
        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 100%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.15) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2.5rem; animation: slideDown 0.5s ease-out;
            flex-wrap: wrap; gap: 1rem;
        }
        .page-title { font-size: 2.2rem; font-weight: 800; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 1rem; }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        .btn-back-glass {
            background: rgba(255, 255, 255, 0.08); color: #fff; border: 1px solid var(--glass-border);
            border-radius: 99px; padding: 0.6rem 1.5rem; font-weight: 700; text-decoration: none; transition: 0.3s;
        }
        .btn-back-glass:hover { background: rgba(255, 255, 255, 0.15); transform: translateX(-5px); }

        /* АККОРДЕОН */
        .glass-accordion { border: none; background: transparent; }
        .accordion-item {
            background: var(--glass-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem !important;
            margin-bottom: 1.5rem; overflow: hidden; animation: fadeUp 0.6s ease-out both;
        }

        .accordion-header { display: flex; align-items: center; background: transparent; }
        .accordion-header .accordion-button {
            background: transparent; color: #fff; font-weight: 800; font-size: 1.25rem;
            padding: 1.75rem; border: none; box-shadow: none; flex-grow: 1;
            text-transform: capitalize;
        }
        .accordion-button:not(.collapsed) { color: var(--accent-primary); background: rgba(0, 102, 255, 0.05); }
        .accordion-button::after { filter: invert(1); margin-left: 1rem; }

        /* Кнопка удаления */
        .btn-delete-day {
            background: rgba(239, 71, 111, 0.1); color: var(--neon-danger);
            border: 1px solid rgba(239, 71, 111, 0.2); border-radius: 12px;
            padding: 0.6rem 1.2rem; font-size: 0.85rem; font-weight: 800;
            margin-right: 1.5rem; transition: 0.3s; display: flex; align-items: center; gap: 0.6rem;
            z-index: 10; position: relative; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .btn-delete-day:hover { background: var(--neon-danger); color: #fff; box-shadow: 0 0 20px rgba(239, 71, 111, 0.4); border-color: var(--neon-danger); }

        /* СЕТКА СЛОТОВ */
        .slots-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem; }

        .slot-chip {
            background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem; padding: 1.5rem; transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex; flex-direction: column; align-items: center; gap: 1rem;
            position: relative;
        }
        .slot-chip:hover {
            border-color: var(--accent-primary); background: rgba(0, 102, 255, 0.08);
            transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        }

        .slot-time { font-size: 1.4rem; font-weight: 900; color: var(--text-main); letter-spacing: 1px; text-shadow: 0 0 10px rgba(255,255,255,0.1); }
        .slot-actions { display: flex; gap: 0.75rem; width: 100%; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1rem; justify-content: center; }

        .btn-slot-action {
            width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
            border: 1px solid var(--glass-border); transition: 0.3s; background: rgba(255,255,255,0.03); color: var(--text-muted);
            text-decoration: none;
        }
        .btn-slot-edit:hover { color: var(--neon-warning); border-color: var(--neon-warning); background: rgba(255, 209, 102, 0.1); box-shadow: 0 0 15px rgba(255, 209, 102, 0.2); }
        .btn-slot-delete:hover { color: var(--neon-danger); border-color: var(--neon-danger); background: rgba(239, 71, 111, 0.1); box-shadow: 0 0 15px rgba(239, 71, 111, 0.3); }

        /* МОДАЛЬНОЕ ОКНО */
        .glass-modal .modal-content { background: rgba(15, 15, 25, 0.98); backdrop-filter: blur(40px); border: 1px solid var(--glass-border); border-radius: 2rem; color: #fff; box-shadow: 0 0 50px rgba(0,0,0,0.8); }
        .glass-input { background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); color: #fff; border-radius: 1rem; padding: 1rem 1.25rem; width: 100%; color-scheme: dark; font-weight: 700; font-size: 1.1rem; }
        .glass-input:focus { border-color: var(--accent-primary); outline: none; box-shadow: 0 0 15px rgba(0, 102, 255, 0.3); }

        .shift-notice {
            background: linear-gradient(135deg, rgba(255, 170, 0, 0.15) 0%, rgba(20, 20, 30, 0.8) 100%);
            border: 1px solid rgba(255, 170, 0, 0.3); border-radius: 1.5rem; padding: 1.5rem;
            margin-top: 1.5rem;
        }
        .form-switch .form-check-input { width: 3em; height: 1.5em; cursor: pointer; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-calendar2-range-fill"></i> Управление временными слотами</h1>
            <a href="{{ route('organization.schedule.index', $service->id) }}" class="btn-back-glass">
                <i class="bi bi-arrow-left-circle me-2"></i> К основному расписанию
            </a>
        </div>

        {{-- ИСПРАВЛЕНИЕ: ДОБАВЛЕН БЛОК УВЕДОМЛЕНИЙ И ОШИБОК --}}
        @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25 text-white rounded-4 mb-4 shadow-lg">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check2-all fs-4 me-3 text-success"></i>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-white rounded-4 mb-4 shadow-lg">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                    <div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if($slotsByDate->count() > 0)
            <div class="accordion glass-accordion" id="slotsAccordion">
                @foreach($slotsByDate as $date => $slots)
                    <div class="accordion-item shadow-lg">
                        <div class="accordion-header">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}">
                                <i class="bi bi-calendar-event-fill me-3 text-primary"></i>
                                {{ \Carbon\Carbon::parse($date)->locale('ru')->translatedFormat('d F Y') }}
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary ms-3" style="font-size: 0.75rem; border: 1px solid rgba(0,102,255,0.3); font-weight: 800;">
                                    {{ $slots->count() }} СЛОТОВ
                                </span>
                            </button>

                            <form action="{{ route('organization.slots.destroyDay', ['serviceId' => $service->id, 'date' => $date]) }}" method="POST" onsubmit="return confirm('Удалить этот день?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete-day">
                                    <i class="bi bi-calendar-x-fill"></i> Удалить
                                </button>
                            </form>
                        </div>

                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#slotsAccordion">
                            <div class="accordion-body p-4">
                                <div class="slots-grid">
                                    @foreach($slots as $slot)
                                        <div class="slot-chip">
                                            <div class="slot-time">
                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                <span class="opacity-25 mx-2">—</span>
                                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                            </div>

                                            <div class="slot-actions">
                                                <button type="button" class="btn-slot-action btn-slot-edit" data-bs-toggle="modal" data-bs-target="#editSlot{{ $slot->id }}" title="Редактировать время">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <form action="{{ route('organization.slots.destroy', $slot->id) }}" method="POST" onsubmit="return confirm('Удалить этот интервал?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-slot-action btn-slot-delete" title="Удалить слот">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-panel text-center py-5 shadow-lg">
                <div class="bg-primary bg-opacity-10 d-inline-flex p-4 rounded-circle mb-4">
                    <i class="bi bi-calendar-x-fill fs-1 text-primary"></i>
                </div>
                <h4 class="text-white fw-bold">Свободные окна не найдены</h4>
                <p class="text-white-50">Перейдите в настройки расписания, чтобы сгенерировать новые интервалы.</p>
                <a href="{{ route('organization.schedule.index', $service->id) }}" class="btn btn-primary rounded-pill px-5 py-3 mt-3 fw-bold">
                    <i class="bi bi-magic me-2"></i> Перейти к генератору графиков
                </a>
            </div>
        @endif
    </div>

    @foreach($slotsByDate as $date => $slots)
        @foreach($slots as $slot)
            <div class="modal fade glass-modal" id="editSlot{{ $slot->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold"><i class="bi bi-clock-history me-2 text-warning"></i>Корректировка интервала</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('organization.slots.update', $slot->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-body p-4">
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <label class="text-white-50 small text-uppercase fw-bold mb-2 d-block">Начало приема</label>
                                        <input type="time" name="start_time" class="glass-input" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-white-50 small text-uppercase fw-bold mb-2 d-block">Завершение</label>
                                        <input type="time" name="end_time" class="glass-input" value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}" required>
                                    </div>
                                </div>

                                <div class="shift-notice">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="shift_others" id="shift{{ $slot->id }}" value="1" checked>
                                        <label class="form-check-label fw-bold text-white ms-2" for="shift{{ $slot->id }}" style="cursor:pointer">
                                            Умный сдвиг очереди
                                        </label>
                                    </div>
                                    <p class="small text-white-50 mb-0">Автоматически сдвинуть все последующие окна в этот день на ту же разницу во времени.</p>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-link text-white-50 text-decoration-none" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-lg">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

@endsection
