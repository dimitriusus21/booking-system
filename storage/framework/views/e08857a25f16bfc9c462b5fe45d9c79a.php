<?php $__env->startSection('title', 'Наши организации'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - ORGANIZATIONS CATALOG
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #ffffff;
            --text-description: #e2e8f0;
            --text-muted: #cbd5e1;

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-warning: #ffd166;
            --neon-success: #06d6a0;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 5rem; }

        /* Атмосферные свечения на фоне */
        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 90%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.1) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        .page-header { margin-bottom: 3.5rem; animation: slideDown 0.6s ease-out; }
        .page-title {
            font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin: 0;
            display: flex; align-items: center; gap: 1rem;
        }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 20px rgba(0, 102, 255, 0.5); }

        /* СЕТКА КАРТОЧЕК */
        .org-card {
            background: var(--glass-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); border-radius: 2rem;
            padding: 2rem; height: 100%; display: flex; flex-direction: column;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            animation: fadeUp 0.6s ease-out both;
            position: relative; overflow: hidden;
        }
        .org-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-primary);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(0, 102, 255, 0.2);
        }

        /* Иконка организации */
        .org-icon-box {
            width: 64px; height: 64px; background: linear-gradient(135deg, var(--accent-primary), var(--accent-purple));
            border-radius: 1.25rem; display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.5rem; box-shadow: 0 10px 20px rgba(0, 102, 255, 0.2);
            color: #fff; font-size: 1.75rem;
        }

        .org-name { font-size: 1.4rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem; line-height: 1.2; }

        .cat-badge {
            display: inline-block; background: rgba(255, 255, 255, 0.05); color: var(--accent-primary);
            padding: 0.3rem 0.8rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; border: 1px solid rgba(0, 102, 255, 0.2); margin-bottom: 1.25rem;
        }

        /* РЕЙТИНГ - ТЕПЕРЬ ВИДНО */
        .rating-box { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem; }
        .stars-glow { color: var(--neon-warning); font-size: 1.1rem; text-shadow: 0 0 10px rgba(255, 209, 102, 0.4); }
        .rating-value { color: #fff; font-weight: 800; font-size: 1rem; }
        .reviews-count { color: var(--text-description); font-size: 0.85rem; font-weight: 500; }

        /* ОПИСАНИЕ - ТЕПЕРЬ ВИДНО */
        .org-description {
            color: var(--text-description); font-size: 0.95rem; line-height: 1.6;
            margin-bottom: 1.5rem; flex-grow: 1;
        }

        /* АДРЕС */
        .org-location {
            display: flex; align-items: center; gap: 0.6rem; color: var(--text-description);
            font-size: 0.85rem; font-weight: 600; padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,0.05);
        }
        .org-location i { color: var(--accent-primary); font-size: 1rem; }

        /* Кнопка */
        .btn-org-link {
            background: var(--accent-primary); color: #fff; border: none;
            border-radius: 99px; padding: 0.75rem 1.5rem; font-weight: 800;
            text-decoration: none; display: flex; align-items: center; justify-content: center;
            gap: 0.5rem; margin-top: 1.5rem; transition: 0.3s;
        }
        .btn-org-link:hover { background: #0052cc; box-shadow: 0 0 20px rgba(0, 102, 255, 0.4); color: #fff; transform: scale(1.02); }

        /* Пагинация */
        .custom-pagination { display: flex; gap: 0.5rem; list-style: none; padding: 0; justify-content: center; margin-top: 4rem; }
        .custom-pagination .page-link {
            background: var(--glass-bg); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 0.75rem; padding: 0.7rem 1.25rem;
            text-decoration: none; transition: 0.3s; font-weight: 700;
        }
        .custom-pagination .page-item.active .page-link {
            background: var(--accent-primary); border-color: var(--accent-primary);
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.3);
        }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper container py-4">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-buildings-fill"></i>
                Наши организации
            </h1>
            <p class="mt-2" style="color: var(--text-description); font-size: 1.1rem;">Лучшие специалисты и заведения в вашем городе</p>
        </div>

        <?php if($organizations->count() > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="org-card" style="animation-delay: <?php echo e($index * 0.1); ?>s;">
                            <div class="org-icon-box">
                                <i class="bi bi-building"></i>
                            </div>

                            <span class="cat-badge"><?php echo e($organization->category->name ?? 'Сервис'); ?></span>

                            <h5 class="org-name"><?php echo e($organization->name); ?></h5>

                            <div class="rating-box">
                                <?php
                                    $rating = $organization->average_rating;
                                    $roundedRating = round($rating);
                                ?>

                                <div class="stars-glow">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo $i <= $roundedRating ? '★' : '<span style="opacity: 0.2">☆</span>'; ?>

                                    <?php endfor; ?>
                                </div>

                                <?php if($organization->reviews_count > 0): ?>
                                    <span class="rating-value"><?php echo e(number_format($rating, 1, '.', '')); ?></span>
                                    <span class="reviews-count">(<?php echo e($organization->reviews_count); ?> отзывов)</span>
                                <?php else: ?>
                                    <span class="reviews-count">Нет отзывов</span>
                                <?php endif; ?>
                            </div>

                            <p class="org-description">
                                <?php echo e(Str::limit($organization->description ?? 'Данная организация еще не добавила описание своих услуг и преимуществ.', 120)); ?>

                            </p>

                            <div class="org-location mt-auto">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span><?php echo e($organization->address ?? 'Адрес уточняйте'); ?></span>
                            </div>

                            <a href="<?php echo e(route('organizations.show', $organization)); ?>" class="btn-org-link">
                                Открыть профиль <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-5">
                <?php echo e($organizations->links('pagination::bootstrap-4')); ?>

            </div>
        <?php else: ?>
            <div class="glass-panel text-center py-5 rounded-4">
                <i class="bi bi-building-dash fs-1 text-primary opacity-50"></i>
                <h4 class="text-white mt-4">Организаций пока нет</h4>
                <p style="color: var(--text-description);">Станьте первым и зарегистрируйте свой бизнес прямо сейчас!</p>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isOrganization()): ?>
                        <a href="<?php echo e(route('organization.profile.create')); ?>" class="btn-org-link d-inline-flex px-5">Создать профиль</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/organizations/index.blade.php ENDPATH**/ ?>