@extends('layouts.app')

@section('title', 'Управление категориями')

@section('content')
    <style>
        :root {
            --glass-bg: rgba(20, 20, 30, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-hover: rgba(255, 255, 255, 0.12);
            --text-secondary: #a0a0b8;
            --accent-primary: #0066ff;
            --neon-danger: #ef476f;
        }

        .dark-page-wrapper { position: relative; padding-bottom: 2rem; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .page-title { font-size: 2.2rem; font-weight: 800; color: #fff; margin: 0; display: flex; align-items: center; gap: 1rem; }
        .page-title i { color: var(--accent-primary); text-shadow: 0 0 15px rgba(0, 102, 255, 0.4); }

        .glass-panel {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); border-radius: 1.25rem;
            padding: 1.5rem;
        }

        /* Тёмные инпуты */
        .glass-input {
            background: rgba(0, 0, 0, 0.3); border: 1px solid var(--glass-border);
            color: #fff; border-radius: 0.75rem; padding: 0.75rem 1rem; width: 100%;
            transition: all 0.3s ease;
        }
        .glass-input:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 15px rgba(0, 102, 255, 0.3); }
        .glass-input::placeholder { color: #6b6b80; }

        /* Кнопка создания */
        .btn-create-glow {
            width: 100%; padding: 0.75rem; background: linear-gradient(135deg, var(--accent-primary) 0%, #0052cc 100%);
            color: #fff; font-weight: 600; border-radius: 99px; border: none;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.3); transition: all 0.3s ease;
        }
        .btn-create-glow:hover { transform: translateY(-2px); box-shadow: 0 0 25px rgba(0, 102, 255, 0.5); }

        /* Стеклянная таблица */
        .glass-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .glass-table th {
            color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem;
            padding: 1rem; border-bottom: 1px solid var(--glass-border); font-weight: 600;
        }
        .glass-table td { padding: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03); color: #fff; vertical-align: middle; }
        .glass-table tbody tr { transition: all 0.2s ease; }
        .glass-table tbody tr:hover { background: rgba(255, 255, 255, 0.02); }
        .glass-table tbody tr:last-child td { border-bottom: none; }

        /* Кнопка удаления */
        .btn-icon-danger {
            background: transparent; color: var(--neon-danger); border: 1px solid transparent;
            width: 36px; height: 36px; border-radius: 50%; display: inline-flex;
            align-items: center; justify-content: center; transition: all 0.3s ease;
        }
        .btn-icon-danger:hover {
            background: rgba(239, 71, 111, 0.1); border-color: var(--neon-danger);
            box-shadow: 0 0 15px rgba(239, 71, 111, 0.3); transform: scale(1.1);
        }
    </style>

    <div class="dark-page-wrapper">
        <div class="page-header">
            <h1 class="page-title"><i class="bi bi-tags"></i> Категории услуг</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill btn-sm" style="border-color: var(--glass-border);">
                <i class="bi bi-arrow-left me-1"></i> Назад
            </a>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-panel">
                    <h5 class="fw-bold mb-4" style="color: #fff;">Добавить категорию</h5>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="name" class="glass-input" placeholder="Название (например, Красота)" required>
                        </div>
                        <button type="submit" class="btn-create-glow">Создать категорию</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="glass-panel" style="padding: 0.5rem 1.5rem;">
                    <div class="table-responsive">
                        <table class="glass-table">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Кол-во услуг</th>
                                <th class="text-end">Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $cat)
                                <tr>
                                    <td class="fw-bold">{{ $cat->name }}</td>
                                    <td><span class="badge bg-secondary rounded-pill" style="background: rgba(255,255,255,0.1)!important;">{{ $cat->services_count }}</span></td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.categories.delete', $cat) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту категорию?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-icon-danger" title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
