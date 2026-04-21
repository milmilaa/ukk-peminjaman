@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Laporan Peminjaman</h3>

    <a href="{{ route('petugas.laporan.excel') }}" class="btn btn-success">
Export Excel
</a>

<a href="{{ route('petugas.laporan.pdf') }}" class="btn btn-danger">
Export PDF
</a>

<a href="{{ route('petugas.laporan.cetak') }}" target="_blank" class="btn btn-primary">
Cetak
</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
        @foreach($peminjaman as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->alat->nama_alat }}</td>
            <td>{{ $p->jumlah }}</td>
            <td>{{ $p->status }}</td>
            <td>{{ $p->created_at }}</td>
        </tr>
        @endforeach
        </tbody>

    </table>
</div>

@endsection
