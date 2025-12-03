@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')

<style>
    .log-table tbody tr:hover {
        background: #f8fafc !important;
        transition: .25s ease;
        cursor: default;
    }

    /* Tabel tanpa garis vertikal */
    .table td,
    .table th {
        border: none !important;
        vertical-align: middle;
    }

    .table tbody tr {
        border-bottom: 1px solid #e2e8f0 !important;
    }

    .table thead tr {
        border-bottom: 2px solid #cbd5e1 !important;
    }

    /* Role Badge */
    .badge-role {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 6px;
        letter-spacing: .4px;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Avatar */
    .user-avatar-sm {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 10px;
        text-transform: uppercase;
        color: white;
        flex-shrink: 0;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    .avatar-admin { background: #dc2626; }
    .avatar-wakasek { background: #2563eb; }
    .avatar-kabeng { background: #16a34a; }

    /* Card */
    .log-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    .table thead th {
        font-size: 12.5px;
        text-transform: uppercase;
        letter-spacing: .6px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
        padding: 14px 16px;
    }

    .table tbody td {
        padding: 14px 16px;
    }

    .log-card .card-body {
        padding: 0;
    }

    /* Header Halaman */
    .page-header {
        gap: 10px;
    }

    .page-header h4 {
        font-weight: 700;
        color: #1e293b;
    }

    .page-header .counter {
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        color: #64748b;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .user-avatar-sm {
            width: 30px;
            height: 30px;
            font-size: 12px;
            margin-right: 8px;
        }

        .table thead th,
        .table tbody td {
            padding: 12px 10px;
        }

        .time-cell {
            min-width: 120px;
            font-size: 12px;
            white-space: nowrap;
        }

        .badge-role {
            font-size: 10px;
            padding: 3px 7px;
        }

        td span {
            display: inline-block;
            max-width: 200px;
            word-wrap: break-word;
        }
    }
</style>

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap page-header">
        <h4 class="d-flex align-items-center gap-2 m-0">
            <i class="bi bi-activity text-primary fs-4"></i>
            Log Aktivitas
        </h4>
        <span class="counter">
            <i class="bi bi-list-check me-1"></i> {{ $logs->total() }} aktivitas
        </span>
    </div>

    {{-- CARD CONTENT --}}
    <div class="card log-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table log-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="min-width: 170px;">User</th>
                            <th style="min-width: 100px;">Role</th>
                            <th style="min-width: 200px;">Aksi</th>
                            <th style="min-width: 130px;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            @php
                                $avatarClass = match($log->role) {
                                    'admin' => 'avatar-admin',
                                    'wakasek' => 'avatar-wakasek',
                                    'kabeng' => 'avatar-kabeng',
                                    default => 'bg-gray-500'
                                };

                                $badgeClass = match($log->role) {
                                    'admin' => 'danger',
                                    'wakasek' => 'primary',
                                    'kabeng' => 'success',
                                    default => 'secondary'
                                };
                            @endphp

                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="user-avatar-sm {{ $avatarClass }}">
                                        {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong class="d-block">{{ $log->user->name ?? '-' }}</strong>
                                        <small class="text-muted">{{ $log->user->email ?? '' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $badgeClass }} badge-role">
                                        {{ ucfirst($log->role) }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-journal-text text-muted me-1"></i>
                                    <span>{{ $log->aksi }}</span>
                                </td>
                                <td class="text-muted time-cell">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $log->created_at->translatedFormat('d M Y, H:i') }}
                                    <div class="d-md-none small mt-1">
                                        ({{ $log->created_at->diffForHumans() }})
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                    <span>Tidak ada aktivitas yang terekam.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection