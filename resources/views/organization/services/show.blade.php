@extends('layouts.app')

@section('title', $service->title)

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - SERVICE DETAILS & BOOKING
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-secondary: #a0a0b8;
            --text-tertiary: #6b6b80;
            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-success: #06d6a0;
            --neon-info: #00d2ff;
        }

        .dark-page-wrapper {
            position: relative;
            padding-bottom: 4rem;
        }

        /* Фоновое свечение */
        .ambient-glow {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 1000px;
            height: 600px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.15) 0%, rgba(123, 44, 191, 0.05) 40%, transparent 70%);
            pointer-events: none;
            z-index: -1;
            filter: blur(50px);
        }

        /* Стеклянные панели */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            position: relative;
        }

        .glass-panel-sticky {
            position: sticky;
            top: 100px;
            padding: 2rem;
            text-align: center;
            border-radius: 1.5rem;
            background: linear-gradient(180deg, rgba(20, 20, 30, 0.8) 0%, rgba(10, 10, 15, 0.9) 100%);
        }

        .glass-panel-sticky::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-purple));
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.4);
        }

        /* Заголовок услуги */
        .service-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        /* Бейджи */
        .neon-badge {
            padding: 0.4rem 1rem;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .badge-category {
            background: rgba(123, 44, 191, 0.15);
            color: #c77dff;
            border: 1px solid rgba(123, 44, 191, 0.3);
            box-shadow: inset 0 0 10px rgba(123, 44, 191, 0.1);
        }

        .badge-duration {
            background: rgba(0, 210, 255, 0.15);
            color: var(--neon-info);
            border: 1px solid rgba(0, 210, 255, 0.3);
            box-shadow: inset 0 0 10px rgba(0, 210, 255, 0.1);
        }

        /* Описание */
        .service-description {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.7;
            margin: 2rem 0;
            white-space: pre-line;
        }

        /* Блок организации */
        .org-box {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-top: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .org-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-secondary);
        }

        .org-details h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .org-details p {
            color: var(--text-tertiary);
            margin: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Боковая панель с ценой */
        .price-display {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--neon-success);
            margin-bottom: 1.5rem;
            text-shadow: 0 0 30px rgba(6, 214, 160, 0.3);
            line-height: 1;
        }

        .btn-book-glow {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff;
            font-weight: 800;
            font-size: 1.1rem;
            border-radius: 99px;
            border: none;
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.4);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            animation: pulseBtn 2s infinite;
        }

        .btn-book-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.6);
            color: #fff;
            animation: none;
        }

        @keyframes pulseBtn {
            0% { box-shadow: 0 0 0 0 rgba(0, 102, 255, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(0, 102, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 102, 255, 0); }
        }

        .alert-glass-info {
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid rgba(0, 210, 255, 0.2);
            color: var(--neon-info);
            border-radius: 1rem;
            padding: 1rem;
            font-weight: 500;
        }

        /* ============================================
           DARK NEON UI - MODAL
           ============================================ */
        .modal-content.glass-modal {
            background: rgba(20, 20, 30, 0.85);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.6);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.5rem 2rem;
        }

        .modal-title {
            font-weight: 800;
            color: #fff;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.5rem 2rem;
        }

        /* Формы внутри модалки */
        .glass-input, .glass-textarea {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--glass-border);
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
            color-scheme: dark; /* Важно для календаря */
        }

        .glass-input:focus, .glass-textarea:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
        }

        /* Слоты времени */
        .slot-btn {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
            padding: 0.6rem 1.2rem;
            border-radius: 99px;
            font-weight: 600;
            transition: all 0.2s ease;
            margin: 0.25rem;
        }

        .slot-btn.unselected:hover {
            border-color: var(--accent-primary);
            color: var(--accent-primary);
            background: rgba(0, 102, 255, 0.05);
        }

        .slot-btn.selected {
            background: var(--accent-primary);
            border-color: var(--accent-primary);
            color: #fff;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
            transform: scale(1.05);
        }

        /* Анимации */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="dark-page-wrapper container py-5">
        <div class="ambient-glow"></div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-panel mb-4">
                    <h1 class="service-title">{{ $service->title }}</h1>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="neon-badge badge-category">
                            <i class="bi bi-tag"></i> {{ $service->category->name ?? 'Без категории' }}
                        </span>
                        <span class="neon-badge badge-duration">
                            <i class="bi bi-clock-history"></i> {{ $service->duration }} минут
                        </span>
                    </div>

                    <div class="service-description">
                        {{ $service->description }}
                    </div>

                    <div class="org-box">
                        <div class="org-icon">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div class="org-details">
                            <h5>{{ $service->organization->name ?? 'Организация' }}</h5>
                            <p>
                                <i class="bi bi-geo-alt"></i>
                                {{ $service->organization->address ?? 'Адрес не указан' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="glass-panel glass-panel-sticky">
                    <div style="color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Стоимость услуги</div>
                    <div class="price-display">{{ number_format($service->price, 0, '', ' ') }} ₽</div>

                    @auth
                        @if(auth()->user()->isClient())
                            <button type="button" class="btn-book-glow" data-bs-toggle="modal" data-bs-target="#bookingModal">
                                <i class="bi bi-calendar2-check me-2"></i> Записаться
                            </button>
                        @elseif(auth()->user()->isOrganization())
                            <div class="alert-glass-info">
                                <i class="bi bi-info-circle me-1"></i> Вы вошли как организация. Запись доступна только клиентам.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light w-100 py-3 rounded-pill fw-bold" style="border-color: var(--glass-border);">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Войдите, чтобы записаться
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->isClient())
            <div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content glass-modal">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-calendar-plus me-2" style="color: var(--accent-primary);"></i>Оформление записи</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label" style="color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Выберите дату</label>
                                <input type="date" id="booking_date" class="glass-input" min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Доступное время</label>
                                <div id="time_slots" class="d-flex flex-wrap gap-2 p-3" style="background: rgba(0,0,0,0.2); border-radius: 1rem; border: 1px solid var(--glass-border); min-height: 80px;">
                                    <div class="text-center w-100 my-auto" style="color: var(--text-tertiary);">
                                        <i class="bi bi-calendar-event d-block fs-3 mb-2"></i>
                                        Сначала укажите желаемую дату
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Пожелания (необязательно)</label>
                                <textarea id="comment" class="glass-textarea" rows="2" placeholder="Ваши пожелания мастеру..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between border-top-0">
                            <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal" style="border-color: var(--glass-border);">Отмена</button>
                            <button type="button" id="submit_booking" class="btn-book-glow m-0" style="width: auto; padding: 0.7rem 2rem; animation: none;" disabled>
                                Подтвердить
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const serviceId = {{ $service->id }};
                const dateInput = document.getElementById('booking_date');
                const slotsDiv = document.getElementById('time_slots');
                const submitBtn = document.getElementById('submit_booking');
                let selectedSlotId = null;

                dateInput.addEventListener('change', function() {
                    const date = this.value;
                    if (!date) return;

                    slotsDiv.innerHTML = '<div class="text-center w-100 my-auto" style="color: var(--accent-primary);"><div class="spinner-border spinner-border-sm me-2"></div>Загрузка слотов...</div>';
                    submitBtn.disabled = true;
                    selectedSlotId = null;

                    fetch(`/api/services/${serviceId}/slots?date=${date}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success && data.slots.length > 0) {
                                slotsDiv.innerHTML = '';
                                data.slots.forEach(slot => {
                                    const btn = document.createElement('button');
                                    btn.type = 'button';
                                    btn.className = 'slot-btn unselected';
                                    btn.innerHTML = `<i class="bi bi-clock me-1"></i>${slot.start_time}`;
                                    btn.dataset.id = slot.id;

                                    btn.onclick = () => {
                                        document.querySelectorAll('#time_slots .slot-btn').forEach(b => {
                                            b.classList.remove('selected');
                                            b.classList.add('unselected');
                                        });
                                        btn.classList.remove('unselected');
                                        btn.classList.add('selected');
                                        selectedSlotId = slot.id;
                                        submitBtn.disabled = false;
                                    };
                                    slotsDiv.appendChild(btn);
                                });
                            } else {
                                slotsDiv.innerHTML = '<div class="text-center w-100 my-auto" style="color: var(--neon-warning);"><i class="bi bi-emoji-frown d-block fs-3 mb-2"></i>Нет свободных слотов на эту дату</div>';
                            }
                        })
                        .catch(() => {
                            slotsDiv.innerHTML = '<div class="text-center w-100 my-auto" style="color: var(--neon-danger);"><i class="bi bi-exclamation-triangle d-block fs-3 mb-2"></i>Ошибка загрузки слотов</div>';
                        });
                });

                submitBtn.addEventListener('click', function() {
                    if (!selectedSlotId) return;

                    // Меняем текст кнопки на спиннер во время отправки
                    const originalText = this.innerHTML;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Отправка...';
                    this.disabled = true;

                    fetch(`/bookings/${serviceId}/store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            time_slot_id: selectedSlotId,
                            comment: document.getElementById('comment').value
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert('Запись успешно оформлена! Ожидайте подтверждения.');
                                location.reload();
                            } else {
                                alert(data.message || 'Произошла ошибка при создании записи.');
                                this.innerHTML = originalText;
                                this.disabled = false;
                            }
                        })
                        .catch(() => {
                            alert('Произошла ошибка при создании записи.');
                            this.innerHTML = originalText;
                            this.disabled = false;
                        });
                });
            </script>
        @endif
    @endauth
@endsection
