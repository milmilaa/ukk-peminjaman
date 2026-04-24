@extends('layouts.app')

@section('title', 'Tambah Kategori - ALMEDIS')

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
        font-size: 14px;
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
        filter: brightness(1.1);
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

    /* ================= ALERT ================= */
    .alert-danger {
        background: #fff1f2;
        color: #be123c;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 25px;
        border-left: 5px solid #ef4444;
    }

    .alert-danger ul {
        margin: 5px 0 0 20px;
        padding: 0;
        font-size: 14px;
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <h1>Tambah Kategori</h1>
        <p>Definisikan kategori baru untuk manajemen alat medis</p>
    </div>

    <div class="form-card">
        @if ($errors->any())
            <div class="alert-danger">
                <div style="font-weight: 800;">Terdapat kesalahan input:</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 25px;">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="form-control"
                    placeholder="Masukkan nama kategori (ex: Alat Bedah, Oksigen, dll)"
                    value="{{ old('nama') }}"
                    required
                    autofocus
                >
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kategori
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
