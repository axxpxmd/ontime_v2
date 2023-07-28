<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laporan Kehadiran - {{ Carbon\Carbon::createFromFormat('Y-m-d', $tanggal)->isoFormat('D MMMM Y') }}</title>

    <style type="text/css">
     body {
            padding-top: 0px !important;
            color: black !important;
        }
		table.d {
            border-collapse: collapse;
            width: 100%
        } 

        table.d tr.d,th.d,td.d{
            table-layout: fixed;
            border: 1px solid black;
            font-size: 12px;
            padding: 5px !important
        }

        .text-center{
            text-align: center
        }

        .p-l-5{
            padding-left: 5px;
        }
        .fs-14{
            font-size: 14px
        }
        .ml-10{
            margin-left: 10px !important
        }
        .t-uppercase{
            text-transform: uppercase
        }
        .fw-bold{
            font-weight: bolder;
        }
    </style>
</head>
<body>
    <p class="text-center fw-bold">LAPORAN KEHADIRAN</p>
    <table class="fs-14" style="margin-bottom: 10px">
        <tr>
            <td>Tanggal</td>
            <td>: {{ Carbon\Carbon::createFromFormat('Y-m-d', $tanggal)->isoFormat('D MMMM Y') }}</td>
        </tr>
        <tr>
            <td>OPD</td>
            <td>: {{ $opd_id ? $opd->nama : '-' }}</td>
        </tr>  
        <tr>
            <td>Keterangan</td>
            <td>: {{ $ket }}</td>
        </tr> 
    </table>
    <table class="d">
        <thead>
            <tr class="d">
                <th class="d">No</th>
                <th class="d">Nama</th>
                <th class="d">Keterangan</th>
                <th class="d">Jam Masuk</th>
                <th class="d">Jam Keluar</th>
                <th class="d">Total Jam</th>
                <th class="d">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse  ($datas as $index => $i)
                @php
                    $totalJam = explode(':', $i->total_jam);
                @endphp
                <tr class="d">
                    <td class="d text-center">{{ $index+1 }}</td>
                    <td class="d t-uppercase">{{ $i->personalInformation->nama }}</td>
                    <td class="d text-center">{{ $i->keterangan }}</td>
                    <td class="d text-center">{{ $i->jam_masuk }}</td>
                    <td class="d text-center">{{ $i->jam_keluar }}</td>
                    <td class="d text-center">{{ $i->total_jam ? $totalJam[0] . ' Jam ' . $totalJam[1] . ' Menit ': '' }}</td>
                    <td class="d text-center">{{ Carbon\Carbon::createFromFormat('Y-m-d', $i->tanggal)->isoFormat('D MMMM Y') }}</td>
                </tr>
            @empty
            <tr class="d">
                <td class="d text-center" colspan="7">Tidak ada data disini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-left: 450px; margin-top: 30px">
        <p>Tangerang Selatan, {{ Carbon\Carbon::createFromFormat('Y-m-d', $tanggal)->isoFormat('D MMMM Y') }}</p>
        <p style="margin-top: 120px !important; margin-left: 70px">Administrator</p>
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>