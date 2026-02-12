@extends('layouts.app')

@section('title', 'Edit Kategori')

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

    .card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        max-width: 500px;
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
        color: #374151;
        display: block;
        margin-bottom: 6px;
    }

    form input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-bottom: 18px;
        font-size: 14px;
        transition: 0.3s;
    }

    form input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
    }

    .btn-group {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 10px;
    }

    .btn-back {
        background: #e5e7eb;
        color: #374151;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #d1d5db;
        transform: translateY(-2px);
    }

    .btn-submit {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
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
    <h1>Edit Kategori</h1>
</div>
<div class="card">
    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nama">Nama Kategori</label>
        <input
            type="text"
            name="nama"
            id="nama"
            value="{{ old('nama', $kategori->nama) }}"
            placeholder="Masukkan Kategori"
            required
        >

        <div class="btn-group">
            <a href="{{ route('kategori.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-pen-to-square"></i> Update
            </button>
        </div>
    </form>
</div>

@endsection
