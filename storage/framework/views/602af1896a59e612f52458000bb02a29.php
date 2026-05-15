<?php $__env->startSection('title', 'Отзывы клиентов'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - ORGANIZATION REVIEWS
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);

            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --neon-warning: #ffd166;
            --neon-info: #00d2ff;
            --neon-success: #06d6a0;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 4rem; }
        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 80%; height: 400px;
            background: radial-gradient(circle at 50% 0%, rgba(123, 44, 191, 0.1) 0%, transparent 60%);
            pointer-events: none; z-index: -1;
        }

        .page-header { margin-bottom: 2.5rem; animation: slideDown 0.5s ease-out; }
        .page-title {
            font-size: 2.2rem; font-weight: 800; color: var(--text-main); margin: 0;
            display: flex; align-items: center; gap: 1rem;
        }
        .page-title i { color: var(--neon-warning); text-shadow: 0 0 15px rgba(255, 209, 102, 0.4); }

        /* Карточка отзыва */
        .review-card {
            background: var(--glass-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 1.75rem; margin-bottom: 1.5rem; transition: all 0.3s ease;
            animation: fadeUp 0.6s ease-out both;
        }
        .review-card:hover { border-color: rgba(255,255,255,0.2); box-shadow: 0 15px 30px rgba(0,0,0,0.4); }

        .client-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .client-name { color: #fff; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem; }
        .client-name i { color: var(--text-muted); }
        .review-date { color: var(--text-muted); font-size: 0.85rem; font-weight: 500; }

        .service-tag {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(0, 210, 255, 0.1); color: var(--neon-info);
            padding: 0.35rem 0.85rem; border-radius: 99px; font-size: 0.8rem;
            font-weight: 600; margin-bottom: 1rem; border: 1px solid rgba(0, 210, 255, 0.2);
        }

        .rating-stars { color: var(--neon-warning); font-size: 1.1rem; margin-bottom: 1rem; text-shadow: 0 0 8px rgba(255, 209, 102, 0.3); }

        .review-text { color: var(--text-description); line-height: 1.6; font-size: 1rem; margin-bottom: 1.5rem; }

        /* Блок ответа */
        .reply-box {
            background: rgba(0, 102, 255, 0.05); border-left: 4px solid var(--accent-primary);
            padding: 1.25rem; border-radius: 0.5rem 1rem 1rem 0.5rem; margin-top: 1rem;
        }
        .reply-header { color: var(--accent-primary); font-weight: 800; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .reply-text { color: var(--text-main); font-size: 0.95rem; line-height: 1.5; margin: 0; }

        /* Кнопка "Ответить" */
        .btn-reply-neon {
            background: transparent; border: 1px solid var(--glass-border);
            color: var(--text-description); border-radius: 99px; padding: 0.5rem 1.25rem;
            font-size: 0.85rem; font-weight: 600; transition: 0.3s;
        }
        .btn-reply-neon:hover {
            background: rgba(0, 102, 255, 0.1); border-color: var(--accent-primary);
            color: #fff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.2);
        }

        /* Поле ввода ответа */
        .glass-textarea {
            background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 1rem; padding: 1rem; width: 100%; transition: 0.3s;
        }
        .glass-textarea:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 10px rgba(0,102,255,0.2); }

        .btn-send-reply {
            background: var(--accent-primary); color: #fff; border: none;
            border-radius: 99px; padding: 0.5rem 1.5rem; font-weight: 700;
            margin-top: 0.75rem; transition: 0.3s;
        }
        .btn-send-reply:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,102,255,0.4); }

        /* Пустое состояние */
        .empty-state {
            background: var(--glass-bg); border: 1px dashed var(--glass-border);
            border-radius: 1.5rem; padding: 4rem 2rem; text-align: center; color: var(--text-muted);
        }

        /* Пагинация */
        .custom-pagination { display: flex; gap: 0.5rem; list-style: none; padding: 0; justify-content: center; margin-top: 3rem; }
        .custom-pagination .page-link {
            background: var(--glass-bg); border: 1px solid var(--glass-border);
            color: var(--text-description); border-radius: 0.75rem; padding: 0.6rem 1.1rem;
            text-decoration: none; transition: 0.3s;
        }
        .custom-pagination .page-item.active .page-link {
            background: var(--accent-primary); border-color: var(--accent-primary); color: #fff;
        }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-chat-right-quote"></i> Отзывы клиентов</h1>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="review-card">
                <div class="client-info">
                    <div class="client-name">
                        <i class="bi bi-person-circle"></i>
                        <?php echo e($review->client->name ?? 'Неизвестный клиент'); ?>

                    </div>
                    <div class="review-date"><?php echo e($review->created_at->format('d.m.Y H:i')); ?></div>
                </div>

                <div class="service-tag">
                    <i class="bi bi-tag-fill"></i>
                    <?php echo e($review->booking->service->title ?? 'Удаленная услуга'); ?>

                    <span class="opacity-50 mx-1">/</span>
                    <?php echo e(\Carbon\Carbon::parse($review->booking->booking_date)->format('d.m.Y')); ?>

                </div>

                <div class="rating-stars">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= $review->rating): ?>
                            <i class="bi bi-star-fill"></i>
                        <?php else: ?>
                            <i class="bi bi-star" style="opacity: 0.3;"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>

                <div class="review-text">
                    «<?php echo e($review->comment); ?>»
                </div>

                <?php if($review->reply): ?>
                    <div class="reply-box">
                        <div class="reply-header"><i class="bi bi-reply-all-fill me-1"></i> Ваш ответ клиенту:</div>
                        <p class="reply-text"><?php echo e($review->reply); ?></p>
                    </div>
                <?php else: ?>
                    <button class="btn-reply-neon" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm<?php echo e($review->id); ?>">
                        <i class="bi bi-reply me-1"></i> Написать ответ
                    </button>

                    <div class="collapse mt-3" id="replyForm<?php echo e($review->id); ?>">
                        <div class="p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                            <form action="<?php echo e(route('reviews.reply', $review->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <textarea name="reply" class="glass-textarea" rows="3" placeholder="Поблагодарите клиента за отзыв..." required></textarea>
                                <div class="text-end">
                                    <button type="submit" class="btn-send-reply">Отправить ответ <i class="bi bi-send ms-1"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <i class="bi bi-chat-dots mb-3"></i>
                <h4>Отзывов пока нет</h4>
                <p>Как только клиенты начнут оставлять отзывы о ваших услугах, они появятся в этом разделе.</p>
            </div>
        <?php endif; ?>

        <div class="mt-5">
            <?php echo e($reviews->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/organization/reviews.blade.php ENDPATH**/ ?>