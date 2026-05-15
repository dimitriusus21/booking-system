@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - AUTH PAGES
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-danger: #ef476f;
            --neon-info: #00d2ff;
        }

        .auth-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 160px);
            position: relative;
            padding: 2rem 0;
        }

        .ambient-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 900px;
            height: 600px;
            background: radial-gradient(circle at 50% 50%, rgba(123, 44, 191, 0.15) 0%, rgba(0, 102, 255, 0.05) 50%, transparent 70%);
            pointer-events: none;
            z-index: -1;
            filter: blur(40px);
            animation: pulseGlow 8s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.5; transform: translate(-50%, -50%) scale(0.9); }
            100% { opacity: 1; transform: translate(-50%, -50%) scale(1.1); }
        }

        .glass-auth-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            position: relative;
            overflow: hidden;
        }

        .glass-auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-purple), var(--accent-primary));
            box-shadow: 0 0 20px rgba(123, 44, 191, 0.5);
        }

        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-title {
            font-size: 1.75rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem;
            display: flex; align-items: center; justify-content: center; gap: 0.75rem;
        }
        .auth-title i { color: var(--accent-purple); text-shadow: 0 0 15px rgba(123, 44, 191, 0.4); }

        .form-label {
            color: var(--text-secondary); font-size: 0.85rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;
        }

        .glass-input, .glass-select {
            background: rgba(0, 0, 0, 0.3); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 0.75rem; padding: 0.875rem 1rem; width: 100%;
            transition: all 0.3s ease; font-size: 1rem;
        }

        /* Специальные стили для Select в тёмной теме */
        .glass-select option {
            background-color: #12121a;
            color: #fff;
        }

        .glass-input:focus, .glass-select:focus {
            outline: none; background: rgba(0, 0, 0, 0.5); border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1), inset 0 0 10px rgba(0, 102, 255, 0.1);
        }

        .glass-input.is-invalid { border-color: var(--neon-danger); box-shadow: 0 0 0 4px rgba(239, 71, 111, 0.1); }
        .invalid-feedback { color: var(--neon-danger); font-size: 0.8rem; margin-top: 0.5rem; }

        /* Блок с подсказкой */
        .hint-box {
            background: rgba(0, 210, 255, 0.05);
            border: 1px solid rgba(0, 210, 255, 0.2);
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.85rem;
            margin-top: 0.75rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .hint-box i { color: var(--neon-info); font-size: 1rem; margin-top: -2px; }

        .btn-auth-glow {
            width: 100%; padding: 0.875rem;
            background: linear-gradient(135deg, var(--accent-purple) 0%, var(--accent-primary) 100%);
            color: #fff; font-weight: 700; font-size: 1rem; border-radius: 99px;
            border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 8px 20px rgba(123, 44, 191, 0.3);
            transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            margin-top: 1.5rem; cursor: pointer;
        }

        .btn-auth-glow:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(123, 44, 191, 0.5); color: #fff; }

        .auth-footer { text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--glass-border); }
        .auth-link { color: var(--accent-primary); text-decoration: none; font-weight: 600; transition: all 0.2s ease; }
        .auth-link:hover { color: #fff; text-shadow: 0 0 10px rgba(0, 102, 255, 0.5); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* Разделение в ряд для мобилок */
        .row-inputs { display: flex; gap: 1rem; flex-wrap: wrap; }
        .row-inputs > div { flex: 1; min-width: 200px; }
    </style>

    <div class="auth-wrapper">
        <div class="ambient-glow"></div>

        <div class="glass-auth-card">
            <div class="auth-header">
                <h4 class="auth-title">
                    <i class="bi bi-person-plus"></i>
                    Создать аккаунт
                </h4>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">
                    Присоединяйтесь к платформе будущего
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label">Как к вам обращаться?</label>
                    <input type="text" class="glass-input @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" placeholder="Иван Иванов" required autofocus>
                    @error('name')
                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email адрес</label>
                    <input type="email" class="glass-input @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                    @error('email')
                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label">Выберите тип аккаунта</label>
                    <select class="glass-select" name="role" id="roleSelect">
                        <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Я клиент (ищу услуги)</option>
                        <option value="organization" {{ old('role') === 'organization' ? 'selected' : '' }}>Я организация (предоставляю услуги)</option>
                    </select>

                    <div class="hint-box" id="roleHint">
                        <i class="bi bi-info-circle"></i>
                        <span id="hintText">
                            @if(old('role') === 'organization')
                                После регистрации вам нужно будет заполнить данные вашей компании или ИП.
                            @else
                                Вы получите доступ к каталогу и сможете записываться к любым специалистам.
                            @endif
                        </span>
                    </div>
                </div>

                <div class="row-inputs mb-4">
                    <div>
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="glass-input @error('password') is-invalid @enderror"
                               name="password" placeholder="••••••••" required>
                        @error('password')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Подтверждение</label>
                        <input type="password" class="glass-input" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-auth-glow">
                    <i class="bi bi-stars"></i> Зарегистрироваться
                </button>
            </form>

            <div class="auth-footer">
                <span style="color: var(--text-secondary);">Уже есть аккаунт?</span>
                <a href="{{ route('login') }}" class="auth-link ms-1">Войти</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleSelect = document.getElementById('roleSelect');
                const hintText = document.getElementById('hintText');

                roleSelect.addEventListener('change', function() {
                    if (this.value === 'organization') {
                        hintText.style.opacity = 0;
                        setTimeout(() => {
                            hintText.innerHTML = 'После регистрации вам нужно будет заполнить профиль вашей компании или ИП для появления в каталоге.';
                            hintText.style.opacity = 1;
                        }, 150);
                    } else {
                        hintText.style.opacity = 0;
                        setTimeout(() => {
                            hintText.innerHTML = 'Вы получите полный доступ к каталогу и сможете записываться к любым специалистам в два клика.';
                            hintText.style.opacity = 1;
                        }, 150);
                    }
                });

                // Плавная анимация смены текста
                hintText.style.transition = 'opacity 0.15s ease';
            });
        </script>
    @endpush
@endsection
