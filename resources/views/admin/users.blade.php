@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
    <style>
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --neon-danger: #ef476f;
            --neon-info: #00d2ff;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 2rem; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .page-title { font-size: 2.2rem; font-weight: 800; color: #fff; margin: 0; display: flex; align-items: center; gap: 1rem; }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        .total-badge {
            background: rgba(0, 102, 255, 0.15); border: 1px solid rgba(0, 102, 255, 0.3);
            color: #fff; padding: 0.5rem 1rem; border-radius: 99px; font-weight: 600;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.2);
        }

        .glass-panel { background: var(--glass-bg); backdrop-filter: blur(16px); border: 1px solid var(--glass-border); border-radius: 1.25rem; overflow: hidden; }

        .glass-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .glass-table th { color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; padding: 1.25rem 1rem; border-bottom: 1px solid var(--glass-border); font-weight: 600; }
        .glass-table td { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03); color: #fff; vertical-align: middle; }
        .glass-table tbody tr { transition: all 0.2s ease; }
        .glass-table tbody tr:hover { background: rgba(255, 255, 255, 0.03); }

        /* Роли */
        .role-badge { padding: 0.3rem 0.75rem; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; border: 1px solid transparent; }
        .role-admin { background: rgba(239, 71, 111, 0.15); color: var(--neon-danger); border-color: rgba(239, 71, 111, 0.3); box-shadow: inset 0 0 10px rgba(239, 71, 111, 0.2); }
        .role-org { background: rgba(0, 210, 255, 0.15); color: var(--neon-info); border-color: rgba(0, 210, 255, 0.3); box-shadow: inset 0 0 10px rgba(0, 210, 255, 0.2); }
        .role-client { background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border-color: var(--glass-border); }

        .btn-icon-danger {
            background: transparent; color: var(--neon-danger); border: 1px solid transparent;
            width: 36px; height: 36px; border-radius: 50%; display: inline-flex;
            align-items: center; justify-content: center; transition: all 0.3s ease;
        }
        .btn-icon-danger:hover { background: rgba(239, 71, 111, 0.1); border-color: var(--neon-danger); box-shadow: 0 0 15px rgba(239, 71, 111, 0.3); transform: scale(1.1); }

        /* ИДЕАЛЬНАЯ РУССКАЯ ПАГИНАЦИЯ */
        .custom-pagination-container { margin-top: 2.5rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; }
        .pagination-info { color: var(--text-secondary); font-size: 0.875rem; }
        .pagination-info b { color: #fff; }
        .custom-pagination { display: flex; gap: 0.5rem; list-style: none; padding: 0; margin: 0; }
        .custom-pagination .page-link { background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-secondary); border-radius: 0.5rem; padding: 0.5rem 1rem; text-decoration: none; transition: all 0.2s; }
        .custom-pagination .page-item:not(.disabled):not(.active) .page-link:hover { background: rgba(255, 255, 255, 0.1); color: #fff; }
        .custom-pagination .page-item.active .page-link { background: var(--accent-primary); border-color: var(--accent-primary); color: #fff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.4); pointer-events: none; }
        .custom-pagination .page-item.disabled .page-link { background: rgba(0, 0, 0, 0.2); color: rgba(255, 255, 255, 0.2); pointer-events: none; }
    </style>

    <div class="dark-page-wrapper">
        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-people"></i> Пользователи</h1>
            <div class="d-flex gap-3 align-items-center">
                <span class="total-badge">Всего: {{ $users->total() }}</span>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill btn-sm" style="border-color: var(--glass-border);">
                    <i class="bi bi-arrow-left me-1"></i> Назад
                </a>
            </div>
        </div>

        <div class="glass-panel">
            <div class="table-responsive">
                <table class="glass-table">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Регистрация</th>
                        <th class="text-end">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="fw-bold">{{ $user->name }}</td>
                            <td style="color: var(--text-secondary);">{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="role-badge role-admin"><i class="bi bi-shield-lock me-1"></i> Admin</span>
                                @elseif($user->isOrganization())
                                    <span class="role-badge role-org"><i class="bi bi-building me-1"></i> Org</span>
                                @else
                                    <span class="role-badge role-client"><i class="bi bi-person me-1"></i> Client</span>
                                @endif
                            </td>
                            <td style="color: var(--text-secondary); font-size: 0.9rem;">{{ $user->created_at->format('d.m.Y') }}</td>
                            <td class="text-end">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Удалить пользователя навсегда?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon-danger" title="Удалить"><i class="bi bi-trash"></i></button>
                                    </form>
                                @else
                                    <span style="color: var(--text-secondary); font-size: 0.8rem;">Вы</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($users->hasPages())
            <div class="custom-pagination-container">
                <div class="pagination-info">Показаны записи с <b>{{ $users->firstItem() }}</b> по <b>{{ $users->lastItem() }}</b> из <b>{{ $users->total() }}</b></div>
                <ul class="custom-pagination">
                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}"><i class="bi bi-chevron-left me-1"></i> Назад</a>
                    </li>
                    @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                        <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}">Дальше <i class="bi bi-chevron-right ms-1"></i></a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
@endsection
