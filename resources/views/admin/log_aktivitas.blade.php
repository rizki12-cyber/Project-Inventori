@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')

<style>
    /* Hover row */
    .log-table tbody tr:hover {
        background: #f1f5f9 !important;
        transition: .25s ease;
    }

    /* Badge role */
    .badge-role {
        font-size: 11px;
        padding: 5px 9px;
        border-radius: 6px;
        letter-spacing: .3px;
    }

    /* Avatar dasar */
    .user-avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 10px;
        text-transform: uppercase;
        color: white;
    }

    /* Avatar warna sesuai role */
    .avatar-admin {
        background: #dc2626 !important;   /* merah */
        color: #fff !important;
    }

    .avatar-wakasek {
        background: #2563eb !important;   /* biru */
        color: #fff !important;
    }

    .avatar-kabeng {
        background: #16a34a !important;   /* hijau */
        color: #fff !important;
    }

    /* Card */
    .log-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Table header */
    .table thead th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    /* =======================================
        RESPONSIVE MOBILE FIX
    ======================================== */
    @media(max-width: 768px) {
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            margin-right: 8px;
            font-size: 14px;
        }

        td strong {
            font-size: 14px;
        }

        td small {
            font-size: 12px;
        }

        .badge-role {
            font-size: 10px;
            padding: 4px 8px;
        }
    }
</style>

<div class="container py-3">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h4 class="fw-bold m-0 d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-activity text-primary fs-4"></i>
            Log Aktivitas
        </h4>

        <span class="text-muted small mb-2">
            <i class="bi bi-list-check"></i> {{ $logs->total() }} aktivitas terekam
        </span>
    </div>

    <div class="card shadow-sm log-card">

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover log-table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 250px;">User</th>
                            <th style="width: 130px;">Role</th>
                            <th>Aksi</th>
                            <th style="width: 160px;">Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                            @php
                                $avatarColor = [
                                    'admin'   => 'avatar-admin',
                                    'wakasek' => 'avatar-wakasek',
                                    'kabeng'  => 'avatar-kabeng',
                                ];
                            @endphp

                            <tr>
                                <td class="d-flex align-items-center">

                                    {{-- Avatar sesuai role --}}
                                    <div class="user-avatar-sm {{ $avatarColor[$log->role] ?? '' }}">
                                        {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong class="d-block">{{ $log->user->name ?? '-' }}</strong>
                                        <small class="text-muted">{{ $log->user->email ?? '' }}</small>
                                    </div>
                                </td>

                                <td>
                                    @php
                                        $roleColor = [
                                            'admin' => 'danger',
                                            'wakasek' => 'primary',
                                            'kabeng' => 'success',
                                        ];
                                    @endphp

                                    <span class="badge bg-{{ $roleColor[$log->role] ?? 'secondary' }} badge-role">
                                        {{ strtoupper($log->role) }}
                                    </span>
                                </td>

                                <td>
                                    <i class="bi bi-chevron-right text-secondary me-1"></i>
                                    <span>{{ $log->aksi }}</span>
                                </td>

                                <td class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Tidak ada aktivitas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
