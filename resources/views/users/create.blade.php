@extends('layouts.app')

@section('title', 'Tambah Pengguna - ALMED')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f4f7fa;
    }

    .form-container {
        max-width: 650px;
        margin: 50px auto;
        padding: 0 20px;
    }

    /* Card Styling */
    .form-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Header: GRADASI BIRU CAKEP */
    .form-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        padding: 45px 40px;
        color: white;
        text-align: center;
        position: relative;
    }

    /* Aksen Pattern Halus di Header */
    .form-header::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        opacity: 0.1;
        background-image: radial-gradient(#ffffff 1px, transparent 1px);
        background-size: 20px 20px;
    }

    .form-header h2 {
        font-size: 24px;
        font-weight: 800;
        margin: 0;
        position: relative;
        letter-spacing: -0.5px;
    }

    .form-header p {
        opacity: 0.85;
        font-size: 14px;
        margin-top: 8px;
        position: relative;
    }

    .form-body {
        padding: 40px 50px;
    }

    /* Form Styling */
    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-group {
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px 14px 48px;
        font-size: 14px;
        font-weight: 500;
        border: 2px solid #edf2f7;
        border-radius: 14px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .form-control:focus + i {
        color: #3b82f6;
    }

    /* Row layout */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-control[readonly] {
        background-color: #f1f5f9;
        color: #64748b;
        border-style: dashed;
        cursor: not-allowed;
    }

    /* Submit Button dengan Gradasi Serupa */
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 16px;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(37, 99, 235, 0.4);
        filter: brightness(1.1);
    }

    /* Error Alert */
    .alert-custom {
        background: #fff1f2;
        border-left: 4px solid #ef4444;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 30px;
        color: #991b1b;
        font-size: 13px;
    }

    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
        .form-body { padding: 30px; }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2>Tambah Pengguna</h2>
            <p>Kelola akun baru tim medis</p>
        </div>

        <div class="form-body">
            @if($errors->any())
                <div class="alert-custom">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Institusi</label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" required>
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 Karakter" required>
                        <i class="fa-solid fa-lock-open"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Akses Role</label>
                        <div class="input-group">
                            <select name="role" id="role" class="form-control" onchange="setKeterangan()" required style="padding-left: 48px;">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="medis">Medis</option>
                            </select>
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status Akun</label>
                        <div class="input-group">
                            <select name="status" class="form-control" required style="padding-left: 48px;">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                            <i class="fa-solid fa-toggle-on"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Penugasan Otomatis</label>
                    <div class="input-group">
                        <input type="text" id="keterangan" name="keterangan" class="form-control" readonly placeholder="-">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Simpan Data Pengguna <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function setKeterangan() {
    let role = document.getElementById("role").value;
    let ketField = document.getElementById("keterangan");

    const maps = {
        'admin': 'IT / Administrator Sistem',
        'petugas': 'Petugas & Logistik Alat Kesehatan',
        'medis': 'Tenaga Medis Operasional'
    };

    ketField.value = maps[role] || "";
}
</script>

@endsection
