@extends('layouts.app')

@section('title', 'Data Alat')

@section('content')

<style>
/* ================= HEADER ================= */
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

/* ================= BUTTON ================= */
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
    transition: 0.3s;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,.35);
}

/* ================= CARD ================= */
.card {
    background: #fff;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
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

/* ================= TABLE ================= */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table thead {
    background: #4f46e5;
}

/* ✅ CENTER SEMUA */
.table th,
.table td {
    text-align: center;
    padding: 14px;
    font-size: 14px;
}

.table th {
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    border-bottom: 1px solid #e5e7eb;
    color: #374151;
}

.table tbody tr:hover {
    background: #f1f5ff;
}

/* ================= IMAGE ================= */
.alat-img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

/* ================= BADGE ================= */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
}

.badge.available {
    background: #dcfce7;
    color: #166534;
}

.badge.empty {
    background: #fee2e2;
    color: #991b1b;
}

/* ================= ACTION ================= */
.action {
    display: flex;
    justify-content: center; /* ✅ tombol ke tengah */
    gap: 10px;
}

.btn {
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.btn-edit {
    background: #facc15;
    color: #854d0e;
}

.btn-edit:hover {
    background: #fde047;
}

.btn-delete {
    background: #fee2e2;
    color: #991b1b;
}

.btn-delete:hover {
    background: #fecaca;
}

/* ================= EMPTY ================= */
.empty {
    text-align: center;
    padding: 40px;
    color: #6b7280;
}
</style>


<!-- ================= HEADER ================= -->
<div class="page-header">
    <div>
        <h1>Data Alat</h1>
        <span>Daftar alat yang tersedia</span>
    </div>
    <a href="{{ route('admin.alat.create') }}" class="btn-add">
        <i class="fa-solid fa-plus"></i> Tambah Alat
    </a>
</div>


<!-- ================= CARD ================= -->
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width:60px">No</th>
                <th style="width:90px">Gambar</th>
                <th>Nama Alat</th>
                <th style="width:90px">Jumlah</th>
                <th style="width:120px">Status</th>
                <th style="width:130px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($alat as $item)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <!-- GAMBAR -->
                    <td>
                        @if($item->gambar && file_exists(public_path('storage/'.$item->gambar)))
                            <img src="{{ asset('storage/'.$item->gambar) }}" class="alat-img">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" class="alat-img">
                        @endif
                    </td>

                    <!-- NAMA -->
                    <td>{{ $item->nama_alat }}</td>

                    <!-- JUMLAH -->
                    <td>{{ $item->jumlah }}</td>

                    <!-- STATUS -->
                    <td>
                        @if($item->jumlah > 0)
                            <span class="badge available">Tersedia</span>
                        @else
                            <span class="badge empty">Habis</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td>
                        <div class="action">
                            <a href="{{ route('admin.alat.edit', $item->id) }}" class="btn btn-edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('admin.alat.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete"
                                    onclick="return confirm('Yakin hapus alat ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty">
                            <i class="fa-solid fa-box-open fa-2x"></i>
                            <p>Data alat belum tersedia</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
