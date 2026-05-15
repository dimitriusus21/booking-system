<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        const storedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', storedTheme);
        document.documentElement.setAttribute('data-bs-theme', storedTheme);
    </script>

    <title>@yield('title', 'Booking System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ============================================
           БАЗОВЫЕ ПЕРЕМЕННЫЕ (ТЕМНАЯ ТЕМА)
           ============================================ */
        :root, html[data-theme="dark"] {
            --bg-primary: #0a0a0f;
            --text-main: #f0f0f8;
            --text-muted: #94a3b8;
            --text-description: #cbd5e1;
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        /* ПРИНУДИТЕЛЬНАЯ ПЕРЕЗАПИСЬ ПЕРЕМЕННЫХ НА ВСЕХ ЭЛЕМЕНТАХ */
        html[data-theme="light"],
        html[data-theme="light"] * {
            --bg-primary: #f8fafc !important;
            --text-main: #0f172a !important;
            --text-muted: #475569 !important;
            --text-description: #334155 !important;
            --glass-bg: #ffffff !important;
            --glass-border: rgba(0, 0, 0, 0.15) !important;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        main { flex-grow: 1; }
        .cursor-pointer { cursor: pointer; }

        /* Плавные переходы */
        .glass-panel, .sticky-booking-card, .glass-input, .accordion-item, .slot-chip, .modal-content, .alert, .card {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ============================================
           ВСПЛЫВАЮЩИЕ УВЕДОМЛЕНИЯ (АЛЕРТЫ)
           ============================================ */
        .alert {
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            color: var(--text-main) !important;
            border: 1px solid var(--glass-border);
            background: var(--glass-bg);
        }
        html[data-theme="dark"] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        html[data-theme="light"] .btn-close { filter: none; }

        /* ============================================
           ЯДЕРНАЯ ЗАЩИТА СВЕТЛОЙ ТЕМЫ
           Убивает любой белый текст в основном контенте
           ============================================ */

        /* 1. Находим вообще ВСЕ текстовые элементы и красим в темный (кроме кнопок, бейджей и алертов) */
        html[data-theme="light"] main *:not([class*="btn"]):not([class*="btn"] *):not(.badge):not(.badge *):not(.alert):not(.alert *):not(i) {
            color: #0f172a !important;
            text-shadow: none !important;
        }

        /* 2. Для мелкого текста, лейблов форм и подписей делаем цвет чуть светлее (тёмно-серый) */
        html[data-theme="light"] main .text-muted,
        html[data-theme="light"] main .text-muted *,
        html[data-theme="light"] main .small,
        html[data-theme="light"] main small,
        html[data-theme="light"] main .text-white-50,
        html[data-theme="light"] main .text-white-50 *,
        html[data-theme="light"] main .opacity-50,
        html[data-theme="light"] main .opacity-75 {
            color: #475569 !important;
            opacity: 1 !important;
        }

        /* 3. Возвращаем цветные акценты (иконки, успехи, ошибки) */
        html[data-theme="light"] main .text-primary { color: #0066ff !important; }
        html[data-theme="light"] main .text-success { color: #059669 !important; }
        html[data-theme="light"] main .text-warning { color: #d97706 !important; }
        html[data-theme="light"] main .text-danger { color: #e11d48 !important; }
        html[data-theme="light"] main .text-info { color: #0284c7 !important; }

        /* Ссылки (которые не кнопки) */
        html[data-theme="light"] main a:not([class*="btn"]) {
            color: #0066ff !important;
        }

        /* 4. Принудительно отбеливаем все карточки, фоны, формы и модальные окна */
        html[data-theme="light"] .glass-panel,
        html[data-theme="light"] .accordion-item,
        html[data-theme="light"] .sticky-booking-card,
        html[data-theme="light"] .modal-content,
        html[data-theme="light"] .card,
        html[data-theme="light"] .org-box,
        html[data-theme="light"] .review-card,
        html[data-theme="light"] .bg-dark,
        html[data-theme="light"] .bg-black,
        html[data-theme="light"] .bg-secondary,
        html[data-theme="light"] [style*="background: rgba(0, 0, 0"],
        html[data-theme="light"] [style*="background: rgba(0,0,0"] {
            background-color: #ffffff !important;
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
        }

        /* 5. Инпуты, формы, селекты, плейсхолдеры */
        html[data-theme="light"] .glass-input,
        html[data-theme="light"] .glass-textarea,
        html[data-theme="light"] .form-control,
        html[data-theme="light"] .form-select {
            background-color: #ffffff !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            color-scheme: light !important;
        }
        html[data-theme="light"] .glass-input:focus,
        html[data-theme="light"] .form-control:focus,
        html[data-theme="light"] .form-select:focus {
            border-color: #0066ff !important;
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1) !important;
        }

        /* Плейсхолдеры внутри форм */
        html[data-theme="light"] ::placeholder {
            color: #64748b !important;
            opacity: 1 !important;
        }
        html[data-theme="light"] select option {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
        html[data-theme="light"] input[type="file"]::file-selector-button {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border: 1px solid #cbd5e1 !important;
        }

        /* 6. Страница Уведомлений (отделяем прочитанные от непрочитанных) */
        html[data-theme="light"] .bg-light,
        html[data-theme="light"] .bg-opacity-10 {
            background-color: #f1f5f9 !important;
            background: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
        }

        /* 7. Генератор слотов */
        html[data-theme="light"] .slot-chip,
        html[data-theme="light"] .slot-btn {
            background-color: #f8fafc !important;
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
        }
        html[data-theme="light"] .slot-chip:hover,
        html[data-theme="light"] .slot-btn:hover,
        html[data-theme="light"] .slot-btn.active {
            background-color: #e0e7ff !important;
            background: #e0e7ff !important;
            border-color: #0066ff !important;
            color: #0066ff !important;
        }

        /* Свечение на фоне */
        .ambient-glow { background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.15) 0%, transparent 70%); }
        html[data-theme="light"] .ambient-glow { background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.03) 0%, transparent 70%); }
    </style>
    @stack('styles')
</head>
<body>

@include('layouts.header')

<main class="py-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2 text-warning"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        function updateIcon() {
            if (!themeIcon) return;
            if (html.getAttribute('data-theme') === 'light') {
                themeIcon.className = 'bi bi-sun-fill text-warning';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill';
            }
        }

        updateIcon();

        if (themeBtn) {
            themeBtn.addEventListener('click', function () {
                let currentTheme = html.getAttribute('data-theme');
                let newTheme = currentTheme === 'light' ? 'dark' : 'light';

                html.setAttribute('data-theme', newTheme);
                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);

                updateIcon();
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>
