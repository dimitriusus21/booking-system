@extends('layouts.app')

@section('title', 'Оставить отзыв')

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - PREMIUM REVIEW CREATION
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
            --neon-success: #06d6a0;
        }

        .dark-page-wrapper {
            position: relative;
            min-height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        /* Атмосферный фон */
        .ambient-glow {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 90%; height: 700px;
            background: radial-gradient(circle, rgba(0, 102, 255, 0.1) 0%, transparent 70%);
            pointer-events: none; z-index: -1; filter: blur(60px);
        }

        /* Главная панель */
        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(35px);
            border: 1px solid var(--glass-border); border-radius: 2.5rem;
            padding: 3.5rem; width: 100%; max-width: 650px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
            animation: fadeUp 0.7s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative; overflow: hidden;
        }

        .glass-panel::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-purple));
        }

        .form-title { font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 2rem; text-align: center; }

        /* Карточка услуги (Badge) */
        .service-info-card {
            background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem; padding: 1.5rem; margin-bottom: 3rem;
            display: flex; align-items: center; gap: 1.5rem;
        }
        .service-icon-box {
            width: 50px; height: 50px; background: rgba(0, 102, 255, 0.15);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            color: var(--accent-primary); font-size: 1.5rem;
        }
        .service-label { font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.2rem; }
        .service-name { font-size: 1.1rem; font-weight: 800; color: #fff; margin: 0; }

        /* СИСТЕМА ЗВЕЗД */
        .rating-wrapper { text-align: center; margin-bottom: 3rem; }
        .rating-label { color: var(--text-main); font-size: 1rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem; display: block; }

        .stars-container { display: flex; justify-content: center; gap: 1rem; }
        .star-item { cursor: pointer; transition: 0.3s; }
        .star-item i { font-size: 3.2rem; color: rgba(255, 255, 255, 0.05); transition: all 0.3s ease; }

        /* Интерактивные состояния */
        .star-item.active i, .star-item:hover i {
            color: var(--neon-warning);
            text-shadow: 0 0 25px rgba(255, 209, 102, 0.6);
            transform: scale(1.15);
        }
        .star-item:active { transform: scale(0.9); }

        /* ПОЛЕ КОММЕНТАРИЯ */
        .input-group-custom { margin-bottom: 2.5rem; }
        .input-label-custom { color: var(--text-main); font-size: 0.9rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.75rem; display: block; }

        .glass-textarea {
            background: rgba(0, 0, 0, 0.4); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 1.5rem; padding: 1.5rem; width: 100%;
            font-size: 1.1rem; line-height: 1.6; transition: 0.4s;
            resize: none; min-height: 160px;
        }
        .glass-textarea:focus {
            outline: none; border-color: var(--accent-primary);
            background: rgba(0, 0, 0, 0.6);
            box-shadow: 0 0 25px rgba(0, 102, 255, 0.2);
        }
        .glass-textarea::placeholder { color: var(--text-muted); }

        /* КНОПКИ */
        .btn-submit-neon {
            background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-purple) 100%);
            color: #fff !important; border: none; border-radius: 99px; padding: 1.1rem 2rem;
            font-weight: 900; font-size: 1.1rem; text-transform: uppercase;
            width: 100%; transition: 0.4s; letter-spacing: 1.5px;
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
        }
        .btn-submit-neon:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(123, 44, 191, 0.6);
            filter: brightness(1.1);
        }

        .btn-cancel-link {
            color: var(--text-muted); font-weight: 700; text-decoration: none;
            display: block; text-align: center; margin-top: 1.5rem; transition: 0.3s;
            font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;
        }
        .btn-cancel-link:hover { color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.3); }

        /* Ошибки валидации */
        .error-message { color: var(--neon-danger); font-size: 0.85rem; font-weight: 700; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.4rem; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper">
        <div class="ambient-glow"></div>

        <div class="glass-panel">
            <h2 class="form-title">Поделитесь вашим мнением</h2>

            <div class="service-info-card">
                <div class="service-icon-box">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <div>
                    <div class="service-label">Оценка услуги:</div>
                    <h5 class="service-name">{{ $booking->service->title }}</h5>
                    <div class="small" style="color: var(--accent-primary); font-weight: 700;">{{ $booking->service->organization->name }}</div>
                </div>
            </div>

            <form action="{{ route('reviews.store', $booking) }}" method="POST">
                @csrf

                <div class="rating-wrapper">
                    <label class="rating-label">Как всё прошло?</label>
                    <div class="stars-container">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="d-none" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label class="star-item {{ old('rating') >= $i ? 'active' : '' }}" for="rating{{ $i }}" data-value="{{ $i }}">
                                <i class="bi bi-star{{ old('rating') >= $i ? '-fill' : '' }}" id="star{{ $i }}"></i>
                            </label>
                        @endfor
                    </div>
                    @error('rating') <div class="error-message justify-content-center"><i class="bi bi-exclamation-circle"></i> Пожалуйста, выберите оценку</div> @enderror
                </div>

                <div class="input-group-custom">
                    <label for="comment" class="input-label-custom">Ваш комментарий</label>
                    <textarea name="comment" id="comment" class="glass-textarea"
                              placeholder="Что вам особенно понравилось? Посоветуете ли вы этого мастера другим?"
                              required minlength="10">{{ old('comment') }}</textarea>
                    <div class="d-flex justify-content-between mt-2 px-1">
                        <span style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700;">МИНИМУМ 10 СИМВОЛОВ</span>
                        @error('comment') <span class="error-message m-0"><i class="bi bi-exclamation-triangle"></i> Текст слишком короткий</span> @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-submit-neon">
                        Опубликовать отзыв <i class="bi bi-send-fill ms-2"></i>
                    </button>
                    <a href="{{ route('my-bookings') }}" class="btn-cancel-link">Вернуться назад</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starItems = document.querySelectorAll('.star-item');
            const inputs = document.querySelectorAll('input[name="rating"]');

            function updateStars(val) {
                starItems.forEach(item => {
                    const itemVal = item.getAttribute('data-value');
                    const icon = item.querySelector('i');

                    if (itemVal <= val) {
                        item.classList.add('active');
                        icon.classList.replace('bi-star', 'bi-star-fill');
                    } else {
                        item.classList.remove('active');
                        icon.classList.replace('bi-star-fill', 'bi-star');
                    }
                });
            }

            // Клик по звезде
            inputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    updateStars(e.target.value);
                });
            });

            // Наведение (Hover)
            starItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    updateStars(item.getAttribute('data-value'));
                });
            });

            // Уход курсора (возврат к выбранному значению)
            document.querySelector('.stars-container').addEventListener('mouseleave', () => {
                const checkedInput = document.querySelector('input[name="rating"]:checked');
                updateStars(checkedInput ? checkedInput.value : 0);
            });

            // Если страница загрузилась с ошибкой и есть старое значение
            const initialChecked = document.querySelector('input[name="rating"]:checked');
            if (initialChecked) updateStars(initialChecked.value);
        });
    </script>
@endsection
