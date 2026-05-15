@extends('layouts.app')

@section('title', 'Редактировать услугу')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - ADVANCED EDIT FORM
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);

            /* Высокий контраст для читаемости */
            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-tertiary: #94a3b8;

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-danger: #ef476f;
            --neon-warning: #ffd166;
            --neon-success: #06d6a0;
        }

        .dark-page-wrapper {
            position: relative;
            padding-bottom: 3rem;
        }

        /* Фоновое свечение (Слегка фиолетовое для отличия от страницы создания) */
        .ambient-glow {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 900px;
            height: 500px;
            background: radial-gradient(circle at 50% 50%, rgba(123, 44, 191, 0.15) 0%, rgba(0, 102, 255, 0.05) 50%, transparent 70%);
            pointer-events: none;
            z-index: -1;
            filter: blur(40px);
            animation: pulseGlow 8s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.5; transform: translate(-50%, 0) scale(0.9); }
            100% { opacity: 1; transform: translate(-50%, 0) scale(1.1); }
        }

        .page-header {
            text-align: center;
            margin-bottom: 2.5rem;
            animation: slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .page-title i {
            color: var(--accent-purple);
            text-shadow: 0 0 15px rgba(123, 44, 191, 0.4);
        }

        /* Стеклянная панель */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            position: relative;
            overflow: hidden;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-purple));
            box-shadow: 0 0 20px rgba(123, 44, 191, 0.5);
        }

        /* Заголовки секций формы */
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .section-title i { color: var(--accent-purple); }

        /* Элементы формы */
        .form-label {
            color: var(--text-description);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .asterisk {
            color: var(--neon-warning);
            text-shadow: 0 0 5px rgba(255, 209, 102, 0.5);
            font-size: 1rem;
        }

        .glass-input, .glass-select, .glass-textarea {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 0.75rem;
            padding: 0.875rem 1.25rem;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .glass-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .glass-select option { background-color: #12121a; color: #fff; padding: 10px; }

        .glass-input:focus, .glass-select:focus, .glass-textarea:focus {
            outline: none;
            background: rgba(0, 0, 0, 0.6);
            border-color: var(--accent-purple);
            box-shadow: 0 0 0 4px rgba(123, 44, 191, 0.1), inset 0 0 10px rgba(123, 44, 191, 0.1);
        }

        .glass-input::placeholder, .glass-textarea::placeholder { color: #64748b; }

        /* Валидация (Ошибки) */
        .glass-input.is-invalid, .glass-select.is-invalid, .glass-textarea.is-invalid {
            border-color: var(--neon-danger);
            box-shadow: 0 0 0 4px rgba(239, 71, 111, 0.1);
        }

        .invalid-feedback-neon {
            color: var(--neon-danger); font-size: 0.85rem; margin-top: 0.5rem;
            display: flex; align-items: center; gap: 0.4rem; text-shadow: 0 0 5px rgba(239, 71, 111, 0.2);
        }

        .neon-alert-danger {
            background: rgba(239, 71, 111, 0.05); border: 1px solid rgba(239, 71, 111, 0.3);
            border-radius: 1rem; padding: 1.25rem; margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(239, 71, 111, 0.1); display: flex; align-items: flex-start; gap: 1rem;
        }
        .neon-alert-danger i { color: var(--neon-danger); font-size: 1.5rem; text-shadow: 0 0 10px rgba(239, 71, 111, 0.4); }
        .neon-alert-danger ul { margin: 0; padding-left: 1rem; color: var(--text-main); font-size: 0.95rem; }

        /* Подсказки (Hints) */
        .hint-text {
            display: flex; align-items: center; gap: 0.4rem; font-size: 0.85rem;
            color: var(--text-description); margin-top: 0.5rem;
        }
        .hint-text i { color: var(--accent-purple); }

        /* Иконки внутри полей */
        .input-icon-wrapper { position: relative; }
        .input-icon-wrapper .input-icon {
            position: absolute; right: 1.25rem; top: 50%;
            transform: translateY(-50%); color: var(--text-tertiary); pointer-events: none;
        }
        .input-icon-wrapper .glass-input { padding-right: 3rem; }

        /* Неоновый Тумблер (Свитч) */
        .neon-switch-wrapper {
            display: flex; align-items: center; gap: 1rem; padding: 1rem;
            background: rgba(255, 255, 255, 0.02); border: 1px solid var(--glass-border);
            border-radius: 1rem; transition: all 0.3s ease;
        }
        .neon-switch-wrapper:hover { background: rgba(255, 255, 255, 0.04); border-color: rgba(255, 255, 255, 0.15); }

        .neon-switch { position: relative; display: inline-block; width: 52px; height: 28px; flex-shrink: 0; }
        .neon-switch input { opacity: 0; width: 0; height: 0; }
        .neon-slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); border: 1px solid var(--glass-border);
            transition: .4s; border-radius: 34px;
        }
        .neon-slider:before {
            position: absolute; content: ""; height: 18px; width: 18px; left: 4px; bottom: 4px;
            background-color: var(--text-tertiary); transition: .4s; border-radius: 50%;
        }
        .neon-switch input:checked + .neon-slider {
            background-color: rgba(6, 214, 160, 0.15); border-color: var(--neon-success);
            box-shadow: inset 0 0 10px rgba(6, 214, 160, 0.2);
        }
        .neon-switch input:checked + .neon-slider:before {
            transform: translateX(24px); background-color: var(--neon-success);
            box-shadow: 0 0 10px rgba(6, 214, 160, 0.6);
        }

        /* Кнопки действий */
        .form-actions {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid var(--glass-border); gap: 1rem;
        }

        .btn-glass-back {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.875rem 1.75rem; background: transparent; color: var(--text-description);
            border: 1px solid var(--glass-border); border-radius: 99px; font-weight: 600;
            text-decoration: none; transition: all 0.3s ease;
        }
        .btn-glass-back:hover { background: rgba(255, 255, 255, 0.05); color: #fff; border-color: rgba(255, 255, 255, 0.2); }

        .btn-glow-submit {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.875rem 2.5rem; background: linear-gradient(135deg, var(--accent-purple) 0%, var(--accent-primary) 100%);
            color: #fff; font-weight: 700; border: none; border-radius: 99px;
            box-shadow: 0 8px 20px rgba(123, 44, 191, 0.3); transition: all 0.3s ease; cursor: pointer;
        }
        .btn-glow-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(123, 44, 191, 0.5); color: #fff; }

        /* Анимации */
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            .glass-panel { padding: 1.5rem; }
            .form-actions { flex-direction: column-reverse; }
            .btn-glass-back, .btn-glow-submit { width: 100%; justify-content: center; }
        }
    </style>

    <div class="dark-page-wrapper container py-4">
        <div class="ambient-glow"></div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="bi bi-pencil-square"></i>
                        Редактирование услуги
                    </h1>
                    <p style="color: var(--text-description); margin-top: 0.5rem; font-size: 1.1rem;">
                        Обновите параметры услуги <strong>{{ $service->title }}</strong>
                    </p>
                </div>

                <div class="glass-panel">
                    @if($errors->any())
                        <div class="neon-alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            <div>
                                <strong style="color: #fff; display: block; margin-bottom: 0.5rem;">Проверьте правильность заполнения полей:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('organization.services.update', $service) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="section-title">
                            <i class="bi bi-info-square"></i> Основная информация
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label">
                                Название услуги <span class="asterisk">*</span>
                            </label>
                            <input type="text" class="glass-input @error('title') is-invalid @enderror"
                                   name="title" id="title" value="{{ old('title', $service->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label">
                                Категория <span class="asterisk">*</span>
                            </label>
                            <select class="glass-select @error('category_id') is-invalid @enderror"
                                    name="category_id" id="category_id" required>
                                <option value="" disabled>Выберите категорию</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="description" class="form-label">
                                Подробное описание <span class="asterisk">*</span>
                            </label>
                            <textarea class="glass-textarea @error('description') is-invalid @enderror"
                                      name="description" id="description" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="section-title">
                            <i class="bi bi-tag"></i> Стоимость и параметры
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label for="price" class="form-label">
                                    Цена (₽) <span class="asterisk">*</span>
                                </label>
                                <div class="input-icon-wrapper">
                                    <input type="number" step="0.01" class="glass-input @error('price') is-invalid @enderror"
                                           name="price" id="price" value="{{ old('price', $service->price) }}" required>
                                    <i class="bi bi-currency-ruble input-icon"></i>
                                </div>
                                @error('price')
                                <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="duration" class="form-label">
                                    Длительность <span style="text-transform: lowercase; font-weight: 400;">(в минутах)</span> <span class="asterisk">*</span>
                                </label>
                                <div class="input-icon-wrapper">
                                    <input type="number" class="glass-input @error('duration') is-invalid @enderror"
                                           name="duration" id="duration" value="{{ old('duration', $service->duration) }}" required>
                                    <i class="bi bi-clock-history input-icon"></i>
                                </div>
                                @error('duration')
                                <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="section-title">
                            <i class="bi bi-sliders"></i> Правила бронирования
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="max_days_ahead" class="form-label">Глубина записи</label>
                                <div class="input-icon-wrapper">
                                    <input type="number" class="glass-input @error('max_days_ahead') is-invalid @enderror"
                                           name="max_days_ahead" id="max_days_ahead" value="{{ old('max_days_ahead', $service->max_days_ahead ?? 30) }}">
                                    <i class="bi bi-calendar3 input-icon"></i>
                                </div>
                                @error('max_days_ahead')
                                <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                                <div class="hint-text">
                                    <i class="bi bi-info-circle"></i> На сколько дней вперёд доступно расписание
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="cancellation_deadline_hours" class="form-label">Отмена за (часов)</label>
                                <div class="input-icon-wrapper">
                                    <input type="number" class="glass-input @error('cancellation_deadline_hours') is-invalid @enderror"
                                           name="cancellation_deadline_hours" id="cancellation_deadline_hours"
                                           value="{{ old('cancellation_deadline_hours', $service->cancellation_deadline_hours ?? 2) }}">
                                    <i class="bi bi-shield-x input-icon"></i>
                                </div>
                                @error('cancellation_deadline_hours')
                                <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                                <div class="hint-text">
                                    <i class="bi bi-info-circle"></i> Запрет отмены клиентом перед самым началом
                                </div>
                            </div>
                        </div>

                        <div class="neon-switch-wrapper mb-2 mt-4">
                            <label class="neon-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                                <span class="neon-slider"></span>
                            </label>
                            <div>
                                <label class="form-label mb-0" for="is_active" style="cursor: pointer; color: var(--text-main);">Услуга активна</label>
                                <div style="color: var(--text-description); font-size: 0.85rem; margin-top: 0.1rem;">
                                    Выключите тумблер, чтобы временно скрыть услугу из каталога.
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('organization.services.index') }}" class="btn-glass-back">
                                <i class="bi bi-arrow-left"></i> Отмена
                            </a>
                            <button type="submit" class="btn-glow-submit">
                                <i class="bi bi-save fs-5"></i> Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
