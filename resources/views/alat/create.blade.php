@extends('layouts.app')

@section('title', 'Tambah Alat - ALMED')

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

    /* Header: GRADASI BIRU CAKEP (Sama dengan Create User) */
    .form-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        padding: 45px 40px;
        color: white;
        text-align: center;
        position: relative;
    }

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
        z-index: 10;
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* Submit Button */
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

    /* Area Upload Gambar (Disesuaikan agar matching) */
    .upload-area {
        border: 2px dashed #edf2f7;
        background: #f8fafc;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        transition: 0.3s;
        cursor: pointer;
        position: relative;
    }

    .upload-area:hover {
        border-color: #3b82f6;
    }

    .upload-area input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0; left: 0;
        opacity: 0;
        cursor: pointer;
    }

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
            <h2>Tambah Alat Baru</h2>
            <p>Registrasi alat kesehatan ke dalam sistem</p>
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

            <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Nama Alat Kesehatan</label>
                    <div class="input-group">
                        <input type="text" name="nama_alat" class="form-control" placeholder="Contoh: Stetoskop" value="{{ old('nama_alat') }}" required>
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Stok</label>
                        <div class="input-group">
                            <input type="number" name="stok" class="form-control" placeholder="0" value="{{ old('stok') }}" required>
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Harga Barang</label>
                        <div class="input-group">
                            <input type="number" name="harga" class="form-control" placeholder="Rp" value="{{ old('harga') }}" required>
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kategori Alat</label>
                    <div class="input-group">
                        <select name="kategori_id" class="form-control" required style="padding-left: 48px;">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto Alat</label>
                    <div class="upload-area">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 24px; color: #94a3b8; margin-bottom: 8px; display: block;"></i>
                        <span style="font-size: 13px; color: #64748b; font-weight: 600;">Klik untuk upload gambar</span>
                        <input type="file" name="gambar" id="gambar_input">
                        <div id="file-name" style="margin-top: 10px; font-size: 12px; color: #3b82f6; font-weight: 700;"></div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Simpan Data Alat <i class="fa-solid fa-save"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview nama file
    document.getElementById('gambar_input').onchange = function () {
        document.getElementById('file-name').innerHTML = "File terpilih: " + this.files[0].name;
    };
</script>

@endsection
