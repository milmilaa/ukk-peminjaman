@extends('layouts.app')

@section('title', 'Edit Alat')

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

    .preview img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        margin-bottom: 16px;
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
        <h1>Edit Alat</h1>
        <span>Perbarui data alat</span>
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

    <form action="{{ route('alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="nama_alat">Nama Alat</label>
        <input type="text" name="nama_alat" id="nama_alat"
               value="{{ old('nama_alat', $alat->nama_alat) }}" required>

        <label for="jumlah">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah"
               value="{{ old('jumlah', $alat->jumlah) }}" min="0" required>

        <label for="kategori_id">Kategori</label>
        <select name="kategori_id" id="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}"
                    {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>

        <label for="gambar">Gambar</label>
        <input type="file" name="gambar" id="gambar">

        <div class="preview">
            @if($alat->gambar)
                <img src="{{ asset('storage/'.$alat->gambar) }}">
            @else
                <img src="{{ asset('images/no-image.png') }}">
            @endif
        </div>

        <button type="submit" class="btn-submit">
            Update
        </button>
    </form>
</div>

@endsection
