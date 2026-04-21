@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

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

    form input,
    form select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-bottom: 16px;
        font-size: 14px;
        transition: 0.3s;
    }

    form input:focus,
    form select:focus {
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

    .btn-back {
        margin-left: 10px;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
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
        <h1>Tambah Peminjaman</h1>
        <span>Isi form untuk mencatat peminjaman alat</span>
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

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <label for="user_id">Nama Peminjam</label>
        <select name="user_id" id="user_id" required>
            <option value="">-- Pilih Peminjam --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        <label for="alat_id">Alat</label>
        <select name="alat_id" id="alat_id" required>
            <option value="">-- Pilih Alat --</option>
            @foreach($alats as $alat)
                <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                    {{ $alat->nama }} (Stok: {{ $alat->stok }})
                </option>
            @endforeach
        </select>
        <label for="jumlah">Jumlah Dipinjam</label>
        <input
            type="number"
            name="jumlah"
            id="jumlah"
            min="1"
            value="{{ old('jumlah') }}"
            placeholder="Masukkan jumlah alat"
            required
        >

        <label for="tanggal_pinjam">Tanggal Pinjam</label>
        <input
            type="date"
            name="tanggal_pinjam"
            id="tanggal_pinjam"
            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
            required
        >

        <button type="submit" class="btn-submit">Simpan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn-back">Batal</a>
    </form>

</div>

@endsection
