@extends('layouts.app')

@section('title', 'Tambah Pengembalian')

@section('content')

<style>
    .card {
        background: #fff;
        padding: 22px;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0,0,0,.06);
        max-width: 600px;
        margin: auto;
    }

    label {
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }

    input, select, textarea {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-bottom: 16px;
    }

    button {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
    }
</style>

<h2 style="margin-bottom:20px">Tambah Pengembalian</h2>

<div class="card">
    <form action="{{ route('pengembalian.store') }}" method="POST">
        @csrf

        <label>Peminjaman</label>
        <select name="peminjaman_id" required>
            <option value="">-- Pilih Peminjaman --</option>
            @foreach($peminjamans as $p)
                <option value="{{ $p->id }}">
                    {{ $p->user->name }} - {{ $p->alat->nama }}
                </option>
            @endforeach
        </select>

        <label>Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" required>

        <label>Kondisi Alat</label>
        <select name="kondisi" required>
            <option value="Baik">Baik</option>
            <option value="Rusak">Rusak</option>
            <option value="Hilang">Hilang</option>
        </select>

        <label>Catatan</label>
        <textarea name="catatan" rows="3"></textarea>

        <button type="submit">Simpan</button>
    </form>
</div>

@endsection
