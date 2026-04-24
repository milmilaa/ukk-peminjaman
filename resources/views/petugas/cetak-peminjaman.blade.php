@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

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

.page-title span {
    font-size: 14px;
    color: #6b7280;
}

.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    margin-top: 20px;
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.table th,
.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.table th {
    background: #f9fafb;
    text-align: left;
    font-weight: 600;
}

/* BUTTON */
.btn {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
}

.btn-blue { background: #3b82f6; }
.btn-green { background: #16a34a; }
.btn-orange { background: #f97316; }

.badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success { background: #dcfce7; color: #166534; }
.badge-danger { background: #fee2e2; color: #991b1b; }

.total-box {
    margin-top: 15px;
    padding: 12px;
    background: #f9fafb;
    border-radius: 10px;
    font-weight: 700;
}
</style>

<div class="page-title">
    <h1>📄 Laporan Peminjaman</h1>
    <span>Data peminjaman alat terbaru</span>
</div>

<div class="card-box">

    <!-- BUTTON -->
    <a href="{{ route('petugas.peminjaman.export.excel') }}" class="btn btn-green">
        📊 Export Excel
    </a>

    <a href="{{ route('petugas.laporan.denda') }}" class="btn btn-blue">
        💰 Laporan Denda
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Alat</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Invoice</th>
            </tr>
        </thead>

        <tbody>
            @forelse($peminjaman as $key => $item)

            @php
                $pengembalian = $item->pengembalian ?? null;
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>

                <td>{{ $item->user->name ?? '-' }}</td>

                <td>
                    @forelse($item->detail as $detail)
                        {{ $detail->alat->nama_alat ?? '-' }} <br>
                    @empty
                        -
                    @endforelse
                </td>

                <td>
                    @forelse($item->detail as $detail)
                        {{ $detail->qty }} <br>
                    @empty
                        -
                    @endforelse
                </td>

                <td>{{ ucfirst($item->status ?? '-') }}</td>

                <td>
                    {{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}
                </td>

                <td>
                    {{ $item->tanggal_kembali
                        ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y')
                        : '-' }}
                </td>

                <!-- DENDA -->
                <td>
                    @if($pengembalian)
                        Rp {{ number_format($pengembalian->denda ?? 0,0,',','.') }} <br>

                        @if($pengembalian->status_denda == 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-danger">Belum Bayar</span>
                        @endif
                    @else
                        -
                    @endif
                </td>

                <!-- INVOICE -->
                <td>
                    @if($pengembalian)
                        <a href="{{ route('petugas.laporan.denda.pdf', $item->id) }}"
                           class="btn btn-orange">
                            🧾 Invoice
                        </a>
                    @else
                        -
                    @endif
                </td>

            </tr>

            @empty
            <tr>
                <td colspan="9" style="text-align:center;">
                    Tidak ada data peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTAL DENDA -->
    <div class="total-box">
        💰 Total Semua Denda:
        Rp {{
            number_format(
                $peminjaman->sum(fn($p) => $p->pengembalian->denda ?? 0),
                0, ',', '.'
            )
        }}
    </div>

</div>

@endsection
