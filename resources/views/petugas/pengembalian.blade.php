@extends('layouts.app')

@section('title','Pengembalian Alat')

@section('content')

<style>
.container{
    background:#fff;
    padding:20px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.title{
    font-size:24px;
    font-weight:700;
    margin-bottom:20px;
}

.table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
}

.table th{
    text-align:left;
    font-size:13px;
    color:#6b7280;
    padding:10px;
}

.table tbody tr{
    background:#fff;
    box-shadow:0 6px 16px rgba(0,0,0,0.05);
    border-radius:12px;
}

.table td{
    padding:12px;
    vertical-align:middle;
    font-size:14px;
}

.alat-box{
    display:flex;
    align-items:center;
    gap:10px;
}

.alat-img{
    width:45px;
    height:45px;
    border-radius:10px;
    object-fit:cover;
    background:#e5e7eb;
}

.date{
    font-size:13px;
    color:#374151;
}

.btn{
    padding:7px 12px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:12px;
    font-weight:600;
    background:#10b981;
    color:white;
}

.btn-danger{
    background:#ef4444;
}

.empty{
    text-align:center;
    padding:20px;
    color:#9ca3af;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
}

.modal-box{
    background:#fff;
    width:420px;
    padding:20px;
    border-radius:12px;
}

/* DETAIL DENDA MODAL */
.detail-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.detail-table th,
.detail-table td{
    border-bottom:1px solid #eee;
    padding:6px;
    font-size:13px;
}

.total-denda{
    margin-top:10px;
    font-weight:700;
    font-size:15px;
    text-align:right;
}
</style>

<div class="container">

    <div class="title">🔄 Pengembalian Alat</div>

    <table class="table">

        <thead>
            <tr>
                <th>User</th>
                <th>Alat Dipinjam</th>
                <th>Tanggal Pengembalian</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($peminjaman as $item)

        @php
            $pengembalian = $item->pengembalian ?? null;
        @endphp

        <tr>

            <td>{{ $item->user->name ?? '-' }}</td>

            <td>
                @foreach($item->detail as $d)

                @php
                    $alat = $d->alat ?? null;

                    $image = ($alat && $alat->gambar && file_exists(public_path('storage/'.$alat->gambar)))
                        ? asset('storage/'.$alat->gambar)
                        : asset('images/no-image.png');
                @endphp

                <div class="alat-box">
                    <img src="{{ $image }}" class="alat-img">

                    <div>
                        <b>{{ $alat->nama_alat ?? '-' }}</b><br>
                        <small>Jumlah: {{ $d->qty }}</small>
                    </div>
                </div>

                @endforeach
            </td>

            <td class="date">
                📅 {{ $item->tanggal_kembali
                    ? \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y')
                    : '-' }}
            </td>

            <!-- 💰 DENDA -->
            <td>

                @if($pengembalian)

                    <b>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</b> <br>

                    @if($pengembalian->status_denda == 'lunas')
                        <span style="color:green;font-weight:600;">✔ Lunas</span>
                    @else
                        <span style="color:red;font-weight:600;">Belum Bayar</span>
                    @endif

                    <!-- 🔍 DETAIL BUTTON -->
                    <br>
                    <button class="btn" style="margin-top:5px;background:#3b82f6;"
                        onclick="openDetail({{ $item->id }})">
                        🔍 Detail Denda
                    </button>

                @else
                    -
                @endif

            </td>

            <!-- AKSI -->
            <td style="display:flex;gap:5px;">

                <button class="btn" type="button"
                    onclick="openModal({{ $item->id }})">
                    ✔ Proses
                </button>

                @if($pengembalian && $pengembalian->status_denda == 'belum_bayar' && $pengembalian->denda > 0)

                <form action="{{ route('petugas.pengembalian.bayar-denda', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Konfirmasi denda sudah dibayar cash?')">
                        💰 Bayar Denda
                    </button>
                </form>

                @endif

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="5" class="empty">Tidak ada data pengembalian</td>
        </tr>

        @endforelse

        </tbody>

    </table>
</div>

<!-- ================= MODAL PROSES ================= -->
<div id="modalPengembalian" class="modal">

    <div class="modal-box">

        <h3>🔧 Pengembalian Alat</h3>

        <form id="formPengembalian" method="POST">
            @csrf

            <label>Kondisi Alat</label>
            <select name="kondisi" required style="width:100%;padding:8px;margin-bottom:10px;">
                <option value="">-- Pilih --</option>
                <option value="baik">Baik</option>
                <option value="rusak ringan">Rusak Ringan</option>
                <option value="rusak berat">Rusak Berat</option>
                <option value="hilang">Hilang</option>
            </select>

            <label>Keterangan</label>
            <textarea name="keterangan" rows="3" style="width:100%;padding:8px;"></textarea>

            <div style="margin-top:15px; display:flex; gap:10px;">
                <button class="btn" type="submit">✔ Simpan</button>
                <button type="button" class="btn btn-danger" onclick="closeModal()">
                    ✖ Batal
                </button>
            </div>

        </form>

    </div>

</div>

<!-- ================= MODAL DETAIL DENDA ================= -->
<div id="modalDetail" class="modal">

    <div class="modal-box">

        <h3>💰 Detail Denda</h3>

        <table class="detail-table">

            <thead>
                <tr>
                    <th>Alat</th>
                    <th>Kondisi</th>
                    <th>Denda</th>
                </tr>
            </thead>

            <tbody id="detailBody">
                <!-- diisi JS -->
            </tbody>

        </table>

        <div class="total-denda" id="totalDenda">
            TOTAL: Rp 0
        </div>

        <button class="btn btn-danger" style="margin-top:10px;" onclick="closeDetail()">
            ✖ Tutup
        </button>

    </div>

</div>

<script>

function openModal(id){
    document.getElementById('modalPengembalian').style.display = 'flex';
    document.getElementById('formPengembalian').action = '/petugas/pengembalian/' + id;
}

function closeModal(){
    document.getElementById('modalPengembalian').style.display = 'none';
}

/* ================= DETAIL DENDA ================= */
function openDetail(id){

    fetch('/api/detail-denda/' + id)
    .then(res => res.json())
    .then(data => {

        let html = '';
        let total = 0;

        data.forEach(item => {
            total += item.denda;

            html += `
                <tr>
                    <td>${item.alat}</td>
                    <td>${item.kondisi}</td>
                    <td>Rp ${item.denda.toLocaleString()}</td>
                </tr>
            `;
        });

        document.getElementById('detailBody').innerHTML = html;
        document.getElementById('totalDenda').innerText = 'TOTAL: Rp ' + total.toLocaleString();

        document.getElementById('modalDetail').style.display = 'flex';
    });
}

function closeDetail(){
    document.getElementById('modalDetail').style.display = 'none';
}

</script>

@endsection
