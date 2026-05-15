<?php $__env->startSection('title', $service->title); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - SERVICE PAGE (FIXED CONTRAST)
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);

            --text-main: #f8fafc;
            --text-description: #cbd5e1;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 5rem; }
        .ambient-glow {
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 100%; max-width: 1000px; height: 500px;
            background: radial-gradient(circle at 50% 0%, rgba(0, 102, 255, 0.15) 0%, transparent 70%);
            pointer-events: none; z-index: -1; filter: blur(50px);
        }

        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border); border-radius: 1.5rem;
            padding: 2.5rem; box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            animation: fadeUp 0.6s ease-out both;
        }

        .service-title { font-size: 3rem; font-weight: 800; color: var(--text-main); line-height: 1.1; margin-bottom: 1.5rem; }

        .badge-row { display: flex; gap: 1rem; margin-bottom: 2rem; }
        .neon-badge {
            padding: 0.5rem 1.25rem; border-radius: 99px; font-size: 0.8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(255,255,255,0.15);
        }
        .badge-cat { background: rgba(0, 102, 255, 0.15); color: #60a5fa; }
        .badge-time { background: rgba(255, 255, 255, 0.05); color: var(--text-main); }

        .description-text {
            color: var(--text-description);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            font-weight: 400;
        }

        .org-box {
            background: rgba(0, 0, 0, 0.4); border: 1px solid var(--glass-border);
            border-radius: 1rem; padding: 1.5rem; margin-top: 2rem; display: flex; align-items: center; gap: 1.5rem;
        }
        .org-details h5 { color: var(--text-main); font-weight: 700; margin-bottom: 0.25rem; }
        .org-details p { color: var(--text-description); margin: 0; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem; }

        .sticky-booking-card {
            position: sticky; top: 100px; text-align: center; border-radius: 1.5rem;
            background: linear-gradient(180deg, rgba(30, 30, 45, 0.8) 0%, rgba(10, 10, 15, 0.95) 100%);
            border: 1px solid var(--glass-border); padding: 2.5rem; box-shadow: 0 0 30px rgba(0, 102, 255, 0.15);
        }
        .price-large { font-size: 3.5rem; font-weight: 800; color: var(--neon-success); text-shadow: 0 0 20px rgba(6, 214, 160, 0.3); margin-bottom: 1.5rem; }

        .btn-glow {
            width: 100%; padding: 1.2rem; border-radius: 99px; border: none;
            background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.3); transition: 0.3s; cursor: pointer;
        }
        .btn-glow:disabled {
            background: #334155; color: #94a3b8; box-shadow: none; cursor: not-allowed;
        }

        .review-card { padding: 1.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .review-card:last-child { border-bottom: none; }
        .review-user { font-weight: 700; color: var(--text-main); }
        .review-comment { color: var(--text-description); font-size: 1rem; line-height: 1.6; margin-top: 0.75rem; font-style: italic; }
        .star-filled { color: var(--neon-warning); }

        /* ИНПУТЫ И СЛОТЫ В ПРАВОЙ ПАНЕЛИ */
        .glass-input, .glass-textarea {
            background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); color: #fff;
            border-radius: 0.75rem; width: 100%; padding: 0.8rem 1rem; color-scheme: dark;
        }
        .glass-input:focus, .glass-textarea:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 10px rgba(0,102,255,0.2); }
        .modal-label { color: var(--text-main); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }

        .slot-btn {
            background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border); color: var(--text-main);
            border-radius: 0.5rem; padding: 0.5rem; transition: all 0.3s ease; flex: 1 1 calc(33.333% - 0.5rem); text-align: center; font-weight: 600;
        }
        .slot-btn:hover { background: rgba(0, 102, 255, 0.2); border-color: var(--accent-primary); color: #fff; }
        .slot-btn.active {
            background: var(--accent-primary); color: #fff; border-color: var(--accent-primary);
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.5);
        }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="glass-panel mb-4">
                        <div class="badge-row">
                            <span class="neon-badge badge-cat"><?php echo e($service->category->name ?? 'Услуга'); ?></span>
                            <span class="neon-badge badge-time"><i class="bi bi-clock me-2"></i><?php echo e($service->duration); ?> мин</span>
                        </div>
                        <h1 class="service-title"><?php echo e($service->title); ?></h1>
                        <div class="description-text"><?php echo e($service->description); ?></div>

                        <div class="org-box">
                            <div class="org-icon">
                                <i class="bi bi-buildings fs-2 text-primary"></i>
                            </div>
                            <div class="org-details">
                                <h5><?php echo e($service->organization->name); ?></h5>
                                <p><i class="bi bi-geo-alt text-primary"></i> <?php echo e($service->organization->address); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel">
                        <h4 class="text-white fw-bold mb-4"><i class="bi bi-chat-left-quote me-2 text-warning"></i>Отзывы клиентов</h4>
                        <?php if($reviews->count() > 0): ?>
                            <div class="lead text-white mb-4" style="font-weight: 700;">Средний рейтинг: <span class="text-warning"><?php echo e(number_format($averageRating, 1)); ?> ★</span></div>
                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="review-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="review-user"><i class="bi bi-person-circle me-2 opacity-50"></i><?php echo e($review->client->name); ?></div>
                                        <div style="color: var(--text-muted); font-size: 0.85rem;"><?php echo e($review->created_at->format('d.m.Y')); ?></div>
                                    </div>
                                    <div class="mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?php echo e($i <= $review->rating ? '-fill star-filled' : ''); ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="review-comment">"<?php echo e($review->comment); ?>"</div>
                                    <?php if($review->reply): ?>
                                        <div class="mt-3 p-3 rounded" style="background: rgba(0, 102, 255, 0.08); border-left: 3px solid var(--accent-primary);">
                                            <div style="color: var(--accent-primary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.25rem;">Ответ мастера:</div>
                                            <div style="color: var(--text-description); font-size: 0.95rem;"><?php echo e($review->reply); ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="text-center py-4" style="color: var(--text-muted);">
                                <i class="bi bi-chat-square-dots fs-1 opacity-20"></i>
                                <p class="mt-3">Отзывов пока нет. Будьте первыми!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-booking-card">
                        <div style="color: var(--text-description); font-size: 0.85rem; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Стоимость услуги</div>
                        <div class="price-large"><?php echo e(number_format($service->price, 0, '', ' ')); ?> ₽</div>

                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isClient()): ?>
                                <form action="<?php echo e(route('bookings.store', $service->id)); ?>" method="POST" id="bookingForm" class="text-start mt-4">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="time_slot_id" id="selected_slot_id" value="">

                                    <div class="mb-4">
                                        <label class="modal-label">Выберите дату</label>
                                        <input type="date" id="booking_date" class="glass-input" min="<?php echo e(date('Y-m-d')); ?>">
                                    </div>

                                    <div class="mb-4">
                                        <label class="modal-label">Доступное время</label>
                                        <div id="slots_container" class="d-flex flex-wrap gap-2 py-3 px-2 rounded" style="background: rgba(0,0,0,0.3); min-height: 80px;">
                                            <div class="text-center w-100 my-auto" style="color: var(--text-muted); font-size: 0.9rem;">Сначала укажите дату</div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="modal-label">Ваши пожелания</label>
                                        <textarea name="comment" id="booking_comment" class="glass-textarea" rows="2" placeholder="Например: хочу к определенному мастеру..."></textarea>
                                    </div>

                                    <button type="submit" id="confirm_booking" class="btn-glow" disabled>Подтвердить запись</button>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-info bg-info bg-opacity-10 border-0 text-info small mt-4">Вы зашли как организация. Бронирование доступно только клиентам.</div>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn-glow text-center d-block mt-4" style="text-decoration: none;">Войти для записи</a>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger mt-3 bg-danger bg-opacity-10 text-danger border-0 text-start small">
                                <ul class="mb-0 ps-3">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger mt-3 bg-danger bg-opacity-10 text-danger border-0 small text-start">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateInput = document.getElementById('booking_date');
                const slotsContainer = document.getElementById('slots_container');
                const slotInput = document.getElementById('selected_slot_id');
                const submitBtn = document.getElementById('confirm_booking');

                if (dateInput) {
                    dateInput.addEventListener('change', function() {
                        let date = this.value;
                        let serviceId = <?php echo e($service->id); ?>;

                        slotInput.value = '';
                        submitBtn.disabled = true;
                        slotsContainer.innerHTML = '<div class="text-center w-100 my-auto" style="color: var(--text-muted); font-size: 0.9rem;">Загрузка...</div>';

                        fetch(`/api/services/${serviceId}/slots?date=${date}`)
                            .then(response => {
                                if (!response.ok) { throw new Error('Ошибка сети'); }
                                return response.json();
                            })
                            .then(data => {
                                slotsContainer.innerHTML = '';

                                if (data.success && data.slots.length > 0) {
                                    data.slots.forEach(slot => {
                                        let btn = document.createElement('div');
                                        btn.className = 'slot-btn';
                                        btn.textContent = slot.start_time;
                                        btn.dataset.id = slot.id;

                                        btn.addEventListener('click', function() {
                                            document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('active'));
                                            this.classList.add('active');
                                            slotInput.value = this.dataset.id;
                                            submitBtn.disabled = false;
                                        });

                                        slotsContainer.appendChild(btn);
                                    });
                                } else {
                                    slotsContainer.innerHTML = '<div class="text-center w-100 my-auto" style="color: var(--neon-warning); font-size: 0.9rem;">На эту дату нет свободного времени</div>';
                                }
                            })
                            .catch(error => {
                                console.error('Ошибка загрузки слотов:', error);
                                slotsContainer.innerHTML = '<div class="text-center w-100 my-auto text-danger" style="font-size: 0.9rem;">Ошибка загрузки</div>';
                            });
                    });
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/services/show.blade.php ENDPATH**/ ?>