@extends('layouts.app')

@section('title', 'Edit User - ALMED')

@section('content')

<style>
    body {
        font-family: 'Poppins', system-ui, sans-serif;
    }

    .dashboard-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .page-header p {
        color: #64748b;
        font-size: 16px;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 620px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #003087, #00A8A8);
        color: white;
        padding: 32px 40px;
        text-align: center;
    }

    .form-header h2 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
    }

    .form-header p {
        opacity: 0.9;
        margin-top: 6px;
        font-size: 15px;
    }

    .form-body {
        padding: 40px 50px;
    }

    .form-group {
        margin-bottom: 26px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .form-control {
        width: 100%;
        padding: 16px 20px;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        font-size: 15.5px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #00A8A8;
        box-shadow: 0 0 0 4px rgba(0, 168, 168, 0.15);
    }

    .keterangan-box {
        background: #eff6ff;
        border-left: 5px solid #00A8A8;
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 15px;
        color: #1e40af;
        min-height: 52px;
        display: flex;
        align-items: center;
    }

    .btn-group {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-back {
        background: #e2e8f0;
        color: #475569;
        padding: 14px 26px;
        border-radius: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #cbd5e1;
        transform: translateY(-2px);
    }

    .btn-submit {
        background: linear-gradient(135deg, #003087, #002266);
        color: white;
        padding: 14px 32px;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 48, 135, 0.3);
    }

    .error-alert {
        background: #fee2e2;
        border: 1px solid #f87171;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 28px;
    }
</style>

<div class="dashboard-container">

    <div class="page-header">
        <div>
            <h1>Edit User</h1>
            <p>Perbarui data pengguna sistem ALMED</p>
        </div>
    </div>

    <div class="form-card">

        <div class="form-header">
            <h2><i class="fas fa-user-edit mr-3"></i> Edit User</h2>
            <p>Ubah informasi akun pengguna</p>
        </div>

        <div class="form-body">

            @if($errors->any())
                <div class="error-alert">
                    <strong>❌ Mohon perbaiki kesalahan berikut:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">
                        Password <small>(kosongkan jika tidak ingin diubah)</small>
                    </label>
                    <input type="password" name="password" id="password"
                           class="form-control" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required onchange="updateKeterangan()">
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="medis" {{ old('role', $user->role) == 'medis' ? 'selected' : '' }}>Medis</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <div id="keterangan" class="keterangan-box">-</div>
                </div>

                <div class="form-group">
                    <label for="status">Status Akun</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.users.index') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-save"></i> Update User
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<script>
function updateKeterangan() {
    let role = document.getElementById("role").value;
    let ket = document.getElementById("keterangan");

    if (role === "admin") {
        ket.innerHTML = "IT / Pengelola Sistem";
    } else if (role === "petugas") {
        ket.innerHTML = "Gudang & Logistik Alat Kesehatan";
    } else if (role === "medis") {
        ket.innerHTML = "Dokter / Perawat / Tenaga Medis";
    } else {
        ket.innerHTML = "-";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    updateKeterangan();
});
</script>

@endsection
