@extends('layouts.app')

@section('title', 'Tambah Pengembalian')

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
    }

    /* ================= HEADER (Sesuai Gambar Sebelumnya) ================= */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .header-title h1 {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -1px;
    }

    .header-title p {
        font-size: 16px;
        color: #64748b;
        margin: 5px 0 0 0;
        font-weight: 500;
    }

    .btn-back {
        background: #fff;
        color: #64748b;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    /* ================= FORM CARD ================= */
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        padding: 30px;
        max-width: 700px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-family: inherit;
        font-size: 15px;
        color: #0f172a;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    /* ================= BUTTON SAVE ================= */
    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        padding: 14px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        margin-top: 10px;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(37, 99, 235, 0.4);
    }

    /* ================= ALERT ERROR ================= */
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 14px;
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div class="header-title">
            <h1>Tambah Pengembalian</h1>
            <p>Input data pengembalian alat medis ALMEDISx</p>
        </div>

        <a href="{{ route('admin.pengembalian.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-card">
        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengembalian.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="peminjaman_id">Peminjam & Alat</label>
                <select name="peminjaman_id" id="peminjaman_id" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Data Peminjaman --</option>
                    @foreach($peminjamans as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->user->name }} - {{ $p->alat->nama_alat ?? 'Alat Tidak Diketahui' }}
                            (ID: #{{ $p->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_kembali">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                       class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="kondisi">Kondisi Saat Kembali</label>
                <select name="kondisi" id="kondisi" class="form-control" required>
                    <option value="Baik">🟢 BAIK (Siap Digunakan Kembali)</option>
                    <option value="Rusak">🔴 RUSAK (Perlu Perbaikan)</option>
                    <option value="Hilang">🟡 HILANG (Akan Dikenakan Denda)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" id="catatan" rows="4" class="form-control"
                          placeholder="Masukkan informasi tambahan seperti bagian yang lecet atau kelengkapan alat..."></textarea>
            </div>

            <button type="submit" class="btn-save">
                <i class="fa-solid fa-cloud-arrow-up"></i> Simpan Data Pengembalian
            </button>
        </form>
    </div>
</div>

@endsection
