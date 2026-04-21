@extends('layouts.app')

@section('title', 'Tambah User - ALMED')

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
        max-width: 680px;
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
        padding: 40px 50px;   /* ← Ini yang diperbesar biar lebih rapi */
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
        box-sizing: border-box;   /* Penting agar tidak meluber */
    }

    .form-control:focus {
        outline: none;
        border-color: #00A8A8;
        box-shadow: 0 0 0 4px rgba(0, 168, 168, 0.15);
    }

    .form-control[readonly] {
        background-color: #f8fafc;
        color: #64748b;
    }

    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #003087, #002266);
        color: white;
        padding: 16px;
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0, 48, 135, 0.35);
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
            <h1>Tambah User Baru</h1>
            <p>Isi data berikut untuk menambahkan akun pengguna ke sistem ALMED</p>
        </div>
    </div>

    <div class="form-card">
        <!-- Header -->
        <div class="form-header">
            <h2><i class="fas fa-user-plus mr-3"></i> Tambah Pengguna</h2>
            <p>Buat akun baru untuk tim ALMED</p>
        </div>

        <!-- Body -->
        <div class="form-body">

            @if($errors->any())
                <div class="error-alert">
                    <strong>❌ Mohon perbaiki kesalahan berikut:</strong>
                    <ul class="mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           placeholder="Masukkan nama lengkap"
                           required>
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           placeholder="contoh@almed.co.id"
                           required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           placeholder="Buat password minimal 8 karakter"
                           required>
                </div>

                <div class="form-group">
                    <label for="role">Role Pengguna</label>
                    <select name="role"
                            id="role"
                            class="form-control"
                            onchange="setKeterangan()"
                            required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="medis" {{ old('role') == 'medis' ? 'selected' : '' }}>Medis</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text"
                           id="keterangan"
                           name="keterangan"
                           value="{{ old('keterangan') }}"
                           class="form-control"
                           readonly
                           placeholder="Keterangan akan muncul otomatis">
                </div>

                <div class="form-group">
                    <label for="status">Status Akun</label>
                    <select name="status"
                            id="status"
                            class="form-control"
                            required>
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save mr-2"></i> Simpan User
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function setKeterangan() {
    let role = document.getElementById("role").value;
    let ketField = document.getElementById("keterangan");

    if (role === "admin") {
        ketField.value = "IT / Pengelola Sistem";
    } else if (role === "petugas") {
        ketField.value = "Gudang & Logistik Alat Kesehatan";
    } else if (role === "medis") {
        ketField.value = "Tenaga Medis";
    } else {
        ketField.value = "";
    }
}

window.onload = function() {
    setKeterangan();
};
</script>

@endsection
