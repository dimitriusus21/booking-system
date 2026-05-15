@extends('layouts.app')

@section('title', 'Управление организациями')

@section('content')
    <style>
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --neon-success: #06d6a0;
            --neon-warning: #ffd166;
            --neon-danger: #ef476f;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 2rem; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .page-title { font-size: 2.2rem; font-weight: 800; color: #fff; margin: 0; display: flex; align-items: center; gap: 1rem; }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        .glass-panel { background: var(--glass-bg); backdrop-filter: blur(16px); border: 1px solid var(--glass-border); border-radius: 1.25rem; overflow: hidden; }

        .glass-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .glass-table th { color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; padding: 1.25rem 1rem; border-bottom: 1px solid var(--glass-border); font-weight: 600; }
        .glass-table td { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03); color: #fff; vertical-align: middle; }
        .glass-table tbody tr { transition: all 0.2s ease; }
        .glass-table tbody tr:hover { background: rgba(255, 255, 255, 0.03); }

        .neon-badge {
            padding: 0.35rem 0.85rem; border-radius: 99px; font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.05em; text-transform: uppercase; border: 1px solid var(--status-color);
            background: rgba(var(--status-rgb), 0.1); color: var(--status-color);
            box-shadow: inset 0 0 8px rgba(var(--status-rgb), 0.1); display: inline-flex; align-items: center; gap: 0.3rem;
        }
        .status-verified { --status-color: var(--neon-success); --status-rgb: 6, 214, 160; }
        .status-pending { --status-color: var(--neon-warning); --status-rgb: 255, 209, 102; }

        .btn-verify-glow {
            background: rgba(6, 214, 160, 0.1); color: var(--neon-success); border: 1px solid var(--neon-success);
            padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 600; transition: all 0.3s ease;
        }
        .btn-verify-glow:hover { background: var(--neon-success); color: #000; box-shadow: 0 0 15px rgba(6, 214, 160, 0.5); }

        .btn-delete-glow {
            background: transparent; color: var(--neon-danger); border: 1px solid rgba(239, 71, 111, 0.4);
            padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 600; transition: all 0.3s ease;
        }
        .btn-delete-glow:hover { background: rgba(239, 71, 111, 0.1); border-color: var(--neon-danger); box-shadow: 0 0 15px rgba(239, 71, 111, 0.3); }

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
            <h1 class="page-title"><i class="bi bi-buildings"></i> Организации</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill btn-sm" style="border-color: var(--glass-border);">
                <i class="bi bi-arrow-left me-1"></i> Назад
            </a>
        </div>

        <div class="glass-panel">
            <div class="table-responsive">
                <table class="glass-table">
                    <thead>
                    <tr>
                        <th style="width: 35%">Название</th>
                        <th>Владелец</th>
                        <th>Статус</th>
                        <th class="text-end">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($organizations as $org)
                        <tr>
                            <td>
                                <div class="fw-bold fs-6 mb-1">{{ $org->name }}</div>
                                <div style="color: var(--text-secondary); font-size: 0.8rem;"><i class="bi bi-geo-alt me-1"></i>{{ $org->address }}</div>
                            </td>
                            <td>
                                <div class="fw-medium mb-1">{{ $org->user->name }}</div>
                                <div style="color: var(--text-secondary); font-size: 0.8rem;">{{ $org->user->email }}</div>
                            </td>
                            <td>
                                @if($org->is_verified)
                                    <span class="neon-badge status-verified"><i class="bi bi-check-circle"></i> Верифицирована</span>
                                @else
                                    <span class="neon-badge status-pending"><i class="bi bi-clock"></i> Ожидает</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    @if(!$org->is_verified)
                                        <form action="{{ route('admin.organizations.verify', $org) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn-verify-glow"><i class="bi bi-check-lg"></i> Подтвердить</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.organizations.delete', $org) }}" method="POST" onsubmit="return confirm('Организация будет удалена, а владелец станет обычным клиентом. Продолжить?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-delete-glow"><i class="bi bi-trash"></i> Удалить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($organizations->hasPages())
            <div class="custom-pagination-container">
                <div class="pagination-info">Показаны записи с <b>{{ $organizations->firstItem() }}</b> по <b>{{ $organizations->lastItem() }}</b> из <b>{{ $organizations->total() }}</b></div>
                <ul class="custom-pagination">
                    <li class="page-item {{ $organizations->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $organizations->previousPageUrl() ?? '#' }}"><i class="bi bi-chevron-left me-1"></i> Назад</a>
                    </li>
                    @foreach ($organizations->getUrlRange(max(1, $organizations->currentPage() - 2), min($organizations->lastPage(), $organizations->currentPage() + 2)) as $page => $url)
                        <li class="page-item {{ $page == $organizations->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ !$organizations->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $organizations->nextPageUrl() ?? '#' }}">Дальше <i class="bi bi-chevron-right ms-1"></i></a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
@endsection
