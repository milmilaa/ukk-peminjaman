@extends('layouts.app')

@section('title','Notifikasi Saya')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-left: 5px solid #3b4bff;
        padding-left: 15px;
    }
    .page-title h1 { font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; }
    .page-title span { font-size: 13px; color: #64748b; }

    .notif-wrapper { display: flex; flex-direction: column; gap: 12px; }
    .notif-card {
        display: flex; align-items: center; gap: 15px;
        background: #ffffff; padding: 18px; border-radius: 16px;
        border: 1px solid #e2e8f0; transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        position: relative;
    }
    /* Style untuk notif yang belum dibaca */
    .notif-unread {
        background: #f8faff;
        border-left: 4px solid #3b4bff;
    }
    .notif-card:hover {
        border-color: #3b4bff;
        background: #fcfdff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 75, 255, 0.08);
    }

    .notif-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: #3b4bff; background: #f0f2ff;
        flex-shrink: 0;
    }

    .notif-content { flex: 1; }
    .notif-info { font-size: 14px; font-weight: 700; color: #334155; display: flex; align-items: center; gap: 10px; }
    .notif-desc { font-size: 13.5px; color: #475569; margin-top: 4px; line-height: 1.5; }
    .notif-meta { font-size: 11px; color: #94a3b8; margin-top: 10px; display: flex; align-items: center; gap: 8px; }

    .badge-role {
        font-size: 10px; background: #e0e7ff; color: #3b4bff;
        padding: 3px 10px; border-radius: 6px; text-transform: uppercase;
        font-weight: 700;
    }

    .btn-read-all {
        background: #f1f5f9; color: #475569; border: none;
        padding: 8px 16px; border-radius: 10px; font-size: 13px;
        font-weight: 600; cursor: pointer; transition: 0.2s;
    }
    .btn-read-all:hover { background: #e2e8f0; color: #1e293b; }

    .btn-delete {
        background: none; border: none; color: #cbd5e1;
        cursor: pointer; padding: 10px; transition: 0.2s;
        border-radius: 8px;
    }
    .btn-delete:hover { color: #ef4444; background: #fee2e2; }

    .unread-dot {
        width: 8px; height: 8px; background: #3b4bff; border-radius: 50%;
    }
</style>

<div class="page-header">
    <div class="page-title">
        <h1>Notifikasi Saya</h1>
        <span>Log aktivitas untuk akses <strong>{{ strtoupper(auth()->user()->role) }}</strong></span>
    </div>

    @if($data->where('is_read', false)->count() > 0)
    <form action="{{ route('notif.markRead') }}" method="POST">
        @csrf
        <button type="submit" class="btn-read-all">
            <i class="fa-solid fa-check-double"></i> Tandai Dibaca Semua
        </button>
    </form>
    @endif
</div>

<div class="notif-wrapper">
    @forelse($data as $item)
        <div class="notif-card {{ !$item->is_read ? 'notif-unread' : '' }}">

            <div class="notif-icon">
                @if(!$item->is_read)
                    <i class="fa-solid fa-bell-on"></i>
                @else
                    <i class="fa-solid fa-envelope-open"></i>
                @endif
            </div>

            <div class="notif-content">
                <div class="notif-info">
                    {{ $item->judul }}
                    <span class="badge-role">{{ auth()->user()->role }}</span>
                    @if(!$item->is_read)
                        <div class="unread-dot"></div>
                    @endif
                </div>

                <div class="notif-desc">
                    {!! $item->pesan !!}
                </div>

                <div class="notif-meta">
                    <i class="fa-regular fa-clock"></i> {{ $item->created_at->diffForHumans() }}
                    <span>•</span>
                    <i class="fa-regular fa-calendar"></i> {{ $item->created_at->format('d M Y, H:i') }}
                </div>
            </div>

            <form action="{{ route('notif.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete" title="Hapus">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
    @empty
        <div style="text-align: center; padding: 80px; background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
            <i class="fa-solid fa-inbox" style="font-size: 48px; color: #e2e8f0; margin-bottom: 15px; display: block;"></i>
            <p style="color: #94a3b8; font-weight: 500;">Tidak ada pemberitahuan baru saat ini.</p>
        </div>
    @endforelse
</div>

@endsection
