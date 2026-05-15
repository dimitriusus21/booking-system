@extends('layouts.app')

@section('title', 'Создание организации')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - CREATE ORGANIZATION PROFILE
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);

            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-muted: #94a3b8;

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

        /* Фоновое свечение */
        .ambient-glow {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 800px;
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
            color: var(--accent-primary);
            text-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
        }

        /* Стеклянная панель формы */
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
            background: linear-gradient(90deg, var(--accent-purple), var(--accent-primary));
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
        .section-title i { color: var(--accent-primary); }

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

        .glass-textarea { resize: vertical; min-height: 120px; }
        .glass-select option { background-color: #12121a; color: #fff; padding: 10px; }

        .glass-input:focus, .glass-select:focus, .glass-textarea:focus {
            outline: none; background: rgba(0, 0, 0, 0.6);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1), inset 0 0 10px rgba(0, 102, 255, 0.1);
        }

        .glass-input::placeholder, .glass-textarea::placeholder { color: #64748b; }

        /* Иконки внутри полей */
        .input-icon-wrapper { position: relative; }
        .input-icon-wrapper .input-icon {
            position: absolute; right: 1.25rem; top: 50%;
            transform: translateY(-50%); color: var(--text-muted); pointer-events: none;
        }
        .input-icon-wrapper .glass-input { padding-right: 3rem; }

        /* Валидация (Ошибки) */
        .glass-input.is-invalid, .glass-select.is-invalid, .glass-textarea.is-invalid {
            border-color: var(--neon-danger); box-shadow: 0 0 0 4px rgba(239, 71, 111, 0.1);
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
            padding: 0.875rem 2.5rem; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-purple) 100%);
            color: #fff; font-weight: 700; border: none; border-radius: 99px;
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3); transition: all 0.3s ease; cursor: pointer;
        }
        .btn-glow-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(123, 44, 191, 0.5); }

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
            <div class="col-lg-8 col-md-10">
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="bi bi-building-add"></i>
                        Создание профиля
                    </h1>
                    <p style="color: var(--text-description); margin-top: 0.5rem; font-size: 1.1rem;">
                        Заполните данные вашей организации, чтобы начать работу
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

                    <form action="{{ route('organization.profile.store') }}" method="POST">
                        @csrf

                        <div class="section-title">
                            <i class="bi bi-card-text"></i> Информация о бизнесе
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label">Название организации <span class="asterisk">*</span></label>
                            <div class="input-icon-wrapper">
                                <input type="text" class="glass-input @error('name') is-invalid @enderror"
                                       name="name" id="name" value="{{ old('name') }}" placeholder="Например: Салон красоты «Элегия»" required autofocus>
                                <i class="bi bi-shop input-icon"></i>
                            </div>
                            @error('name')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label">Категория деятельности <span class="asterisk">*</span></label>
                            <select class="glass-select @error('category_id') is-invalid @enderror"
                                    name="category_id" id="category_id" required>
                                <option value="" disabled selected>Выберите подходящую категорию</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="description" class="form-label">Описание организации</label>
                            <textarea class="glass-textarea @error('description') is-invalid @enderror"
                                      name="description" id="description" placeholder="Расскажите о ваших преимуществах, опыте и подходе к клиентам...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="section-title">
                            <i class="bi bi-geo-alt"></i> Контактные данные
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label">Физический адрес <span class="asterisk">*</span></label>
                            <div class="input-icon-wrapper">
                                <input type="text" class="glass-input @error('address') is-invalid @enderror"
                                       name="address" id="address" value="{{ old('address') }}" placeholder="г. Москва, ул. Пушкина, д. 1" required>
                                <i class="bi bi-map input-icon"></i>
                            </div>
                            @error('address')
                            <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-4 mb-2">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Телефон <span class="asterisk">*</span></label>
                                <div class="input-icon-wrapper">
                                    <input type="text" class="glass-input @error('phone') is-invalid @enderror"
                                           name="phone" id="phone" value="{{ old('phone') }}" placeholder="+7 (999) 000-00-00" required>
                                    <i class="bi bi-telephone input-icon"></i>
                                </div>
                                @error('phone')
                                <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email для связи</label>
                                <div class="input-icon-wrapper">
                                    <input type="email" class="glass-input @error('email') is-invalid @enderror"
                                           name="email" id="email" value="{{ old('email') }}" placeholder="hello@company.com">
                                    <i class="bi bi-envelope input-icon"></i>
                                </div>
                                @error('email')
                                <div class="invalid-feedback-neon"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('organization.dashboard') }}" class="btn-glass-back">
                                <i class="bi bi-arrow-left"></i> Заполнить позже
                            </a>
                            <button type="submit" class="btn-glow-submit">
                                <i class="bi bi-check2-circle fs-5"></i> Создать профиль
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
