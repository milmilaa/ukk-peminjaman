@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="page-header" style="margin-bottom: 20px;">
    <h1 style="font-size: 24px; font-weight: 600;">📜 Log Aktivitas</h1>
    <p style="color: #666;">Riwayat aktivitas sistem terbaru</p>
</div>

<div style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #4f46e5; color: #fff;">
                <th style="padding: 12px; text-align: left; border-radius: 8px 0 0 8px;">Waktu</th>
                <th style="padding: 12px; text-align: left;">User</th>
                <th style="padding: 12px; text-align: left;">Aktivitas</th>
                <th style="padding: 12px; text-align: left; border-radius: 0 8px 8px 0;">IP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">{{ now()->format('d/m/Y H:i') }}</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;"><strong>{{ Auth::user()->name }}</strong></td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">Membuka log sistem</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">127.0.0.1</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
