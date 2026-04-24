@extends('layouts.app')

@section('title', 'Edit Peminjaman - ALMEDIS')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f4f7fa;
    }

    .dashboard-container {
        padding: 40px;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* ================= HEADER ================= */
    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -1px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
        margin-top: 4px;
    }

    /* ================= FORM CARD ================= */
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        padding: 40px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    /* Readonly style */
    .form-control:disabled {
        background-color: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
        border: 2px solid #e2e8f0;
    }

    /* ================= PREVIEW BOX ================= */
    .preview-box {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        border: 2px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f8fafc;
        margin-top: 10px;
    }

    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ================= GRID LAYOUT ================= */
    .row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    /* ================= BUTTONS ================= */
    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(37, 99, 235, 0.4);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <h1>Edit Peminjaman</h1>
        <p>Perbarui status atau tanggal pengembalian peminjaman alat medis</p>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row-grid">
                <div class="form-group">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" value="{{ $peminjaman->user->name ?? 'User Tidak Ditemukan' }}" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">Alat Medis</label>
                    <input type="text" class="form-control" value="{{ $peminjaman->alat->nama_alat ?? 'Alat Tidak Ditemukan' }}" disabled>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label class="form-label">Preview Alat</label>
                <div class="preview-box">
                    @if($peminjaman->alat && $peminjaman->alat->gambar)
                        <img src="{{ asset('storage/' . $peminjaman->alat->gambar) }}" alt="Preview">
                    @else
                        <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">Preview Alat</span>
                    @endif
                </div>
            </div>

            <div class="row-grid">
                <div class="form-group">
                    <label class="form-label">Status Peminjaman</label>
                    <select name="status" class="form-control" required>
                        <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" value="{{ $peminjaman->tanggal_kembali }}" required>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
