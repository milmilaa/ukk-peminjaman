@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')

<style>
.page-title {
    margin-bottom: 20px;
}

.page-title h1 {
    font-size: 26px;
    font-weight: 700;
    color: #111827;
}

.form-card {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    max-width: 750px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #374151;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

.preview-box {
    width: 140px;
    height: 140px;
    border-radius: 12px;
    border: 1px dashed #d1d5db;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-top: 10px;
    background: #f9fafb;
}

.preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.btn-submit {
    background: #2563eb;
    color: #fff;
    border: none;
    padding: 11px 18px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
}

.btn-submit:hover {
    background: #1d4ed8;
}

.row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

@media(max-width:768px){
    .row { grid-template-columns: 1fr; }
}
</style>

<div class="page-title">
    <h1>➕ Tambah Peminjaman</h1>
</div>

<div class="form-card">

    <form action="{{ route('admin.peminjaman.store') }}" method="POST">
        @csrf

        <!-- USER (NAMA ORANG) -->
        <div class="form-group">
            <label>Nama Peminjam</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih Peminjam --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- ALAT -->
        <div class="form-group">
            <label>Nama Alat</label>
            <select name="alat_id" class="form-control" id="alatSelect" required>
                <option value="">-- Pilih Alat --</option>
                @foreach($alats as $alat)
                    <option value="{{ $alat->id }}"
                        data-image="{{ asset('storage/'.$alat->gambar) }}">
                        {{ $alat->nama_alat }}
                    </option>
                @endforeach
            </select>

            <!-- PREVIEW -->
            <div class="preview-box" id="previewBox">
                <span style="color:#9ca3af;font-size:13px;">Preview Gambar</span>
            </div>
        </div>

        <div class="row">

            <!-- JUMLAH -->
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>

            <!-- TANGGAL PINJAM -->
            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" required>
            </div>

        </div>

        <!-- TANGGAL KEMBALI -->
        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" required>
        </div>

        <button type="submit" class="btn-submit">
            Simpan Peminjaman
        </button>

    </form>

</div>

<script>
document.getElementById('alatSelect').addEventListener('change', function () {
    let selected = this.options[this.selectedIndex];
    let image = selected.getAttribute('data-image');

    let box = document.getElementById('previewBox');

    if (image) {
        box.innerHTML = `<img src="${image}" />`;
    } else {
        box.innerHTML = `<span style="color:#9ca3af;font-size:13px;">Preview Gambar</span>`;
    }
});
</script>

@endsection
