@extends('layouts.app')

@section('title','Pengembalian Alat')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .container-fluid {
        padding: 30px;
    }

    /* ================= HEADER ================= */
    .header-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .header-section .icon-box {
        width: 50px;
        height: 50px;
        background: #3b4bff;
        color: white;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 8px 16px rgba(59, 75, 255, 0.2);
    }

    .header-section h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    /* ================= MAIN CARD ================= */
    .table-card {
        background: #fff;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        padding: 15px 20px;
        border-bottom: 2px solid #f8fafc;
    }

    .table tbody tr {
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        background: #fcfdff;
    }

    .table td {
        padding: 20px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* ================= ALAT BOX ================= */
    .alat-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .alat-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
    }

    .alat-img {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        object-fit: cover;
        background: #e2e8f0;
    }

    .alat-info b {
        display: block;
        color: #1e293b;
        font-size: 13px;
    }

    .alat-info small {
        color: #64748b;
        font-weight: 600;
    }

    /* ================= BADGES & BUTTONS ================= */
    .badge-denda {
        background: #fff1f2;
        color: #e11d48;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
    }

    .btn-proses {
        background: #3b4bff;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(59, 75, 255, 0.2);
    }

    .btn-proses:hover {
        background: #2f3de6;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 75, 255, 0.3);
    }

    /* ================= MODAL ================= */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-box {
        background: #fff;
        width: 100%;
        max-width: 450px;
        padding: 30px;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-box h3 {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group { margin-bottom: 18px; }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        font-family: inherit;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b4bff;
        box-shadow: 0 0 0 4px rgba(59, 75, 255, 0.1);
    }

    .modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 12px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
    }
</style>

<div class="container-fluid">

    <div class="header-section">
        <div class="icon-box">
            <i class="fa-solid fa-rotate-left"></i>
        </div>
        <div>
            <h1>Pengembalian Alat</h1>
            <p style="margin:0; color:#64748b; font-size:14px;">Kelola pengembalian dan pengecekan denda alat medis.</p>
        </div>
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-user" style="margin-right:8px;"></i>Peminjam</th>
                    <th><i class="fa-solid fa-microscope" style="margin-right:8px;"></i>Alat Medis</th>
                    <th><i class="fa-solid fa-calendar" style="margin-right:8px;"></i>Batas Kembali</th>
                    <th><i class="fa-solid fa-money-bill-wave" style="margin-right:8px;"></i>Denda</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjaman as $item)
                @php $pengembalian = $item->pengembalian ?? null; @endphp
                <tr>
                    <td style="font-weight: 700; color: #1e293b;">
                        {{ $item->user->name ?? '-' }}
                    </td>

                    <td>
                        <div class="alat-wrapper">
                            @foreach($item->detail as $d)
                            @php
                                $alat = $d->alat ?? null;
                                $image = ($alat && $alat->gambar) ? asset('storage/' . $alat->gambar) : asset('images/no-image.png');
                            @endphp
                            <div class="alat-box">
                                <img src="{{ $image }}" class="alat-img">
                                <div class="alat-info">
                                    <b>{{ $alat->nama_alat ?? '-' }}</b>
                                    <small>Jumlah: {{ $d->qty }} Unit</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </td>

                    <td style="font-weight: 600; color: #475569;">
                        {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                    </td>

                    <td>
                        @if($pengembalian && $pengembalian->denda > 0)
                            <span class="badge-denda">Rp {{ number_format($pengembalian->denda,0,',','.') }}</span>
                        @else
                            <span style="color: #cbd5e1; font-weight: 600;">- Tidak Ada -</span>
                        @endif
                    </td>

                    <td style="text-align:center;">
                        <button class="btn-proses" onclick="openModal({{ $item->id }})">
                            <i class="fa-solid fa-circle-check"></i> Proses Kembali
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 60px; color:#94a3b8;">
                        <i class="fa-solid fa-folder-open fa-3x" style="display:block; margin-bottom:15px; opacity:0.2;"></i>
                        Belum ada data peminjaman aktif.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalPengembalian" class="modal">
    <div class="modal-box">
        <h3><i class="fa-solid fa-clipboard-check" style="color:#3b4bff;"></i> Verifikasi Pengembalian</h3>

        <form id="formPengembalian" method="POST">
            @csrf
            <div class="form-group">
                <label>Kondisi Alat</label>
                <select name="kondisi" class="form-control" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="baik">✅ Baik / Normal</option>
                    <option value="rusak ringan">⚠️ Rusak Ringan</option>
                    <option value="rusak berat">❌ Rusak Berat</option>
                    <option value="hilang">❗ Hilang</option>
                </select>
            </div>

            <div class="form-group">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Lecet pemakaian, kabel putus, dsb..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button class="btn-proses" type="submit" style="justify-content: center; padding: 12px;">Selesaikan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id){
    document.getElementById('modalPengembalian').style.display = 'flex';
    document.getElementById('formPengembalian').action = "{{ route('petugas.pengembalian.proses', ':id') }}".replace(':id', id);
}

function closeModal(){
    document.getElementById('modalPengembalian').style.display = 'none';
}

// Menutup modal jika klik di luar box
window.onclick = function(event) {
    let modal = document.getElementById('modalPengembalian');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

@endsection
