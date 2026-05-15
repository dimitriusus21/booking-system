<style>
    /* ============================================
       DARK NEON UI - АДАПТИВНЫЙ ХЕДЕР
       ============================================ */
    .glass-navbar {
        background: rgba(10, 10, 15, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    .brand-glow {
        display: flex; align-items: center; gap: 0.5rem;
        font-weight: 800; font-size: 1.5rem; letter-spacing: -0.02em;
        background: linear-gradient(135deg, #ffffff 0%, #a0a0b8 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        transition: all 0.3s ease;
    }
    .brand-glow i {
        color: #0066ff; -webkit-text-fill-color: #0066ff;
        text-shadow: 0 0 15px rgba(0, 102, 255, 0.5);
        font-size: 1.4rem; transition: transform 0.3s ease;
    }
    .navbar-brand:hover .brand-glow i { transform: scale(1.1) rotate(-5deg); }

    .glass-nav-link {
        color: #a0a0b8 !important; font-weight: 500; font-size: 0.95rem;
        padding: 0.5rem 1rem !important; border-radius: 0.75rem;
        transition: all 0.3s ease; display: flex; align-items: center; gap: 0.4rem; margin: 0 0.2rem;
    }
    .glass-nav-link i { font-size: 1.1rem; color: #6b6b80; transition: 0.3s; }
    .glass-nav-link:hover { color: #ffffff !important; background: rgba(255, 255, 255, 0.05); }
    .glass-nav-link:hover i { color: #0066ff; }

    .nav-admin-link {
        color: #ffd166 !important; background: rgba(255, 209, 102, 0.1);
        border: 1px solid rgba(255, 209, 102, 0.2);
    }
    .nav-admin-link i { color: #ffd166 !important; text-shadow: 0 0 10px rgba(255, 209, 102, 0.4); }
    .nav-admin-link:hover {
        background: rgba(255, 209, 102, 0.15); box-shadow: 0 0 15px rgba(255, 209, 102, 0.2); transform: translateY(-1px);
    }

    .neon-badge-pulse {
        background: #ef476f; box-shadow: 0 0 10px rgba(239, 71, 111, 0.6);
        border: 2px solid #0a0a0f; font-size: 0.65rem; padding: 0.25em 0.5em;
        animation: pulseRed 2s infinite;
    }
    @keyframes pulseRed {
        0% { box-shadow: 0 0 0 0 rgba(239, 71, 111, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(239, 71, 111, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 71, 111, 0); }
    }

    .glass-dropdown {
        background: rgba(20, 20, 30, 0.95) !important;
        backdrop-filter: blur(25px); border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 1rem !important; padding: 0.5rem !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
        margin-top: 0.5rem !important; min-width: 200px;
    }
    .glass-dropdown-item {
        color: #a0a0b8 !important; border-radius: 0.5rem; padding: 0.6rem 1rem !important;
        font-weight: 500; font-size: 0.9rem; transition: all 0.2s ease;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .glass-dropdown-item i { font-size: 1.1rem; color: #6b6b80; }
    .glass-dropdown-item:hover { background: rgba(255, 255, 255, 0.05) !important; color: #ffffff !important; padding-left: 1.2rem !important; }
    .glass-dropdown-item:hover i { color: #0066ff; }
    .dropdown-divider { border-top: 1px solid rgba(255, 255, 255, 0.05) !important; margin: 0.4rem 0 !important; }

    .logout-item:hover { background: rgba(239, 71, 111, 0.1) !important; color: #ef476f !important; }
    .logout-item:hover i { color: #ef476f !important; }

    .btn-nav-login { color: #fff !important; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); }
    .btn-nav-login:hover { background: rgba(255, 255, 255, 0.1); }
    .btn-nav-register { background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%); color: #fff !important; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); }
    .btn-nav-register:hover { box-shadow: 0 6px 20px rgba(0, 102, 255, 0.4); transform: translateY(-1px); }
    .btn-nav-register i { color: #fff !important; }

    /* Динамические элементы текста */
    .nav-username-text { color: #ffffff; font-weight: 500; }
    .custom-toggler-icon { color: #ffffff; font-size: 1.5rem; }
    .nav-separator { width: 1px; height: 24px; background: rgba(255,255,255,0.1); }

    .theme-toggle-btn {
        background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff; border-radius: 50%; width: 40px; height: 40px;
        display: inline-flex; align-items: center; justify-content: center; transition: 0.3s;
    }
    .theme-toggle-btn:hover { background: rgba(0, 102, 255, 0.15); border-color: #0066ff; color: #fff; }

    @media (max-width: 991px) {
        .navbar-toggler { border: none !important; padding: 0.5rem; }
        .navbar-toggler:focus { box-shadow: none !important; }
        .navbar-collapse {
            background: rgba(15, 15, 20, 0.95); backdrop-filter: blur(20px);
            margin-top: 1rem; padding: 1rem; border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
    }

    /* ============================================
       СВЕТЛАЯ ТЕМА ХЕДЕРА (ИНВЕРСИЯ ЦВЕТОВ)
       ============================================ */
    [data-theme="light"] .glass-navbar {
        background: rgba(255, 255, 255, 0.85); border-bottom: 1px solid rgba(0, 0, 0, 0.1); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    [data-theme="light"] .brand-glow { background: none; -webkit-text-fill-color: #0f172a; color: #0f172a; }
    [data-theme="light"] .brand-glow i { text-shadow: none; }
    [data-theme="light"] .glass-nav-link { color: #475569 !important; }
    [data-theme="light"] .glass-nav-link i { color: #64748b; }
    [data-theme="light"] .glass-nav-link:hover { background: rgba(0, 0, 0, 0.04); color: #0066ff !important; }

    [data-theme="light"] .nav-admin-link { color: #d97706 !important; background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2); }
    [data-theme="light"] .nav-admin-link i { color: #d97706 !important; text-shadow: none; }
    [data-theme="light"] .nav-admin-link:hover { background: rgba(245, 158, 11, 0.15); }

    [data-theme="light"] .glass-dropdown {
        background: rgba(255, 255, 255, 0.98) !important; border: 1px solid rgba(0, 0, 0, 0.1) !important; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
    }
    [data-theme="light"] .glass-dropdown-item { color: #475569 !important; }
    [data-theme="light"] .glass-dropdown-item:hover { background: rgba(0, 0, 0, 0.04) !important; color: #0066ff !important; }
    [data-theme="light"] .dropdown-divider { border-top: 1px solid rgba(0, 0, 0, 0.08) !important; }

    /* Исправлен белый цвет имени и иконок */
    [data-theme="light"] .nav-username-text { color: #0f172a !important; font-weight: 600; }
    [data-theme="light"] .custom-toggler-icon { color: #0f172a !important; }
    [data-theme="light"] .nav-separator { background: rgba(0,0,0,0.1); }

    [data-theme="light"] .btn-nav-login { color: #0f172a !important; background: rgba(0, 0, 0, 0.03); border-color: rgba(0, 0, 0, 0.1); }
    [data-theme="light"] .btn-nav-login:hover { background: rgba(0, 0, 0, 0.08); }
    [data-theme="light"] .btn-nav-register { box-shadow: 0 4px 15px rgba(0, 102, 255, 0.2); }

    [data-theme="light"] .theme-toggle-btn { background: rgba(0,0,0,0.05); border-color: rgba(0,0,0,0.1); color: #0f172a; }
    [data-theme="light"] .theme-toggle-btn:hover { background: rgba(0, 102, 255, 0.1); border-color: #0066ff; color: #0066ff; }

    @media (max-width: 991px) {
        [data-theme="light"] .navbar-collapse {
            background: rgba(255, 255, 255, 0.98); border-color: rgba(0, 0, 0, 0.1); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    }
</style>

<nav class="navbar navbar-expand-lg glass-navbar sticky-top py-2">
    <div class="container">
        <a class="navbar-brand text-decoration-none" href="<?php echo e(route('home')); ?>">
            <div class="brand-glow">
                <i class="bi bi-hexagon-half"></i> <span>BookingSys</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list custom-toggler-icon"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">

                <li class="nav-item">
                    <a class="nav-link glass-nav-link" href="<?php echo e(route('services.index')); ?>">
                        <i class="bi bi-grid"></i> Каталог услуг
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link glass-nav-link" href="<?php echo e(route('organizations.index')); ?>">
                        <i class="bi bi-buildings"></i> Организации
                    </a>
                </li>

                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item d-none d-lg-block mx-2">
                        <div class="nav-separator"></div>
                    </li>

                    <?php if(auth()->user()->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link glass-nav-link nav-admin-link" href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="bi bi-shield-lock-fill"></i> Админ-панель
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(auth()->user()->isOrganization()): ?>
                        <li class="nav-item">
                            <a class="nav-link glass-nav-link" href="<?php echo e(route('organization.dashboard')); ?>">
                                <i class="bi bi-speedometer2"></i> Рабочая панель
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link glass-nav-link" href="<?php echo e(route('my-bookings')); ?>">
                                <i class="bi bi-journal-bookmark"></i> Мои записи
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link glass-nav-link" href="<?php echo e(route('my-reviews')); ?>">
                                <i class="bi bi-chat-square-text"></i> Отзывы
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item me-lg-2">
                        <a class="nav-link glass-nav-link position-relative" href="<?php echo e(route('notifications.index')); ?>">
                            <i class="bi bi-bell"></i>
                            <span class="d-lg-none ms-2">Уведомления</span>
                            <?php if(auth()->user()->unreadNotificationsCount() > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill neon-badge-pulse" style="margin-left: -5px; margin-top: 8px;">
                                    <?php echo e(auth()->user()->unreadNotificationsCount()); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link glass-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle" style="color: #0066ff;"></i>
                            <span class="nav-username-text"><?php echo e(auth()->user()->name); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end glass-dropdown">
                            <li>
                                <a class="dropdown-item glass-dropdown-item" href="<?php echo e(route('client.dashboard')); ?>">
                                    <i class="bi bi-person-vcard"></i> Мой профиль
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item glass-dropdown-item logout-item border-0 bg-transparent w-100 text-start">
                                        <i class="bi bi-box-arrow-right"></i> Выйти из системы
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item d-none d-lg-block mx-2">
                        <div class="nav-separator"></div>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="nav-link glass-nav-link btn-nav-login text-center" href="<?php echo e(route('login')); ?>">
                            <i class="bi bi-box-arrow-in-right d-none d-lg-inline-block"></i> Вход
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                        <a class="nav-link glass-nav-link btn-nav-register text-center" href="<?php echo e(route('register')); ?>">
                            <i class="bi bi-stars"></i> Регистрация
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item d-flex align-items-center justify-content-center mt-3 mt-lg-0 ms-lg-3">
                    <button id="themeToggleBtn" class="theme-toggle-btn" title="Переключить тему">
                        <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                    </button>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/layouts/header.blade.php ENDPATH**/ ?>