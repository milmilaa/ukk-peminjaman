@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Log Aktivitas Sistem</h3>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Aksi</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
    @forelse($logs as $log)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $log->user->name ?? '-' }}</td>
            <td>{{ $log->aksi ?? '-' }}</td>
            <td>{{ $log->deskripsi ?? '-' }}</td>
            <td>{{ $log->created_at }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">Tidak ada data log</td>
        </tr>
    @endforelse
    </tbody>

</table>
</div>

@endsection
