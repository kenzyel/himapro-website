<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
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
            width: 25%;
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

        .summary-value.green { color: #059669; }
        .summary-value.red { color: #dc2626; }

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
        .green { color: #059669; font-weight: bold; }
        .red { color: #dc2626; font-weight: bold; }
        .muted { color: #888; font-style: italic; }

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
            LAPORAN KEUANGAN
            @if ($from || $to)
                — 
                {{ $from ? \Carbon\Carbon::parse($from)->format('d M Y') : 'Awal' }}
                s/d
                {{ $to ? \Carbon\Carbon::parse($to)->format('d M Y') : 'Sekarang' }}
            @endif
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="summary">
        <div class="summary-row">
            <div class="summary-box">
                <div class="summary-label">Total Pemasukan</div>
                <div class="summary-value green">
                    Rp {{ number_format($summary['total_pemasukan'], 0, ',', '.') }}
                </div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Total Pengeluaran</div>
                <div class="summary-value red">
                    Rp {{ number_format($summary['total_pengeluaran'], 0, ',', '.') }}
                </div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Saldo</div>
                <div class="summary-value">
                    Rp {{ number_format($summary['saldo'], 0, ',', '.') }}
                </div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Transaksi</div>
                <div class="summary-value">
                    {{ $summary['jumlah_transaksi'] }}
                </div>
            </div>
        </div>
    </div>

    {{-- REKAP PER KATEGORI --}}
    @if ($perKategori->count() > 0)
        <h2 class="section-title">Rekap per Kategori</h2>

        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th class="text-right">Pemasukan</th>
                    <th class="text-right">Pengeluaran</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($perKategori as $item)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $item['kategori'])) }}</td>
                        <td class="text-right green">
                            Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}
                        </td>
                        <td class="text-right red">
                            Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}
                        </td>
                        <td class="text-right">
                            <strong>Rp {{ number_format($item['total'], 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- DETAIL --}}
    <h2 class="section-title">Detail Transaksi</h2>

    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th width="70">Tanggal</th>
                <th>Deskripsi</th>
                <th width="90">Kategori</th>
                <th width="70">Jenis</th>
                <th width="100" class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $trx->tanggal?->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $trx->deskripsi }}</strong>
                        @if ($trx->departemen || $trx->programKerja)
                            <br>
                            <span class="muted" style="font-size: 9px;">
                                {{ $trx->departemen?->nama }}
                                @if ($trx->departemen && $trx->programKerja) · @endif
                                {{ $trx->programKerja?->nama }}
                            </span>
                        @endif
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $trx->kategori)) }}</td>
                    <td>
                        @if ($trx->jenis === 'pemasukan')
                            <span class="green">Masuk</span>
                        @else
                            <span class="red">Keluar</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <strong class="{{ $trx->jenis === 'pemasukan' ? 'green' : 'red' }}">
                            {{ $trx->jenis === 'pemasukan' ? '+' : '-' }}
                            Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center muted" style="padding: 30px;">
                        Tidak ada transaksi pada periode ini.
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