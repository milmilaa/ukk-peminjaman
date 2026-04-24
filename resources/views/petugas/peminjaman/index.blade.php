@extends('layouts.app')

@section('title', 'Persetujuan Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fa-solid fa-clipboard-check me-2"></i> Konfirmasi Peminjaman Alat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Alat & Jumlah</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $item)
                                    <tr>
                                        <td>
                                            <span class="fw-bold d-block">{{ $item->user->name }}</span>
                                            <small class="text-muted">{{ $item->user->role }}</small>
                                        </td>
                                        <td>
                                            @foreach($item->detail as $detail)
                                                <span class="badge bg-info text-dark mb-1">
                                                    {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }}x)
                                                </span><br>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                {{-- Tombol Setujui --}}
                                                <form action="{{ route('petugas.setujui', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirm('Setujui peminjaman ini?')">
                                                        <i class="fa-solid fa-check me-1"></i> Setujui
                                                    </button>
                                                </form>

                                                {{-- Tombol Tolak --}}
                                                <form action="{{ route('petugas.tolak', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('Tolak peminjaman ini?')">
                                                        <i class="fa-solid fa-xmark me-1"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <img src="https://illustrations.popsy.co/gray/box.svg" alt="empty" style="width: 150px;">
                                            <p class="mt-3 text-muted">Belum ada pengajuan peminjaman baru.</p>
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
