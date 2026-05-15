@extends('layouts.app')

@section('title', $organization->name)

@section('content')
    <style>
        /* ============================================
           DARK NEON UI - PREMIUM ORGANIZATION PROFILE
           ============================================ */
        :root {
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #ffffff;
            --text-description: #e2e8f0; /* Яркий светло-серый */
            --text-muted: #cbd5e1;       /* Сделал намного светлее для подписей */

            --accent-primary: #0066ff;
            --accent-purple: #7b2cbf;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
            --neon-info: #00d2ff;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 5rem; }

        /* Фоновое свечение */
        .ambient-glow-1 {
            position: absolute; top: -100px; left: -10%; width: 50%; height: 600px;
            background: radial-gradient(circle, rgba(0, 102, 255, 0.12) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }
        .ambient-glow-2 {
            position: absolute; bottom: 0; right: -10%; width: 40%; height: 500px;
            background: radial-gradient(circle, rgba(123, 44, 191, 0.1) 0%, transparent 70%);
            pointer-events: none; z-index: -1;
        }

        /* Левая панель профиля */
        .profile-sidebar {
            background: var(--glass-bg); backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border); border-radius: 2rem;
            padding: 2.5rem; position: sticky; top: 100px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            animation: fadeLeft 0.6s ease-out;
        }

        .org-avatar-big {
            width: 100px; height: 100px; background: linear-gradient(135deg, var(--accent-primary), var(--accent-purple));
            border-radius: 2rem; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; box-shadow: 0 10px 30px rgba(0, 102, 255, 0.3);
            color: #fff; font-size: 3rem;
        }

        .rating-giant { font-size: 3.5rem; font-weight: 900; line-height: 1; color: #fff; }

        /* Гистограмма рейтинга */
        .rating-bar-container { height: 8px; background: rgba(255,255,255,0.05); border-radius: 99px; overflow: hidden; }
        .rating-bar-fill { height: 100%; background: var(--neon-warning); box-shadow: 0 0 10px var(--neon-warning); border-radius: 99px; }

        /* ЧИТАЕМЫЙ ТЕКСТ ПОДПИСЕЙ */
        .rating-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem; color: var(--text-description); font-size: 0.85rem; font-weight: 500; }
        .text-bright-muted { color: var(--text-muted) !important; font-weight: 500; }

        /* Контакты */
        .contact-item {
            display: flex; align-items: center; gap: 1rem; padding: 1rem;
            background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);
            border-radius: 1.25rem; margin-bottom: 0.75rem; transition: 0.3s;
            color: var(--text-description); text-decoration: none;
        }
        .contact-item:hover { background: rgba(255,255,255,0.08); border-color: var(--accent-primary); color: #fff; transform: translateX(5px); }
        .contact-item i { font-size: 1.2rem; color: var(--accent-primary); }

        /* Основной контент (Услуги) */
        .section-card {
            background: var(--glass-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); border-radius: 2rem;
            padding: 2.5rem; margin-bottom: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: fadeUp 0.6s ease-out both;
        }
        .section-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem; }
        .section-header i { font-size: 1.8rem; color: var(--accent-primary); }
        .section-title { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }

        .service-smart-card {
            background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.5rem; padding: 1.5rem; transition: 0.4s; height: 100%;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .service-smart-card:hover { border-color: var(--accent-primary); background: rgba(0, 102, 255, 0.05); transform: translateY(-5px); }

        .service-price { font-size: 1.6rem; font-weight: 900; color: var(--neon-success); text-shadow: 0 0 15px rgba(6, 214, 160, 0.2); }
        .service-duration { background: rgba(255,255,255,0.08); color: #fff; padding: 0.4rem 0.8rem; border-radius: 10px; font-size: 0.85rem; font-weight: 800; border: 1px solid rgba(255,255,255,0.1); }

        .btn-booking {
            background: var(--accent-primary); color: #fff; border: none;
            border-radius: 99px; padding: 0.6rem 1.5rem; font-weight: 800;
            transition: 0.3s; box-shadow: 0 5px 15px rgba(0, 102, 255, 0.3);
            text-decoration: none; display: inline-block; text-align: center;
        }
        .btn-booking:hover { transform: scale(1.05); box-shadow: 0 8px 25px rgba(0, 102, 255, 0.5); color: #fff; }

        /* Отзывы */
        .review-item { padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .review-item:last-child { border-bottom: none; }
        .verified-badge { background: rgba(6, 214, 160, 0.1); color: var(--neon-success); font-size: 0.7rem; font-weight: 800; padding: 0.25rem 0.75rem; border-radius: 99px; border: 1px solid rgba(6, 214, 160, 0.3); }

        .reply-accent-box {
            background: rgba(255,255,255,0.02); border-left: 3px solid var(--accent-primary);
            padding: 1.25rem 1.5rem; border-radius: 0.5rem 1.25rem 1.25rem 0.5rem; margin-top: 1rem;
        }

        @keyframes fadeLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="dark-page-wrapper container py-5">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>

        <div class="row g-5">
            <div class="col-lg-4">
                <div class="profile-sidebar">
                    <div class="text-center">
                        <div class="org-avatar-big">
                            <i class="bi bi-building"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-2">{{ $organization->name }}</h2>
                        <span class="badge bg-primary bg-opacity-20 text-white rounded-pill px-3 py-2 border border-primary border-opacity-50">
                            {{ $organization->category->name ?? 'Услуги' }}
                        </span>
                    </div>

                    <div class="my-5 text-center">
                        <div class="rating-giant">{{ number_format($organization->average_rating, 1) }}</div>
                        <div class="text-warning fs-4 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                {!! $i <= round($organization->average_rating) ? '★' : '<span style="opacity: 0.2">☆</span>' !!}
                            @endfor
                        </div>
                        <p class="text-bright-muted small mb-4">На основе {{ $organization->reviews_count }} мнений</p>

                        <div class="mt-4">
                            @php
                                $allReviews = $organization->reviews;
                                $totalReviews = $allReviews->count();
                            @endphp

                            @if($totalReviews > 0)
                                @for($stars = 5; $stars >= 1; $stars--)
                                    @php
                                        $count = $allReviews->where('rating', $stars)->count();
                                        $percent = ($count / $totalReviews) * 100;
                                    @endphp
                                    <div class="rating-row">
                                        <span style="min-width: 25px; color: #fff;">{{ $stars }} <i class="bi bi-star-fill" style="font-size: 0.7rem;"></i></span>
                                        <div class="progress-container flex-grow-1">
                                            <div class="rating-bar-container">
                                                <div class="rating-bar-fill" style="width: {{ $percent }}%"></div>
                                            </div>
                                        </div>
                                        <span style="min-width: 20px; color: #fff;" class="text-end">{{ $count }}</span>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>

                    <div class="contact-box mt-5">
                        <h6 class="text-uppercase fw-bold text-white small mb-3 letter-spacing-1">Контакты</h6>
                        <div class="contact-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span class="fw-bold">{{ $organization->address ?? 'Адрес не указан' }}</span>
                        </div>
                        <a href="tel:{{ $organization->phone }}" class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <span class="fw-bold">{{ $organization->phone ?? 'Связь не указана' }}</span>
                        </a>
                        <a href="mailto:{{ $organization->email }}" class="contact-item">
                            <i class="bi bi-envelope-fill"></i>
                            <span class="fw-bold">{{ $organization->email ?? 'Email не указан' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="section-card">
                    <div class="section-header">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        <h4 class="section-title">Доступные услуги</h4>
                    </div>

                    @if($services->count() > 0)
                        <div class="row g-4">
                            @foreach($services as $service)
                                <div class="col-12">
                                    <div class="service-smart-card">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="pe-3">
                                                <h5 class="fw-bold text-white mb-2">{{ $service->title }}</h5>
                                                <p style="color: var(--text-description); line-height: 1.6;" class="small mb-0">{{ Str::limit($service->description, 180) }}</p>
                                            </div>
                                            <div class="text-end flex-shrink-0">
                                                <div class="service-price">{{ number_format($service->price, 0, '', ' ') }} ₽</div>
                                                <span class="service-duration"><i class="bi bi-clock me-1"></i> {{ $service->duration }} мин</span>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-top border-white border-opacity-10 d-flex justify-content-end">
                                            <a href="{{ route('services.show', $service) }}" class="btn-booking px-5">Выбрать время</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="section-card">
                    <div class="section-header">
                        <i class="bi bi-chat-heart-fill" style="color: var(--neon-warning);"></i>
                        <h4 class="section-title">Отзывы клиентов</h4>
                    </div>

                    @php $orgReviews = $organization->reviews()->with(['client', 'booking.service'])->latest()->get(); @endphp

                    @if($orgReviews->count() > 0)
                        <div class="reviews-list">
                            @foreach($orgReviews as $review)
                                <div class="review-item">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="fw-bold text-white fs-5">{{ $review->client->name ?? 'Пользователь' }}</div>
                                            <span class="verified-badge"><i class="bi bi-patch-check-fill me-1"></i> Визит подтвержден</span>
                                        </div>
                                        <div class="text-bright-muted fw-bold">{{ $review->created_at->format('d.m.Y') }}</div>
                                    </div>

                                    <div class="mb-3 d-flex align-items-center gap-3">
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                {!! $i <= $review->rating ? '★' : '<span style="opacity: 0.2">☆</span>' !!}
                                            @endfor
                                        </div>
                                        <div class="badge bg-white bg-opacity-10 text-white fw-bold px-3 py-2">Услуга: {{ $review->booking->service->title ?? 'Удалена' }}</div>
                                    </div>

                                    <p style="color: var(--text-description); font-size: 1.05rem;" class="mb-0">«{{ $review->comment }}»</p>

                                    @if($review->reply)
                                        <div class="reply-accent-box">
                                            <div class="fw-bold small text-info text-uppercase mb-2" style="letter-spacing: 1px;"><i class="bi bi-reply-fill me-1"></i> Ответ организации:</div>
                                            <p class="mb-0 text-white fw-bold">{{ $review->reply }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
