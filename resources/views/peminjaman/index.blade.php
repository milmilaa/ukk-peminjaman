@extends('layouts.app')

@section('title', 'Data Peminjaman')

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

.btn-add {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,.35);
}

/* CARD */
.card {
    background: #fff;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table thead {
    background: #4f46e5;
}

.table th,
.table td {
    text-align: center;
    padding: 14px;
    font-size: 14px;
}

.table th {
    color: #fff;
}

.table td {
    border-bottom: 1px solid #e5e7eb;
}

.table tbody tr:hover {
    background: #f1f5ff;
}

/* STATUS */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.badge.dipinjam {
    background: #fef9c3;
    color: #854d0e;
}

.badge.dikembalikan {
    background: #dcfce7;
    color: #166534;
}

/* ACTION */
.action {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.btn {
    padding: 7px 10px;
    border-radius: 8px;
    font-size: 13px;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #2563eb;
    color: #fff;
}

.btn-edit:hover {
    background: #1d4ed8;
}

.btn-delete {
    background: #ef4444;
    color: #fff;
}

.btn-delete:hover {
    background: #dc2626;
}

.empty {
    text-align: center;
    padding: 40px;
    color: #6b7280;
}
</style>

<div class="page-header">
    <div>
        <h1>Data Peminjaman</h1>
        <span>Daftar peminjaman alat medis</span>
    </div>

    <a href="{{ route('admin.peminjaman.create') }}" class="btn-add">
        ➕ Tambah
    </a>
</div>

<div class="card">

    <!-- OPTIONAL EXPORT -->
    <div style="margin-bottom:15px;">
        <a href="{{ route('petugas.peminjaman.export.excel') }}" class="btn-add">
            📊 Export Excel
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($peminjamans as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>{{ $item->user->name ?? '-' }}</td>

                <td>{{ $item->alat->nama_alat ?? '-' }}</td>

                <td>{{ $item->jumlah }}</td>

                <td>
                    <span class="badge {{ $item->status }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>

                <td>
                    {{ $item->tanggal_pinjam
                        ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y')
                        : '-' }}
                </td>

                <td>
                    {{ $item->tanggal_kembali
                        ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y')
                        : '-' }}
                </td>

                <td>
                    <div class="action">

                        <a href="{{ route('admin.peminjaman.edit', $item->id) }}"
                           class="btn btn-edit">
                            ✏️
                        </a>

                        <form action="{{ route('admin.peminjaman.destroy', $item->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-delete" type="submit">
                                🗑️
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="empty">
                    Data peminjaman belum tersedia
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
