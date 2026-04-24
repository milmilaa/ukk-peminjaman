@extends('layouts.app')

@section('title', 'Manajemen Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="fa-solid fa-rotate-left me-2"></i> Verifikasi Pengembalian Alat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Alat Medis</th>
                                    <th>Status Saat Ini</th>
                                    <th>Tgl Pinjam</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $item)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $item->user->name }}</div>
                                        <small class="text-muted">{{ strtoupper($item->user->role) }}</small>
                                    </td>
                                    <td>
                                        @foreach($item->detail as $detail)
                                            <span class="badge bg-light text-dark border mb-1">
                                                {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})
                                            </span><br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($item->status == 'diajukan')
                                            <span class="badge bg-info">Menunggu Balik</span>
                                        @elseif($item->status == 'dipinjam')
                                            <span class="badge bg-primary">Masih Dipinjam</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Proses Kembali</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        {{-- Tombol untuk memproses pengembalian --}}
                                        <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm px-4">
                                                <i class="fa-solid fa-clipboard-check me-1"></i> Proses Kembali
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p class="text-muted">Tidak ada data peminjaman aktif yang perlu dikembalikan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
