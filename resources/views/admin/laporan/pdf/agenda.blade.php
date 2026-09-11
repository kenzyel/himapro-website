<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Agenda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #111;
            padding: 24px;
        }

        .header {
            text-align: center;
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: 3px solid #F5A900;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #0B0B0D;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .header .periode {
            font-size: 11px;
            color: #F5A900;
            font-weight: bold;
            margin-top: 6px;
        }

        .summary {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 8px 0;
        }

        .summary-row {
            display: table-row;
        }

        .summary-box {
            display: table-cell;
            padding: 12px;
            background: #f5f5f5;
            border-left: 4px solid #F5A900;
        }

        .summary-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #111;
        }

        h2.section-title {
            font-size: 13px;
            font-weight: bold;
            color: #0B0B0D;
            margin: 22px 0 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #F5A900;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        thead th {
            background: #0B0B0D;
            color: #F5F3E8;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e5e5e5;
            font-size: 10.5px;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .muted { color: #888; font-style: italic; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 10px;
            color: white;
        }

        .badge-planned { background: #F5A900; }
        .badge-ongoing { background: #3b82f6; }
        .badge-completed { background: #059669; }
        .badge-cancelled { background: #dc2626; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 0;
            text-align: center;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #e5e5e5;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>HIMAPRO TI SAKTI</h1>
        <p>Himpunan Mahasiswa Program Studi Teknologi Informasi</p>
        <div class="periode">
            LAPORAN AGENDA
            @if ($from || $to)
                — 
                {{ $from ? \Carbon\Carbon::parse($from)->format('d M Y') : 'Awal' }}
                s/d
                {{ $to ? \Carbon\Carbon::parse($to)->format('d M Y') : 'Sekarang' }}
            @endif
            @if ($status) — Status: {{ ucfirst($status) }} @endif
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="summary">
        <div class="summary-row">
            <div class="summary-box">
                <div class="summary-label">Total</div>
                <div class="summary-value">{{ $summary['total'] }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Direncanakan</div>
                <div class="summary-value">{{ $summary['planned'] }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Berlangsung</div>
                <div class="summary-value">{{ $summary['ongoing'] }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Selesai</div>
                <div class="summary-value">{{ $summary['completed'] }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Dibatalkan</div>
                <div class="summary-value">{{ $summary['cancelled'] }}</div>
            </div>
        </div>
    </div>

    {{-- DETAIL --}}
    <h2 class="section-title">Detail Agenda</h2>

    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Judul Agenda</th>
                <th width="120">Program Kerja</th>
                <th width="120">Lokasi</th>
                <th width="110">Waktu</th>
                <th width="80">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agendas as $index => $agenda)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $agenda->judul }}</strong></td>
                    <td style="font-size: 10px;">{{ $agenda->programKerja?->nama ?? '—' }}</td>
                    <td style="font-size: 10px;">{{ $agenda->lokasi ?: '—' }}</td>
                    <td style="font-size: 9.5px;">
                        {{ $agenda->tanggal_mulai?->format('d/m/Y H:i') ?? '—' }}
                    </td>
                    <td>
                        @switch($agenda->status)
                            @case('planned')
                                <span class="badge badge-planned">Rencana</span>
                                @break
                            @case('ongoing')
                                <span class="badge badge-ongoing">Berjalan</span>
                                @break
                            @case('completed')
                                <span class="badge badge-completed">Selesai</span>
                                @break
                            @case('cancelled')
                                <span class="badge badge-cancelled">Batal</span>
                                @break
                        @endswitch
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center muted" style="padding: 30px;">
                        Tidak ada agenda pada filter ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Dicetak pada {{ now()->format('d F Y, H:i') }} WIB
        — HIMAPRO TI SAKTI
    </div>

</body>
</html>