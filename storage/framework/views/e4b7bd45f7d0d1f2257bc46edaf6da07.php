<?php $__env->startSection('title', 'Редактировать отзыв'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - REVIEW EDIT STATION
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.8);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #ffffff;
            --text-description: #e2e8f0;
            --text-muted: #94a3b8;

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-warning: #ffd166;
            --neon-danger: #ef476f;
        }

        .dark-page-wrapper { position: relative; min-height: 80vh; display: flex; align-items: center; justify-content: center; }

        /* Фон */
        .ambient-glow {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 80%; height: 600px;
            background: radial-gradient(circle, rgba(123, 44, 191, 0.15) 0%, transparent 70%);
            pointer-events: none; z-index: -1; filter: blur(50px);
        }

        /* Панель формы */
        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border); border-radius: 2.5rem;
            padding: 3rem; width: 100%; max-width: 600px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            animation: fadeUp 0.6s ease-out;
            position: relative; overflow: hidden;
        }
        .glass-panel::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, var(--neon-warning), var(--accent-purple));
        }

        .form-title { font-size: 2rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem; text-align: center; }
        .service-info-badge {
            background: rgba(255, 255, 255, 0.05); color: var(--accent-primary);
            padding: 0.5rem 1.25rem; border-radius: 99px; font-size: 0.9rem;
            font-weight: 700; display: block; width: fit-content; margin: 0 auto 2.5rem;
            border: 1px solid rgba(0, 102, 255, 0.2);
        }

        /* СИСТЕМА ЗВЕЗД */
        .rating-container { display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem; }
        .star-label { cursor: pointer; transition: 0.3s; position: relative; }
        .star-label i { font-size: 3rem; color: rgba(255, 255, 255, 0.1); transition: 0.3s; }

        /* Состояние активной звезды */
        .star-label.active i, .star-label:hover i {
            color: var(--neon-warning);
            text-shadow: 0 0 20px rgba(255, 209, 102, 0.6);
            transform: scale(1.1);
        }
        .star-label:active { transform: scale(0.9); }

        /* ТЕКСТОВОЕ ПОЛЕ */
        .input-label {
            color: var(--text-main); font-size: 0.9rem; font-weight: 800;
            text-transform: uppercase; margin-bottom: 0.75rem; display: block; letter-spacing: 0.1em;
        }
        .glass-textarea {
            background: rgba(0, 0, 0, 0.4); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 1.5rem; padding: 1.5rem; width: 100%;
            font-size: 1.1rem; line-height: 1.6; transition: 0.4s;
            resize: none; min-height: 180px;
        }
        .glass-textarea:focus {
            outline: none; border-color: var(--accent-purple);
            background: rgba(0, 0, 0, 0.6);
            box-shadow: 0 0 20px rgba(123, 44, 191, 0.2);
        }

        /* КНОПКИ */
        .btn-save-neon {
            background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-purple) 100%);
            color: #fff; border: none; border-radius: 99px; padding: 1rem 2rem;
            font-weight: 900; font-size: 1.1rem; text-transform: uppercase;
            width: 100%; transition: 0.4s; letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(0, 102, 255, 0.3);
        }
        .btn-save-neon:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(123, 44, 191, 0.5);
            filter: brightness(1.1);
        }

        .btn-cancel-glass {
            color: var(--text-muted); font-weight: 700; text-decoration: none;
            display: block; text-align: center; margin-top: 1.5rem; transition: 0.2s;
        }
        .btn-cancel-glass:hover { color: #fff; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="glass-panel">
            <h2 class="form-title">Редактирование отзыва</h2>
            <div class="service-info-badge">
                <i class="bi bi-tag-fill me-1"></i> <?php echo e($review->booking->service->title ?? 'Услуга'); ?>

            </div>

            <form action="<?php echo e(route('reviews.update', $review)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-5">
                    <label class="input-label text-center">Как вы оцениваете результат?</label>
                    <div class="rating-container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" name="rating" id="rating<?php echo e($i); ?>" value="<?php echo e($i); ?>" class="d-none" <?php echo e($review->rating == $i ? 'checked' : ''); ?> required>
                            <label class="star-label <?php echo e($review->rating >= $i ? 'active' : ''); ?>" for="rating<?php echo e($i); ?>" data-value="<?php echo e($i); ?>">
                                <i class="bi bi-star<?php echo e($review->rating >= $i ? '-fill' : ''); ?>"></i>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="comment" class="input-label">Ваши впечатления</label>
                    <textarea name="comment" id="comment" class="glass-textarea" placeholder="Расскажите подробнее о качестве услуги и работе мастера..." required minlength="10"><?php echo e(old('comment', $review->comment)); ?></textarea>
                    <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-triangle"></i> <?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="pt-3">
                    <button type="submit" class="btn-save-neon">
                        Обновить отзыв <i class="bi bi-check2-circle ms-2"></i>
                    </button>
                    <a href="<?php echo e(route('my-reviews')); ?>" class="btn-cancel-glass">Отменить изменения</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = document.querySelectorAll('.star-label');
            const inputs = document.querySelectorAll('input[name="rating"]');

            function updateStars(val) {
                labels.forEach(label => {
                    const labelVal = label.getAttribute('data-value');
                    const icon = label.querySelector('i');

                    if (labelVal <= val) {
                        label.classList.add('active');
                        icon.classList.replace('bi-star', 'bi-star-fill');
                    } else {
                        label.classList.remove('active');
                        icon.classList.replace('bi-star-fill', 'bi-star');
                    }
                });
            }

            // Обработка клика
            inputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    updateStars(e.target.value);
                });
            });

            // Эффект при наведении (для интерактивности)
            labels.forEach(label => {
                label.addEventListener('mouseenter', () => {
                    updateStars(label.getAttribute('data-value'));
                });
            });

            // Возврат к выбранному значению при уходе курсора
            document.querySelector('.rating-container').addEventListener('mouseleave', () => {
                const checkedInput = document.querySelector('input[name="rating"]:checked');
                updateStars(checkedInput ? checkedInput.value : 0);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/reviews/edit.blade.php ENDPATH**/ ?>