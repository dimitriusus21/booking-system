<?php $__env->startSection('title', 'Каталог услуг'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - SERVICES CATALOG (FIXED CONTRAST)
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-hover: rgba(255, 255, 255, 0.15);

            /* Цвета текста с повышенным контрастом */
            --text-main: #f8fafc;       /* Почти белый для заголовков */
            --text-description: #cbd5e1; /* Светло-серый для описаний (ЧИТАЕМЫЙ) */
            --text-muted: #94a3b8;      /* Средне-серый для второстепенных подписей */

            --accent-primary: #0066ff;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
        }

        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 90%; height: 600px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.12) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        /* Заголовок страницы */
        .page-header h1 { color: var(--text-main); font-weight: 800; }
        .page-header p { color: var(--text-description); font-size: 1.1rem; }

        /* Панель фильтров */
        .filter-panel {
            background: var(--glass-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 2rem; margin-bottom: 3rem; animation: slideDown 0.6s ease-out;
        }

        .glass-input, .glass-select {
            background: rgba(0, 0, 0, 0.4); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 0.75rem; padding: 0.75rem 1rem; width: 100%;
            transition: all 0.3s ease;
        }
        .glass-input:focus, .glass-select:focus {
            outline: none; border-color: var(--accent-primary); box-shadow: 0 0 15px rgba(0, 102, 255, 0.2);
        }
        .filter-label { color: var(--text-main); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em; }

        /* Кнопки */
        .btn-search {
            background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff; border: none; border-radius: 99px; padding: 0.75rem 2rem;
            font-weight: 700; transition: all 0.3s ease;
        }
        .btn-reset {
            background: rgba(255, 255, 255, 0.08); color: var(--text-main);
            border: 1px solid var(--glass-border); border-radius: 99px; padding: 0.75rem 1.5rem;
            transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;
        }

        /* Карточка услуги */
        .service-card {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 1.75rem; height: 100%; display: flex; flex-direction: column;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            animation: fadeUp 0.6s ease-out both; position: relative; overflow: hidden;
        }
        .service-card:hover { transform: translateY(-8px); border-color: rgba(255,255,255,0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }

        .cat-badge {
            background: rgba(0, 102, 255, 0.15); color: #60a5fa;
            padding: 0.3rem 0.8rem; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        }

        .duration-tag { color: var(--text-description); font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.4rem; }

        .service-title { font-size: 1.4rem; font-weight: 800; color: var(--text-main); margin: 1.25rem 0 0.5rem; }

        .rating-box { display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-main); }
        .star-active { color: var(--neon-warning); }

        /* ОПИСАНИЕ УСЛУГИ - ТЕПЕРЬ ВИДНО */
        .service-description-text {
            color: var(--text-description);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        .price-glow { font-size: 1.6rem; font-weight: 800; color: var(--neon-success); text-shadow: 0 0 15px rgba(6, 214, 160, 0.2); }
        .org-name-text { font-size: 0.85rem; color: var(--text-description); font-weight: 500; }

        /* Пагинация */
        .custom-pagination-container { margin-top: 4rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; }
        .pagination-info { color: var(--text-description); font-size: 0.875rem; }
        .pagination-info b { color: #fff; }
        .custom-pagination { display: flex; gap: 0.5rem; list-style: none; padding: 0; }
        .custom-pagination .page-link { background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-description); border-radius: 0.5rem; padding: 0.5rem 1rem; text-decoration: none; transition: 0.2s; }
        .custom-pagination .page-item.active .page-link { background: var(--accent-primary); border-color: var(--accent-primary); color: #fff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header mb-5">
            <h1 class="display-5"><i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Каталог услуг</h1>
            <p>Найдите идеальное время для вашего преображения и запишитесь онлайн</p>
        </div>

        <div class="filter-panel">
            <form method="GET" action="<?php echo e(route('services.index')); ?>" class="row g-4 align-items-end">
                <div class="col-lg-4">
                    <div class="filter-label">Поиск</div>
                    <input type="text" name="search" class="glass-input" placeholder="Название или ключевое слово..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-lg-3">
                    <div class="filter-label">Категория</div>
                    <select name="category_id" class="glass-select">
                        <option value="">Все категории</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <div class="filter-label">Сортировка</div>
                    <select name="sort" class="glass-select">
                        <option value="">Сначала новые</option>
                        <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Цена: по возрастанию</option>
                        <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Цена: по убыванию</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-search w-100"><i class="bi bi-search"></i></button>
                        <a href="<?php echo e(route('services.index')); ?>" class="btn-reset" title="Сбросить"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col">
                    <div class="service-card" style="animation-delay: <?php echo e($index * 0.05); ?>s;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="cat-badge"><?php echo e($service->category->name ?? 'Общее'); ?></span>
                            <span class="duration-tag"><i class="bi bi-clock"></i> <?php echo e($service->duration); ?> мин</span>
                        </div>

                        <h5 class="service-title"><?php echo e($service->title); ?></h5>

                        <div class="rating-box">
                            <?php
                                $svcRating = \App\Models\Review::whereHas('booking', fn($q) => $q->where('service_id', $service->id))->avg('rating') ?: 0;
                                $svcCount = \App\Models\Review::whereHas('booking', fn($q) => $q->where('service_id', $service->id))->count();
                            ?>
                            <?php if($svcCount > 0): ?>
                                <i class="bi bi-star-fill star-active"></i>
                                <span><?php echo e(number_format($svcRating, 1)); ?></span>
                                <span style="color: var(--text-muted)">(<?php echo e($svcCount); ?> отз.)</span>
                            <?php else: ?>
                                <span style="color: var(--text-muted)"><i class="bi bi-star me-1"></i>Нет оценок</span>
                            <?php endif; ?>
                        </div>

                        <p class="service-description-text"><?php echo e(Str::limit($service->description, 120)); ?></p>

                        <div class="mt-auto pt-4 border-top border-secondary border-opacity-10 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price-glow"><?php echo e(number_format($service->price, 0, '', ' ')); ?> ₽</div>
                                <div class="org-name-text"><i class="bi bi-building me-1"></i><?php echo e($service->organization->name); ?></div>
                            </div>
                            <a href="<?php echo e(route('services.show', $service)); ?>" class="btn-search py-2 px-4" style="font-size: 0.9rem; text-decoration: none;">Записаться</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="service-card text-center py-5">
                        <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                        <h4 class="text-white mt-3">Услуги не найдены</h4>
                        <p class="service-description-text">Попробуйте изменить параметры поиска или фильтрации</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if($services->hasPages()): ?>
            <div class="custom-pagination-container">
                <div class="pagination-info">Показаны услуги с <b><?php echo e($services->firstItem()); ?></b> по <b><?php echo e($services->lastItem()); ?></b> из <b><?php echo e($services->total()); ?></b></div>
                <ul class="custom-pagination">
                    <li class="page-item <?php echo e($services->onFirstPage() ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e($services->previousPageUrl() ?? '#'); ?>"><i class="bi bi-chevron-left"></i> Назад</a>
                    </li>
                    <?php $__currentLoopData = $services->getUrlRange(1, min(5, $services->lastPage())); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="page-item <?php echo e($page == $services->currentPage() ? 'active' : ''); ?>">
                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="page-item <?php echo e(!$services->hasMorePages() ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e($services->nextPageUrl() ?? '#'); ?>">Дальше <i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/services/index.blade.php ENDPATH**/ ?>