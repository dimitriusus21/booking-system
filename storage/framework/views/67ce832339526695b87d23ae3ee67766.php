<?php $__env->startSection('title', 'Мои записи'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - BOOKINGS PAGE
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.15);

            --text-secondary: #a0a0b8;
            --text-tertiary: #6b6b80;

            --accent-primary: #0066ff;

            /* Status Colors (Neon) */
            --neon-warning: #ffd166;
            --neon-success: #06d6a0;
            --neon-info: #00d2ff;
            --neon-danger: #ef476f;
            --neon-secondary: #8d99ae;
        }

        .dark-page-wrapper {
            position: relative;
            padding-bottom: 2rem;
        }

        /* Заголовок страницы */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            animation: slideDown 0.5s ease-out;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            color: var(--accent-primary);
            text-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
        }

        /* Кнопка создания */
        .btn-glow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 99px;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0, 102, 255, 0.5);
            color: #fff;
        }

        /* Стеклянные карточки */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: fadeUp 0.5s ease-out calc(var(--delay) * 0.05s) both;
        }

        /* Светящаяся полоса статуса сверху */
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--status-color, var(--accent-primary));
            opacity: 0.7;
            box-shadow: 0 0 15px var(--status-color, var(--accent-primary));
        }

        .glass-card:hover {
            transform: translateY(-4px);
            border-color: var(--glass-hover);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        /* Название услуги */
        .service-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 1rem 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Неоновые бейджи статусов */
        .neon-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: 1px solid var(--status-color);
            background: rgba(var(--status-rgb), 0.1);
            color: var(--status-color);
            box-shadow: inset 0 0 8px rgba(var(--status-rgb), 0.1);
        }

        /* Статусы */
        .status-pending { --status-color: var(--neon-warning); --status-rgb: 255, 209, 102; }
        .status-confirmed { --status-color: var(--neon-success); --status-rgb: 6, 214, 160; }
        .status-completed { --status-color: var(--neon-info); --status-rgb: 0, 210, 255; }
        .status-cancelled { --status-color: var(--neon-secondary); --status-rgb: 141, 153, 174; }
        .status-rejected { --status-color: var(--neon-danger); --status-rgb: 239, 71, 111; }

        /* Информация об организации */
        .org-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .org-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .org-row i {
            color: var(--text-tertiary);
        }

        .org-name {
            font-weight: 600;
            color: #e2e8f0;
        }

        /* Блок с датой и ценой */
        .glass-meta {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .meta-col {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .meta-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            font-weight: 600;
        }

        .meta-value {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
        }

        .meta-price {
            color: var(--neon-success);
            font-size: 1.15rem;
        }

        /* Кнопки действий */
        .card-actions {
            margin-top: auto;
        }

        .action-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-cancel-glass {
            color: var(--neon-danger);
            border-color: rgba(239, 71, 111, 0.3);
        }

        .btn-cancel-glass:hover {
            background: rgba(239, 71, 111, 0.1);
            border-color: var(--neon-danger);
            box-shadow: 0 0 15px rgba(239, 71, 111, 0.15);
        }

        .btn-review-glass {
            background: linear-gradient(135deg, #7b2cbf 0%, #9d4edd 100%);
            color: #fff;
            border: none;
        }

        .btn-review-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(123, 44, 191, 0.4);
            color: #fff;
        }

        .status-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            color: var(--text-tertiary);
            padding: 0.75rem;
            border-radius: 99px;
            font-size: 0.8rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .status-box.success {
            background: rgba(6, 214, 160, 0.05);
            border-color: rgba(6, 214, 160, 0.2);
            color: var(--neon-success);
        }

        /* ============================================
           КАСТОМНАЯ ПАГИНАЦИЯ
           ============================================ */
        .custom-pagination-container {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .pagination-info {
            color: var(--text-tertiary);
            font-size: 0.875rem;
            text-align: center;
        }

        .pagination-info b {
            color: #fff;
            font-weight: 600;
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

        /* Пустое состояние */
        .glass-empty {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px dashed var(--glass-border);
            border-radius: 2rem;
            padding: 4rem 2rem;
            text-align: center;
            max-width: 600px;
            margin: 2rem auto;
        }

        .empty-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.05));
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
            .btn-glow {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="dark-page-wrapper">
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-journal-bookmark"></i>
                Мои записи
            </h1>
            <a href="<?php echo e(route('services.index')); ?>" class="btn-glow">
                <i class="bi bi-plus-lg"></i>
                Новая запись
            </a>
        </div>

        <?php if($bookings->count() > 0): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // Назначаем класс статуса для управления цветами
                        $statusClass = 'status-pending';
                        if ($booking->status === 'confirmed') $statusClass = 'status-confirmed';
                        if ($booking->status === 'completed') $statusClass = 'status-completed';
                        if ($booking->status === 'cancelled') $statusClass = 'status-cancelled';
                        if ($booking->status === 'rejected') $statusClass = 'status-rejected';
                    ?>

                    <div class="col-md-6 col-xl-4">
                        <div class="glass-card <?php echo e($statusClass); ?>" style="--delay: <?php echo e($index); ?>;">

                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <h3 class="service-title" title="<?php echo e($booking->service?->title); ?>">
                                    <?php echo e($booking->service?->title ?? 'Услуга удалена'); ?>

                                </h3>

                                <?php if($booking->status === 'pending'): ?>
                                    <span class="neon-badge">Ожидает</span>
                                <?php elseif($booking->status === 'confirmed'): ?>
                                    <span class="neon-badge">Подтверждена</span>
                                <?php elseif($booking->status === 'completed'): ?>
                                    <span class="neon-badge">Выполнена</span>
                                <?php elseif($booking->status === 'cancelled'): ?>
                                    <span class="neon-badge">Отменена</span>
                                <?php elseif($booking->status === 'rejected'): ?>
                                    <span class="neon-badge">Отклонена</span>
                                <?php endif; ?>
                            </div>

                            <div class="org-details">
                                <div class="org-row">
                                    <i class="bi bi-buildings"></i>
                                    <span class="org-name"><?php echo e($booking->service?->organization?->name ?? 'Неизвестная организация'); ?></span>
                                </div>
                                <div class="org-row">
                                    <i class="bi bi-geo-alt"></i>
                                    <span><?php echo e($booking->service?->organization?->address ?? 'Адрес недоступен'); ?></span>
                                </div>
                            </div>

                            <div class="glass-meta">
                                <div class="meta-col">
                                    <span class="meta-label">Дата и время</span>
                                    <span class="meta-value">
                                        <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y')); ?>

                                        <span style="color: var(--text-secondary); font-weight: 500; margin-left: 4px;">
                                            <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?>

                                        </span>
                                    </span>
                                </div>
                                <div class="meta-col text-end">
                                    <span class="meta-label">Стоимость</span>
                                    <span class="meta-value meta-price"><?php echo e(number_format($booking->price, 0, '', ' ')); ?> ₽</span>
                                </div>
                            </div>

                            <div class="card-actions">
                                <?php
                                    $bookingDateTime = \Carbon\Carbon::parse($booking->booking_date->format('Y-m-d') . ' ' . $booking->start_time);
                                    $canCancel = in_array($booking->status, ['pending', 'confirmed']) && \Carbon\Carbon::now()->diffInMinutes($bookingDateTime, false) >= 120;
                                ?>

                                <?php if($canCancel): ?>
                                    <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" onsubmit="return confirm('Вы уверены, что хотите отменить эту запись? Слот освободится для других.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="action-btn btn-cancel-glass">
                                            <i class="bi bi-x-lg"></i> Отменить запись
                                        </button>
                                    </form>
                                <?php elseif(in_array($booking->status, ['pending', 'confirmed'])): ?>
                                    <div class="status-box">
                                        <i class="bi bi-lock"></i> Отмена недоступна (менее 2ч)
                                    </div>
                                <?php endif; ?>

                                <?php if($booking->status === 'completed'): ?>
                                    <?php if(!$booking->review): ?>
                                        <a href="<?php echo e(route('reviews.create', $booking->id)); ?>" class="action-btn btn-review-glass">
                                            <i class="bi bi-star-fill"></i> Оставить отзыв
                                        </a>
                                    <?php else: ?>
                                        <div class="status-box success">
                                            <i class="bi bi-check2-all"></i> Отзыв опубликован
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($bookings->hasPages()): ?>
                <div class="custom-pagination-container">
                    <div class="pagination-info">
                        Показаны записи с <b><?php echo e($bookings->firstItem()); ?></b> по <b><?php echo e($bookings->lastItem()); ?></b> из <b><?php echo e($bookings->total()); ?></b>
                    </div>

                    <ul class="custom-pagination">
                        
                        <?php if($bookings->onFirstPage()): ?>
                            <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left me-1"></i> Назад</span></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($bookings->previousPageUrl()); ?>"><i class="bi bi-chevron-left me-1"></i> Назад</a></li>
                        <?php endif; ?>

                        
                        <?php
                            $start = max($bookings->currentPage() - 2, 1);
                            $end = min($bookings->currentPage() + 2, $bookings->lastPage());
                        ?>

                        <?php if($start > 1): ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($bookings->url(1)); ?>">1</a></li>
                            <?php if($start > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for($i = $start; $i <= $end; $i++): ?>
                            <?php if($i == $bookings->currentPage()): ?>
                                <li class="page-item active"><span class="page-link"><?php echo e($i); ?></span></li>
                            <?php else: ?>
                                <li class="page-item"><a class="page-link" href="<?php echo e($bookings->url($i)); ?>"><?php echo e($i); ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if($end < $bookings->lastPage()): ?>
                            <?php if($end < $bookings->lastPage() - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($bookings->url($bookings->lastPage())); ?>"><?php echo e($bookings->lastPage()); ?></a></li>
                        <?php endif; ?>

                        
                        <?php if($bookings->hasMorePages()): ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($bookings->nextPageUrl()); ?>">Дальше <i class="bi bi-chevron-right ms-1"></i></a></li>
                        <?php else: ?>
                            <li class="page-item disabled"><span class="page-link">Дальше <i class="bi bi-chevron-right ms-1"></i></span></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="glass-empty">
                <i class="bi bi-inboxes empty-icon"></i>
                <h3 style="color: #fff; font-weight: 700; margin-bottom: 1rem;">Записей пока нет</h3>
                <p style="color: var(--text-secondary); margin-bottom: 2rem;">Ваш журнал записей чист. Найдите нужного специалиста и забронируйте время!</p>
                <a href="<?php echo e(route('services.index')); ?>" class="btn-glow" style="display: inline-flex;">
                    <i class="bi bi-search"></i> В каталог услуг
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/bookings/index.blade.php ENDPATH**/ ?>