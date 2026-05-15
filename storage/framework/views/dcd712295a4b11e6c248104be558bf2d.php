<?php $__env->startSection('title', 'Настройка расписания'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - ELITE SCHEDULE BUILDER
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);

            /* МАКСИМАЛЬНЫЙ КОНТРАСТ ДЛЯ ТЕКСТА */
            --text-main: #ffffff;        /* Чисто белый */
            --text-description: #e2e8f0; /* Яркий светло-серый (для всех описаний) */
            --text-muted: #94a3b8;       /* Средний серый */

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
            --neon-danger: #ef476f;
            --neon-magic: #ffaa00;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 4rem; }
        .ambient-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 100%; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.15) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        /* Заголовок */
        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2.5rem; animation: slideDown 0.5s ease-out;
            flex-wrap: wrap; gap: 1rem;
        }
        .page-title {
            font-size: 2.2rem; font-weight: 800; color: var(--text-main); margin: 0;
            display: flex; align-items: center; gap: 1rem;
        }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        /* Навигация */
        .btn-nav-glass {
            background: rgba(255, 255, 255, 0.08); color: #fff;
            border: 1px solid var(--glass-border); border-radius: 99px;
            padding: 0.6rem 1.25rem; font-weight: 700; text-decoration: none;
            transition: 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-nav-glass:hover { background: rgba(255, 255, 255, 0.15); color: #fff; transform: translateY(-2px); }
        .btn-nav-primary {
            background: var(--accent-primary); border: none;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.3);
        }

        /* Панели */
        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 2.25rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            height: 100%; animation: fadeUp 0.6s ease-out both;
        }
        .panel-title {
            color: var(--text-main); font-weight: 800; font-size: 1.4rem;
            margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;
        }

        /* ЯРКИЙ ТЕКСТ ОПИСАНИЯ */
        .description-bright {
            color: var(--text-description) !important;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.75rem;
            display: block;
            font-weight: 400;
        }

        /* Селектор дней */
        .days-grid { display: flex; flex-wrap: wrap; gap: 0.8rem; margin-bottom: 2rem; }
        .day-label {
            width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;
            border-radius: 14px; border: 1px solid var(--glass-border); background: rgba(0,0,0,0.3);
            color: var(--text-description); font-weight: 700; cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .day-checkbox:checked + .day-label {
            background: var(--accent-primary); border-color: var(--accent-primary);
            color: #fff; transform: scale(1.1); box-shadow: 0 0 20px rgba(0, 102, 255, 0.4);
        }

        /* Ввод времени */
        .input-label {
            color: var(--text-main); font-size: 0.85rem; font-weight: 800;
            text-transform: uppercase; margin-bottom: 0.6rem; display: block; letter-spacing: 0.05em;
        }
        .glass-input {
            background: rgba(0, 0, 0, 0.5); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 0.8rem; padding: 0.85rem 1.1rem; width: 100%;
            transition: 0.3s; color-scheme: dark; font-weight: 600;
        }

        /* ТАБЛИЦА И НОВЫЕ КНОПКИ УДАЛЕНИЯ */
        .glass-table th { color: var(--text-main); font-size: 0.8rem; text-transform: uppercase; font-weight: 800; padding: 1.25rem 1rem; border-bottom: 1px solid var(--glass-border); }
        .glass-table td { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-description); vertical-align: middle; }

        .work-time-badge {
            background: rgba(0, 102, 255, 0.15); color: #60a5fa;
            padding: 0.5rem 1rem; border-radius: 10px; font-weight: 800;
            border: 1px solid rgba(0, 102, 255, 0.3);
        }

        /* СТИЛЬНАЯ КНОПКА УДАЛЕНИЯ (Action Glass) */
        .btn-action-delete {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            background: rgba(239, 71, 111, 0.08);
            border: 1px solid rgba(239, 71, 111, 0.2);
            color: var(--neon-danger);
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 0; margin-left: auto;
        }
        .btn-action-delete:hover {
            background: var(--neon-danger);
            color: #fff;
            box-shadow: 0 0 20px rgba(239, 71, 111, 0.5);
            transform: scale(1.1) rotate(8deg);
            border-color: var(--neon-danger);
        }
        .btn-action-delete i { font-size: 1.2rem; }

        /* Magic Generator */
        .magic-card {
            background: linear-gradient(135deg, rgba(255, 170, 0, 0.1) 0%, rgba(30, 30, 45, 0.9) 100%);
            border: 1px solid rgba(255, 170, 0, 0.4); border-radius: 1.5rem;
            padding: 2rem; margin-top: 2rem; position: relative; overflow: hidden;
        }
        .magic-title { color: var(--neon-magic); font-weight: 900; font-size: 1.6rem; margin-bottom: 0.5rem; text-shadow: 0 0 15px rgba(255, 170, 0, 0.2); }
        .btn-magic {
            background: var(--neon-magic); color: #000; border: none;
            border-radius: 99px; padding: 1.1rem 2rem; font-weight: 900; font-size: 1.05rem;
            transition: 0.3s; box-shadow: 0 0 25px rgba(255, 170, 0, 0.4);
        }
        .btn-magic:hover { transform: translateY(-3px); box-shadow: 0 10px 35px rgba(255, 170, 0, 0.6); background: #ffc233; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-calendar-week-fill"></i>
                Настройка расписания
            </h1>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('organization.services.index')); ?>" class="btn-nav-glass">
                    <i class="bi bi-arrow-left"></i> К услугам
                </a>
                <a href="<?php echo e(route('organization.slots.index', $service->id)); ?>" class="btn-nav-glass btn-nav-primary">
                    <i class="bi bi-ui-checks-grid"></i> Редактор слотов
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-5">
                <div class="glass-panel">
                    <h5 class="panel-title"><i class="bi bi-plus-circle-dotted text-primary"></i> Добавить рабочие часы</h5>

                    <span class="description-bright">
                        Выберите дни недели и установите временной интервал. Эти правила автоматически обновят ваш текущий график работы.
                    </span>

                    <form action="<?php echo e(route('organization.schedule.store', $service->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <label class="input-label">1. Выберите дни недели <span class="text-danger">*</span></label>
                        <div class="days-grid">
                            <?php $days = [1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб', 7 => 'Вс']; ?>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="day-item">
                                    <input type="checkbox" name="days[]" value="<?php echo e($val); ?>" id="day<?php echo e($val); ?>" class="day-checkbox" style="display:none">
                                    <label for="day<?php echo e($val); ?>" class="day-label"><?php echo e($name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <label class="input-label">2. Время работы</label>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <input type="time" name="start_time" class="glass-input" required>
                                <small class="text-white-50 mt-1 d-block ms-1">Открытие</small>
                            </div>
                            <div class="col-6">
                                <input type="time" name="end_time" class="glass-input" required>
                                <small class="text-white-50 mt-1 d-block ms-1">Закрытие</small>
                            </div>
                        </div>

                        <div class="p-4 rounded-4 mb-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                            <label class="input-label mb-3"><i class="bi bi-cup-hot-fill me-2 text-warning"></i>Время перерыва (если есть)</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="time" name="break_start" class="glass-input">
                                </div>
                                <div class="col-6">
                                    <input type="time" name="break_end" class="glass-input">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-magic w-100 py-3 mt-2" style="background: var(--accent-primary); color: #fff; box-shadow: 0 0 20px rgba(0, 102, 255, 0.3);">
                            <i class="bi bi-check2-all me-2"></i> Сохранить расписание
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="glass-panel">
                    <h5 class="panel-title"><i class="bi bi-alarm text-primary"></i> График услуги: <?php echo e($service->title); ?></h5>

                    <?php if($schedules->count() > 0): ?>
                        <div class="table-responsive mb-4">
                            <table class="glass-table">
                                <thead>
                                <tr>
                                    <th>День</th>
                                    <th>Интервал</th>
                                    <th>Обед</th>
                                    <th class="text-end">Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $dayNames = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье']; ?>
                                <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="fw-bold text-white"><?php echo e($dayNames[$schedule->day_of_week]); ?></td>
                                        <td>
                                                <span class="work-time-badge">
                                                    <?php echo e(\Carbon\Carbon::parse($schedule->start_time)->format('H:i')); ?> — <?php echo e(\Carbon\Carbon::parse($schedule->end_time)->format('H:i')); ?>

                                                </span>
                                        </td>
                                        <td class="text-white">
                                            <?php if($schedule->break_start && $schedule->break_end): ?>
                                                <i class="bi bi-clock-history me-1 opacity-50"></i><?php echo e(\Carbon\Carbon::parse($schedule->break_start)->format('H:i')); ?>-<?php echo e(\Carbon\Carbon::parse($schedule->break_end)->format('H:i')); ?>

                                            <?php else: ?>
                                                <span class="opacity-25">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <form action="<?php echo e(route('organization.schedule.destroy', [$service->id, $schedule->day_of_week])); ?>" method="POST">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn-action-delete" onclick="return confirm('Удалить этот день из графика?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="magic-card">
                            <h5 class="magic-title"><i class="bi bi-stars"></i> Генератор слотов</h5>
                            <span class="description-bright mb-4 d-block">
                                Правила готовы. Нажмите кнопку ниже, чтобы система автоматически создала доступные окна для записи в вашем календаре.
                            </span>

                            <form action="<?php echo e(route('organization.slots.generate', $service->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-7">
                                        <label class="input-label">Глубина планирования</label>
                                        <select name="period_type" id="periodType" class="glass-input" onchange="toggleCustomDays()">
                                            <option value="month">На 1 месяц (30 дней)</option>
                                            <option value="quarter">На 3 месяца (90 дней)</option>
                                            <option value="half_year">На полгода (180 дней)</option>
                                            <option value="custom">Свой вариант...</option>
                                        </select>
                                    </div>

                                    <div class="col-md-5" id="customDaysWrapper" style="display: none;">
                                        <label class="input-label">Сколько дней?</label>
                                        <input type="number" name="custom_days" id="customDaysInput" class="glass-input" min="1" max="730" placeholder="Напр. 45">
                                    </div>

                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn-magic w-100">
                                            <i class="bi bi-lightning-fill me-2"></i> Создать окошки для записи
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="bg-primary bg-opacity-10 d-inline-flex p-4 rounded-circle mb-4">
                                <i class="bi bi-calendar-x fs-1 text-primary"></i>
                            </div>
                            <h4 class="text-white mb-2">Расписание пусто</h4>
                            <p class="description-bright">Используйте панель слева, чтобы задать часы работы для этой услуги.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleCustomDays() {
            const select = document.getElementById('periodType');
            const wrapper = document.getElementById('customDaysWrapper');
            const input = document.getElementById('customDaysInput');
            if (select.value === 'custom') {
                wrapper.style.display = 'block';
                input.setAttribute('required', 'required');
            } else {
                wrapper.style.display = 'none';
                input.removeAttribute('required');
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/organization/schedule.blade.php ENDPATH**/ ?>