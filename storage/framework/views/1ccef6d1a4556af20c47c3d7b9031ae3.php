<?php $__env->startSection('title', 'Мой дашборд'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - CLIENT DASHBOARD (HIGH CONTRAST)
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-hover: rgba(255, 255, 255, 0.15);

            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --neon-info: #00d2ff;
            --neon-warning: #ffd166;
            --neon-success: #06d6a0;
            --neon-secondary: #8d99ae;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 4rem; }

        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 80%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.12) 0%, transparent 60%);
            pointer-events: none; z-index: -1;
        }

        .page-header { margin-bottom: 2.5rem; animation: slideDown 0.5s ease-out; }
        .page-title {
            font-size: 2.2rem; font-weight: 800; color: var(--text-main); margin: 0;
            display: flex; align-items: center; gap: 1rem;
        }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        /* Карточки статистики */
        .stat-card {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 1.75rem; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative; overflow: hidden;
            animation: fadeUp 0.5s ease-out calc(var(--delay) * 0.1s) both;
            height: 100%;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--stat-color); opacity: 0.7; box-shadow: 0 0 15px var(--stat-color);
        }
        .stat-card:hover {
            transform: translateY(-6px); border-color: rgba(255,255,255,0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 30px rgba(var(--stat-rgb), 0.1);
        }

        .stat-label { font-size: 0.85rem; color: var(--text-description); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; margin-bottom: 0.5rem; }
        .stat-value { font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin: 0; text-shadow: 0 0 15px rgba(var(--stat-rgb), 0.2); line-height: 1; }
        .stat-icon { font-size: 2.5rem; opacity: 0.8; color: var(--stat-color); filter: drop-shadow(0 0 10px rgba(var(--stat-rgb), 0.3)); transition: 0.3s; }
        .stat-card:hover .stat-icon { transform: scale(1.1) rotate(5deg); opacity: 1; }

        /* Стеклянная панель со списком записей */
        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 2rem; animation: fadeUp 0.6s ease-out 0.4s both;
        }
        .panel-title { color: var(--text-main); font-weight: 800; font-size: 1.4rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .panel-title i { color: var(--accent-primary); }

        /* Элемент записи */
        .booking-item {
            padding: 1.5rem; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem; margin-bottom: 1rem; transition: all 0.3s ease;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
        }
        .booking-item:last-child { margin-bottom: 0; }
        .booking-item:hover { background: rgba(255, 255, 255, 0.04); border-color: rgba(255, 255, 255, 0.15); transform: translateX(5px); }

        .booking-title { font-weight: 800; font-size: 1.15rem; color: var(--text-main); margin-bottom: 0.4rem; }
        .booking-details { font-size: 0.9rem; color: var(--text-description); display: flex; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .booking-details i { color: var(--accent-primary); font-size: 1rem; }

        /* Статусы */
        .status-badge { padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid transparent; }
        .status-confirmed { background: rgba(6, 214, 160, 0.1); color: var(--neon-success); border-color: rgba(6, 214, 160, 0.3); box-shadow: inset 0 0 10px rgba(6, 214, 160, 0.1); }
        .status-pending { background: rgba(255, 209, 102, 0.1); color: var(--neon-warning); border-color: rgba(255, 209, 102, 0.3); box-shadow: inset 0 0 10px rgba(255, 209, 102, 0.1); }
        .status-completed { background: rgba(0, 210, 255, 0.1); color: var(--neon-info); border-color: rgba(0, 210, 255, 0.3); box-shadow: inset 0 0 10px rgba(0, 210, 255, 0.1); }
        .status-cancelled { background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border-color: var(--glass-border); }

        /* Кнопки */
        .btn-link-glow {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.8rem 2rem; background: transparent; border: 1px solid var(--glass-border);
            color: var(--text-main); font-weight: 700; border-radius: 99px;
            text-decoration: none; transition: all 0.3s ease;
        }
        .btn-link-glow:hover { background: rgba(0, 102, 255, 0.1); border-color: var(--accent-primary); color: #fff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.2); }

        .btn-primary-glow {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.8rem 2.5rem; background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff; font-weight: 700; border-radius: 99px; text-decoration: none; border: none;
            box-shadow: 0 5px 15px rgba(0, 102, 255, 0.3); transition: all 0.3s ease;
        }
        .btn-primary-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 102, 255, 0.5); color: #fff; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper container py-4">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-person-circle"></i> Привет, <?php echo e(auth()->user()->name); ?>!</h1>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card" style="--stat-color: var(--accent-primary); --stat-rgb: 0, 102, 255; --delay: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Всего записей</div>
                            <h3 class="stat-value"><?php echo e(isset($bookings) ? $bookings->count() : 0); ?></h3>
                        </div>
                        <i class="bi bi-journal-bookmark-fill stat-icon"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card" style="--stat-color: var(--neon-info); --stat-rgb: 0, 210, 255; --delay: 2;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Активные услуги</div>
                            <h3 class="stat-value">
                                <?php echo e(isset($bookings) ? $bookings->whereIn('status', ['pending', 'confirmed'])->count() : 0); ?>

                            </h3>
                        </div>
                        <i class="bi bi-calendar-check stat-icon"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card" style="--stat-color: var(--neon-warning); --stat-rgb: 255, 209, 102; --delay: 3;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Лист ожидания</div>
                            <h3 class="stat-value"><?php echo e($waitingListCount ?? 0); ?></h3>
                        </div>
                        <i class="bi bi-clock-history stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel">
            <h5 class="panel-title"><i class="bi bi-calendar-week"></i> Последние записи</h5>

            <div class="mt-4">
                <?php if(isset($bookings) && $bookings->count() > 0): ?>
                    <?php $__currentLoopData = $bookings->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="booking-item">
                            <div>
                                <h6 class="booking-title"><?php echo e($booking->service->title); ?></h6>
                                <div class="booking-details">
                                    <span><i class="bi bi-building"></i> <span style="color: var(--text-description);"><?php echo e($booking->service->organization->name); ?></span></span>
                                    <span><i class="bi bi-calendar3"></i> <span style="color: var(--text-description);"><?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y')); ?></span></span>
                                    <span><i class="bi bi-clock"></i> <span style="color: var(--text-description);"><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?></span></span>
                                </div>
                            </div>
                            <div>
                                <?php if($booking->status === 'confirmed'): ?>
                                    <span class="status-badge status-confirmed">Подтверждена</span>
                                <?php elseif($booking->status === 'pending'): ?>
                                    <span class="status-badge status-pending">Ожидает</span>
                                <?php elseif($booking->status === 'completed'): ?>
                                    <span class="status-badge status-completed">Выполнена</span>
                                <?php elseif($booking->status === 'cancelled'): ?>
                                    <span class="status-badge status-cancelled">Отменена</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="mt-4 text-center border-top border-secondary border-opacity-10 pt-4">
                        <a href="<?php echo e(route('my-bookings')); ?>" class="btn-link-glow">
                            Посмотреть все записи <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x fs-1 opacity-25" style="color: var(--text-muted);"></i>
                        <p class="mt-3 mb-4" style="color: var(--text-description); font-size: 1.1rem;">У вас пока нет активных записей</p>
                        <a href="<?php echo e(route('services.index')); ?>" class="btn-primary-glow">
                            Найти услугу
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/dashboard.blade.php ENDPATH**/ ?>