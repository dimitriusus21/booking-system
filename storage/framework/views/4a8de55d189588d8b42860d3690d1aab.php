<?php $__env->startSection('title', 'Уведомления'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - NOTIFICATIONS
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-secondary: #a0a0b8;
            --text-tertiary: #6b6b80;
            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-danger: #ef476f;
            --neon-success: #06d6a0;
        }

        .dark-page-wrapper {
            position: relative;
            padding-bottom: 3rem;
        }

        /* Фоновое свечение */
        .ambient-glow {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 800px;
            height: 400px;
            background: radial-gradient(circle at 50% 0%, rgba(123, 44, 191, 0.15) 0%, rgba(0, 102, 255, 0.05) 50%, transparent 70%);
            pointer-events: none;
            z-index: -1;
            filter: blur(40px);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            animation: slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            color: var(--accent-purple);
            text-shadow: 0 0 15px rgba(123, 44, 191, 0.4);
        }

        /* Кнопка "Прочитать всё" */
        .btn-read-all {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            font-weight: 600;
            border-radius: 99px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .btn-read-all:hover {
            background: rgba(6, 214, 160, 0.1);
            color: var(--neon-success);
            border-color: rgba(6, 214, 160, 0.3);
            box-shadow: 0 0 15px rgba(6, 214, 160, 0.2);
            transform: translateY(-2px);
        }

        /* Список уведомлений */
        .notifications-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Карточка уведомления */
        .notification-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.3s ease;
            animation: fadeUp 0.5s ease-out calc(var(--delay) * 0.05s) both;
            position: relative;
            overflow: hidden;
        }

        .notification-card:hover {
            border-color: var(--glass-hover);
            transform: translateX(5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* Стиль для непрочитанных */
        .notification-card.unread {
            background: rgba(0, 102, 255, 0.05);
            border-left: 4px solid var(--accent-primary);
            box-shadow: inset 20px 0 30px -20px rgba(0, 102, 255, 0.2);
        }

        /* Мигающая точка для непрочитанных */
        .unread-dot {
            width: 10px;
            height: 10px;
            background: var(--accent-primary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px var(--accent-primary);
            margin-right: 0.5rem;
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(0, 102, 255, 0.7); }
            70% { box-shadow: 0 0 0 5px rgba(0, 102, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 102, 255, 0); }
        }

        /* Контент уведомления */
        .notif-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
        }

        .notif-message {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            line-height: 1.5;
        }

        .notif-time {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            color: var(--text-tertiary);
            font-weight: 500;
        }

        /* Кнопка "Прочитать" для одиночного уведомления */
        .btn-check-read {
            background: transparent;
            border: none;
            color: var(--text-tertiary);
            font-size: 1.5rem;
            transition: all 0.3s ease;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-check-read:hover {
            color: var(--accent-primary);
            filter: drop-shadow(0 0 8px rgba(0, 102, 255, 0.5));
            transform: scale(1.1);
        }

        /* Пустое состояние */
        .glass-empty {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px dashed var(--glass-border);
            border-radius: 1.5rem;
            padding: 5rem 2rem;
            text-align: center;
            max-width: 600px;
            margin: 2rem auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .empty-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.05);
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.02));
        }

        /* ИДЕАЛЬНАЯ РУССКАЯ ПАГИНАЦИЯ */
        .custom-pagination-container {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .pagination-info b {
            color: #fff;
        }

        .custom-pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .custom-pagination .page-item .page-link {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
        }

        .custom-pagination .page-item:not(.disabled):not(.active) .page-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .custom-pagination .page-item.active .page-link {
            background: var(--accent-primary);
            border-color: var(--accent-primary);
            color: #fff;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
            pointer-events: none;
        }

        .custom-pagination .page-item.disabled .page-link {
            background: rgba(0, 0, 0, 0.2);
            color: var(--text-tertiary);
            border-color: rgba(255, 255, 255, 0.05);
            pointer-events: none;
        }

        /* Анимации */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            .notification-card {
                flex-direction: column;
                gap: 1rem;
                padding: 1.25rem;
            }
            .btn-check-read {
                align-self: flex-end;
            }
        }
    </style>

    <div class="dark-page-wrapper container py-4">
        <div class="ambient-glow"></div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="bi bi-bell"></i>
                        Уведомления
                    </h1>
                    <?php if($notifications->where('is_read', false)->count() > 0): ?>
                        <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <button type="submit" class="btn-read-all">
                                <i class="bi bi-check2-all"></i> Прочитать всё
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <?php if($notifications->count() > 0): ?>
                    <div class="notifications-list">
                        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="notification-card <?php echo e(!$notification->is_read ? 'unread' : ''); ?>" style="--delay: <?php echo e($index); ?>;">
                                <div>
                                    <h6 class="notif-title">
                                        <?php if(!$notification->is_read): ?>
                                            <span class="unread-dot"></span>
                                        <?php endif; ?>
                                        <?php echo e($notification->title); ?>

                                    </h6>
                                    <p class="notif-message"><?php echo e($notification->message); ?></p>
                                    <div class="notif-time">
                                        <i class="bi bi-clock"></i>
                                        <span><?php echo e($notification->created_at->diffForHumans()); ?></span>
                                    </div>
                                </div>

                                <?php if(!$notification->is_read): ?>
                                    <form action="<?php echo e(route('notifications.read', $notification)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn-check-read" title="Отметить как прочитанное">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php if($notifications->hasPages()): ?>
                        <div class="custom-pagination-container">
                            <div class="pagination-info">
                                Показаны уведомления с <b><?php echo e($notifications->firstItem()); ?></b> по <b><?php echo e($notifications->lastItem()); ?></b> из <b><?php echo e($notifications->total()); ?></b>
                            </div>

                            <ul class="custom-pagination">
                                <?php if($notifications->onFirstPage()): ?>
                                    <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left me-1"></i> Назад</span></li>
                                <?php else: ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo e($notifications->previousPageUrl()); ?>"><i class="bi bi-chevron-left me-1"></i> Назад</a></li>
                                <?php endif; ?>

                                <?php
                                    $start = max($notifications->currentPage() - 2, 1);
                                    $end = min($notifications->currentPage() + 2, $notifications->lastPage());
                                ?>

                                <?php if($start > 1): ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo e($notifications->url(1)); ?>">1</a></li>
                                    <?php if($start > 2): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php for($i = $start; $i <= $end; $i++): ?>
                                    <?php if($i == $notifications->currentPage()): ?>
                                        <li class="page-item active"><span class="page-link"><?php echo e($i); ?></span></li>
                                    <?php else: ?>
                                        <li class="page-item"><a class="page-link" href="<?php echo e($notifications->url($i)); ?>"><?php echo e($i); ?></a></li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if($end < $notifications->lastPage()): ?>
                                    <?php if($end < $notifications->lastPage() - 1): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo e($notifications->url($notifications->lastPage())); ?>"><?php echo e($notifications->lastPage()); ?></a></li>
                                <?php endif; ?>

                                <?php if($notifications->hasMorePages()): ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo e($notifications->nextPageUrl()); ?>">Дальше <i class="bi bi-chevron-right ms-1"></i></a></li>
                                <?php else: ?>
                                    <li class="page-item disabled"><span class="page-link">Дальше <i class="bi bi-chevron-right ms-1"></i></span></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="glass-empty">
                        <i class="bi bi-bell-slash empty-icon"></i>
                        <h3 style="color: #fff; font-weight: 700; margin-bottom: 1rem;">Уведомлений нет</h3>
                        <p style="color: var(--text-secondary); margin-bottom: 0;">Ваш центр уведомлений пуст. Мы сообщим вам, когда появится что-то важное.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/notifications/index.blade.php ENDPATH**/ ?>