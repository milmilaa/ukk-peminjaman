@extends('layouts.app')

@section('title', 'Tambah Alat - ALMED')

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
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #00A8A8;
        box-shadow: 0 0 0 4px rgba(0, 168, 168, 0.15);
    }

    .form-control-file {
        padding: 12px 16px;
        border: 1.5px dashed #cbd5e1;
        border-radius: 16px;
        background: #f8fafc;
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

    .error-alert ul {
        margin: 8px 0 0 20px;
    }
</style>

<div class="dashboard-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1>Tambah Alat Baru</h1>
            <p>Isi data alat kesehatan beserta gambarnya</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">

        <!-- Form Header -->
        <div class="form-header">
            <h2><i class="fas fa-plus-circle mr-3"></i> Tambah Alat Kesehatan</h2>
            <p>Masukkan informasi alat dengan lengkap</p>
        </div>

        <!-- Form Body -->
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

            <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama_alat">Nama Alat</label>
                    <input type="text"
                           name="nama_alat"
                           id="nama_alat"
                           value="{{ old('nama_alat') }}"
                           class="form-control"
                           placeholder="Contoh: Ventilator Portable"
                           required>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah / Stok</label>
                    <input type="number"
                           name="jumlah"
                           id="jumlah"
                           value="{{ old('jumlah') }}"
                           class="form-control"
                           min="0"
                           placeholder="0"
                           required>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Alat (Opsional)</label>
                    <input type="file"
                           name="gambar"
                           id="gambar"
                           class="form-control form-control-file"
                           accept="image/*">
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.alat.index') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-save"></i> Simpan Alat
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection
