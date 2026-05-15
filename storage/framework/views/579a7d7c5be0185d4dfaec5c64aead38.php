<?php $__env->startSection('title', 'Вход'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DARK NEON UI - AUTH PAGES
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-danger: #ef476f;
        }

        /* Центрирование формы на весь экран */
        .auth-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 160px);
            position: relative;
        }

        /* Фоновое свечение */
        .ambient-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 800px;
            height: 500px;
            background: radial-gradient(circle at 50% 50%, rgba(0, 102, 255, 0.15) 0%, rgba(123, 44, 191, 0.05) 40%, transparent 70%);
            pointer-events: none;
            z-index: -1;
            filter: blur(40px);
            animation: pulseGlow 6s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.6; transform: translate(-50%, -50%) scale(0.95); }
            100% { opacity: 1; transform: translate(-50%, -50%) scale(1.05); }
        }

        /* Стеклянная карточка */
        .glass-auth-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            position: relative;
            overflow: hidden;
        }

        /* Декоративная линия сверху */
        .glass-auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-purple));
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.5);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .auth-title i {
            color: var(--accent-primary);
            text-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
        }

        /* Инпуты */
        .form-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .glass-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--glass-border);
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .glass-input:focus {
            outline: none;
            background: rgba(0, 0, 0, 0.5);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1), inset 0 0 10px rgba(0, 102, 255, 0.1);
        }

        .glass-input.is-invalid {
            border-color: var(--neon-danger);
            box-shadow: 0 0 0 4px rgba(239, 71, 111, 0.1);
        }

        .invalid-feedback {
            color: var(--neon-danger);
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        /* Кнопка */
        .btn-auth-glow {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 99px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
            cursor: pointer;
        }

        .btn-auth-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 102, 255, 0.5);
            color: #fff;
        }

        /* Подвал формы */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--glass-border);
        }

        .auth-link {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .auth-link:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 102, 255, 0.5);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="auth-wrapper">
        <div class="ambient-glow"></div>

        <div class="glass-auth-card">
            <div class="auth-header">
                <h4 class="auth-title">
                    <i class="bi bi-box-arrow-in-right"></i>
                    С возвращением
                </h4>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">
                    Войдите в свой аккаунт для продолжения
                </p>
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label for="email" class="form-label">Email адрес</label>
                    <input type="email" class="glass-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="email" value="<?php echo e(old('email')); ?>" placeholder="name@example.com" required autofocus>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="glass-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="password" placeholder="••••••••" required>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn-auth-glow">
                    <i class="bi bi-shield-lock"></i> Войти в систему
                </button>
            </form>

            <div class="auth-footer">
                <span style="color: var(--text-secondary);">Нет аккаунта?</span>
                <a href="<?php echo e(route('register')); ?>" class="auth-link ms-1">Зарегистрироваться</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/auth/login.blade.php ENDPATH**/ ?>