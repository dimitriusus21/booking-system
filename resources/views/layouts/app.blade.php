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
           ТОТАЛЬНАЯ АДАПТАЦИЯ СВЕТЛОЙ ТЕМЫ
           ============================================ */

        /* 1. Жестко убиваем белый текст во всех возможных классах */
        html[data-theme="light"] .text-white,
        html[data-theme="light"] .text-white-50,
        html[data-theme="light"] .text-light,
        html[data-theme="light"] .link-light,
        html[data-theme="light"] a.text-white,
        html[data-theme="light"] a.text-white-50,
        html[data-theme="light"] [style*="color: white"],
        html[data-theme="light"] [style*="color: #fff"],
        html[data-theme="light"] [style*="color: #ffffff"] {
            color: #0f172a !important;
        }

        /* 2. АДМИН-ПАНЕЛЬ: БОКОВОЕ МЕНЮ И НАВИГАЦИЯ */
        html[data-theme="light"] .nav-link:not(.active),
        html[data-theme="light"] .list-group-item:not(.active) {
            color: #475569 !important;
        }
        html[data-theme="light"] .nav-link:not(.active):hover,
        html[data-theme="light"] .list-group-item:not(.active):hover {
            color: #0066ff !important;
            background-color: rgba(0, 102, 255, 0.05) !important;
        }
        html[data-theme="light"] .nav-pills .nav-link.active,
        html[data-theme="light"] .list-group-item.active {
            background-color: #0066ff !important;
            color: #ffffff !important;
        }

        /* 3. АДМИН-ПАНЕЛЬ: ТАБЛИЦЫ */
        html[data-theme="light"] table,
        html[data-theme="light"] .table {
            --bs-table-color: #0f172a;
            --bs-table-bg: transparent;
            --bs-table-border-color: #cbd5e1;
            color: #0f172a !important;
        }
        html[data-theme="light"] th,
        html[data-theme="light"] td {
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
        html[data-theme="light"] .table-dark,
        html[data-theme="light"] .text-bg-dark {
            --bs-table-bg: #f1f5f9;
            --bs-table-color: #0f172a;
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        /* 4. КНОПКА "НАЗАД" И ДРУГИЕ БЕЛЫЕ КНОПКИ */
        html[data-theme="light"] .btn-outline-light,
        html[data-theme="light"] .btn-light,
        html[data-theme="light"] .btn-back-glass {
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
            background-color: #ffffff !important;
        }
        html[data-theme="light"] .btn-outline-light:hover,
        html[data-theme="light"] .btn-back-glass:hover {
            background-color: #e2e8f0 !important;
            color: #0066ff !important;
            border-color: #0066ff !important;
        }

        /* 5. Мелкий текст, лейблы и подписи */
        html[data-theme="light"] .text-muted,
        html[data-theme="light"] .small,
        html[data-theme="light"] small,
        html[data-theme="light"] .opacity-50,
        html[data-theme="light"] .opacity-75 {
            color: #475569 !important;
            opacity: 1 !important;
        }

        /* 6. Заголовки */
        html[data-theme="light"] h1, html[data-theme="light"] h2, html[data-theme="light"] h3,
        html[data-theme="light"] h4, html[data-theme="light"] h5, html[data-theme="light"] h6,
        html[data-theme="light"] .page-title, html[data-theme="light"] .service-title {
            color: #0f172a !important;
            text-shadow: none !important;
        }

        /* 7. Фоны обычных карточек, сайдбаров и модалок */
        html[data-theme="light"] .glass-panel,
        html[data-theme="light"] .accordion-item,
        html[data-theme="light"] .sticky-booking-card,
        html[data-theme="light"] .modal-content,
        html[data-theme="light"] .card:not(a),
        html[data-theme="light"] .org-box,
        html[data-theme="light"] .review-card,
        html[data-theme="light"] .bg-dark,
        html[data-theme="light"] .bg-black,
        html[data-theme="light"] .bg-secondary,
        html[data-theme="light"] [style*="background: rgba(0, 0, 0"] {
            background-color: #ffffff !important;
            background: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
        }

        /* 8. ФИКС КАРТОЧЕК-ССЫЛОК (ДАШБОРДЫ) */
        html[data-theme="light"] a.card,
        html[data-theme="light"] a.glass-panel,
        html[data-theme="light"] a.bg-dark,
        html[data-theme="light"] a.text-decoration-none.text-white {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid #cbd5e1 !important;
            text-decoration: none !important;
        }

        html[data-theme="light"] a.card:hover,
        html[data-theme="light"] a.glass-panel:hover,
        html[data-theme="light"] a.bg-dark:hover {
            background-color: #f8fafc !important;
            color: #0066ff !important;
            border-color: #0066ff !important;
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.1) !important;
        }

        html[data-theme="light"] a.card *,
        html[data-theme="light"] a.glass-panel *,
        html[data-theme="light"] a.bg-dark * {
            color: inherit !important;
            text-shadow: none !important;
        }

        /* 9. Инпуты и формы */
        html[data-theme="light"] .glass-input,
        html[data-theme="light"] .glass-textarea,
        html[data-theme="light"] .form-control,
        html[data-theme="light"] .form-select {
            background-color: #ffffff !important;
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

        /* Плейсхолдеры */
        html[data-theme="light"] ::placeholder { color: #64748b !important; opacity: 1 !important; }
        html[data-theme="light"] select option { background-color: #ffffff !important; color: #0f172a !important; }
        html[data-theme="light"] input[type="file"]::file-selector-button { background-color: #f1f5f9 !important; color: #0f172a !important; border: 1px solid #cbd5e1 !important; }

        /* 10. Страница Уведомлений */
        html[data-theme="light"] .bg-light,
        html[data-theme="light"] .bg-opacity-10 {
            background-color: #f1f5f9 !important;
            background: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
        }

        /* 11. Генератор слотов */
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

        /* 12. ДАШБОРД АДМИНА И ОРГАНИЗАЦИИ (ПЛАШКИ И КНОПКИ ДЕЙСТВИЙ) */
        html[data-theme="light"] .stat-card,
        html[data-theme="light"] .action-card {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
        }
        html[data-theme="light"] .stat-value,
        html[data-theme="light"] .action-card-title {
            color: #0f172a !important;
            text-shadow: none !important;
        }
        html[data-theme="light"] .btn-action-glow {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
        html[data-theme="light"] .btn-action-glow:hover {
            background-color: #f8fafc !important;
            border-color: #0066ff !important;
            color: #0066ff !important;
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.1) !important;
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
