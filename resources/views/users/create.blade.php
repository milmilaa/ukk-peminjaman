@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h1 {
        font-size: 26px;
        font-weight: 600;
        color: #1f2937;
    }

    .page-header span {
        color: #6b7280;
        font-size: 14px;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        max-width: 600px;
        margin: 0 auto;
        animation: fadeUp 0.6s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    form label {
        font-weight: 500;
        display: block;
        margin-bottom: 6px;
        color: #374151;
    }

    form input, form select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-bottom: 16px;
        font-size: 14px;
        transition: 0.3s;
    }

    form input:focus, form select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
    }

    .btn-submit {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,99,235,.35);
    }

    .error-list {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        list-style-type: disc;
    }

    .error-list li {
        margin-left: 18px;
        margin-bottom: 4px;
    }
</style>

<div class="page-header">
    <div>
        <h1>Tambah User</h1>
        <span>Isi form berikut untuk menambahkan user baru</span>
    </div>
</div>

<div class="card">
    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <label for="name">Nama:</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama user" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Masukkan password" required>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
        </select>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button type="submit" class="btn-submit">Simpan</button>
    </form>
</div>

@endsection
