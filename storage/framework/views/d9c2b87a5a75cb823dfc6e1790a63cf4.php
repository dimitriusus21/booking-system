<?php $__env->startSection('title', 'Мои отзывы'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - CLIENT REVIEWS JOURNAL
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #ffffff;
            --text-description: #e2e8f0;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-warning: #ffd166;
            --neon-danger: #ef476f;
            --neon-success: #06d6a0;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 4rem; }

        /* Атмосферный фон */
        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 100%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(123, 44, 191, 0.1) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 3rem; animation: slideDown 0.5s ease-out;
            flex-wrap: wrap; gap: 1rem;
        }
        .page-title { font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 1rem; }
        .page-title i { color: var(--accent-purple); text-shadow: 0 0 20px rgba(123, 44, 191, 0.5); }

        .btn-back-glass {
            background: rgba(255, 255, 255, 0.08); color: #fff; border: 1px solid var(--glass-border);
            border-radius: 99px; padding: 0.7rem 1.75rem; font-weight: 700; text-decoration: none;
            transition: 0.3s; display: flex; align-items: center; gap: 0.5rem;
        }
        .btn-back-glass:hover { background: rgba(255, 255, 255, 0.15); transform: translateX(-5px); border-color: var(--accent-purple); }

        /* КАРТОЧКА ОТЗЫВА */
        .review-card {
            background: var(--glass-bg); backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border); border-radius: 2rem;
            padding: 2rem; margin-bottom: 2rem; transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            animation: fadeUp 0.6s ease-out both; position: relative; overflow: hidden;
        }
        .review-card:hover {
            transform: translateY(-8px); border-color: var(--accent-purple);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 20px rgba(123, 44, 191, 0.15);
        }

        /* Шапка отзыва */
        .stars-glow { color: var(--neon-warning); font-size: 1.2rem; text-shadow: 0 0 10px rgba(255, 209, 102, 0.4); }
        .review-date { color: var(--text-muted); font-size: 0.9rem; font-weight: 600; }

        .service-info { margin: 1.5rem 0; }
        .service-title { font-size: 1.6rem; font-weight: 900; color: #fff; margin-bottom: 0.25rem; }
        .org-link { color: var(--accent-primary); text-decoration: none; font-weight: 700; font-size: 1rem; transition: 0.2s; }
        .org-link:hover { color: var(--neon-info); text-shadow: 0 0 10px rgba(0, 210, 255, 0.3); }

        .review-comment {
            font-size: 1.1rem; color: var(--text-description); line-height: 1.7;
            padding: 1.25rem; background: rgba(0,0,0,0.2); border-radius: 1.25rem;
            border-left: 4px solid var(--accent-purple); margin-bottom: 1.5rem;
        }

        /* Ответ организации */
        .reply-card {
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.1) 0%, rgba(20, 20, 30, 0.8) 100%);
            border: 1px solid rgba(0, 102, 255, 0.2); border-radius: 1.5rem;
            padding: 1.5rem; margin-top: 1rem; position: relative;
        }
        .reply-header { color: var(--accent-primary); font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .reply-content { color: #fff; font-size: 1rem; line-height: 1.5; font-style: italic; }

        /* Кнопки действий */
        .actions-group { display: flex; gap: 0.75rem; }
        .btn-action-glass {
            padding: 0.6rem 1.25rem; border-radius: 99px; font-weight: 700; font-size: 0.85rem;
            display: flex; align-items: center; gap: 0.5rem; transition: 0.3s; text-decoration: none;
            border: 1px solid var(--glass-border); background: rgba(255,255,255,0.03);
        }
        .btn-edit-neon { color: var(--text-description); }
        .btn-edit-neon:hover { background: var(--accent-primary); color: #fff; border-color: var(--accent-primary); box-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        .btn-delete-neon { color: var(--neon-danger); }
        .btn-delete-neon:hover { background: var(--neon-danger); color: #fff; border-color: var(--neon-danger); box-shadow: 0 0 15px rgba(239, 71, 111, 0.4); }

        /* Пустое состояние */
        .empty-state {
            background: var(--glass-bg); border: 1px dashed var(--glass-border);
            border-radius: 2rem; padding: 5rem 2rem; text-align: center;
        }
        .empty-icon { font-size: 4rem; color: var(--accent-purple); opacity: 0.3; margin-bottom: 1.5rem; display: block; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-chat-heart-fill"></i> Мои отзывы</h1>
            <a href="<?php echo e(route('my-bookings')); ?>" class="btn-back-glass">
                <i class="bi bi-arrow-left-circle"></i> Вернуться к записям
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25 text-white rounded-4 mb-5 shadow-lg">
                <i class="bi bi-check2-all me-2 text-success fs-4"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($reviews->count() > 0): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12">
                        <div class="review-card">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <div class="stars-glow mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php echo $i <= $review->rating ? '★' : '<span style="opacity: 0.2">☆</span>'; ?>

                                        <?php endfor; ?>
                                    </div>
                                    <div class="review-date">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        <?php echo e(\Carbon\Carbon::parse($review->created_at)->locale('ru')->translatedFormat('d F Y')); ?>

                                    </div>
                                </div>

                                <div class="actions-group">
                                    <a href="<?php echo e(route('reviews.edit', $review)); ?>" class="btn-action-glass btn-edit-neon">
                                        <i class="bi bi-pencil-square"></i> Изменить
                                    </a>
                                    <form action="<?php echo e(route('reviews.destroy', $review)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-action-glass btn-delete-neon" onclick="return confirm('Вы уверены, что хотите навсегда удалить этот отзыв?')">
                                            <i class="bi bi-trash3-fill"></i> Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="service-info">
                                <h2 class="service-title"><?php echo e($review->booking->service->title ?? 'Услуга более недоступна'); ?></h2>
                                <a href="<?php echo e(route('organizations.show', $review->organization)); ?>" class="org-link">
                                    <i class="bi bi-building me-1"></i> <?php echo e($review->organization->name); ?>

                                </a>
                            </div>

                            <div class="review-comment">
                                «<?php echo e($review->comment); ?>»
                            </div>

                            <?php if($review->reply): ?>
                                <div class="reply-card">
                                    <div class="reply-header">
                                        <i class="bi bi-reply-all-fill"></i> Ответ организации
                                    </div>
                                    <div class="reply-content">
                                        <?php echo e($review->reply); ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-5 d-flex justify-content-center">
                <?php echo e($reviews->links('pagination::bootstrap-4')); ?>

            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-chat-square-dots empty-icon"></i>
                <h3 class="text-white fw-bold">Журнал отзывов пуст</h3>
                <p class="text-white-50 fs-5 mb-4">Вы еще не делились своими впечатлениями о полученных услугах.</p>
                <a href="<?php echo e(route('my-bookings')); ?>" class="btn-back-glass d-inline-flex px-5 py-3" style="background: var(--accent-purple);">
                    Оставить первый отзыв
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/reviews/index.blade.php ENDPATH**/ ?>