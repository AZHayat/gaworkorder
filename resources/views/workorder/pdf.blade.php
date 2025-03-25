<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAWO</title>

    <link rel="stylesheet" href="{{ public_path('css/workorder_pdf.css') }}">

</head>
<body>

    <div class="container">
        <header>
            <div class="header-left">
                <img src="{{ public_path('img/logoipm.jpg') }}" alt="Logo IPM">
            </div>
            <div class="header-center">
                <h1>GENERAL AFFAIR WORKING ORDER</h1>
            </div>
            <div class="header-right">
                <p>Nomor Dokumen: 123456</p>
            </div>
        </header>

        <section class="info-container">
            <table class="info1">
                <tr>
                    <th>Nomor WO</th>
                    <td>: {{ $data['Nomor WO'] }}</td>
                </tr>
                <tr>
                    <th>Pemohon</th>
                    <td>: {{ $data['Nama Pemohon'] }}</td>
                </tr>
                <tr>
                    <th>Departemen</th>
                    <td>: {{ $data['Departemen'] }}</td>
                </tr>
            </table>

            <table class="info2">
                <tr>
                    <th>Tanggal Order</th>
                    <td>: {{ \Carbon\Carbon::parse($data['Tanggal Order'])->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Target Selesai</th>
                    <td>: {{ \Carbon\Carbon::parse($data['Target Selesai'])->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Jenis Pekerjaan</th>
                    <td>: {{ $data['Jenis Pekerjaan'] }}</td>
                </tr>
            </table>
        </section>

        <section class="details">
            <h2>Deskripsi Pekerjaan / Masalah / Order</h2>
            <textarea readonly>{{ $data['Deskripsi'] }}</textarea>

            <section class="info-container">
                <table class="info1">
                    <tr>
                        <th>Tanggal Pengerjaan</th>
                        <td>: 
                            {{ $data['Tanggal Pengerjaan'] 
                                ? \Carbon\Carbon::parse($data['Tanggal Pengerjaan'])->translatedFormat('d F Y') 
                                : 'Belum Dikerjakan' 
                            }}
                        </td>

                    </tr>
                    
                </table>

                <table class="info2">
                    <tr>
                        <th>Tanggal Selesai</th>
                       <td>: 
                            {{ $data['Tanggal Selesai'] 
                                ? \Carbon\Carbon::parse($data['Tanggal Selesai'])->translatedFormat('d F Y') 
                                : 'Belum Selesai' 
                            }}
                        </td>
                    </tr>
                    
                </table>
        </section>

            <h2>Uraian Pekerjaan / Tindakan</h2>
            <textarea readonly>{{ $data['Tindakan'] }}</textarea>

            <h2>Saran / Analisa Penyebab</h2>
            <textarea readonly>{{ $data['Saran'] }}</textarea>
        </section>

        <section class="materials">
            <h2>Parts / Material Yang Digunakan</h2>
            <table>
                <tr>
                    <th class="no1">No</th>
                    <th class="nama1">Nama Barang</th>
                    <th class="qty1">QTY</th>
                    <th class="unit1">Unit</th>
                    <th class="pr1">Nomor PR</th>
                </tr>
                @foreach ($data['Materials'] as $index => $material)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $material['Nama Barang'] }}</td>
                    <td>{{ $material['QTY'] }}</td>
                    <td>{{ $material['Unit'] }}</td>
                    <td>{{ $material['Nomor PR'] }}</td>
                </tr>
                @endforeach
            </table>
        </section>

        <section class="signature">
            <h2>Approval</h2>
            <table>
                <tr class="sign">
                    <th>Superintendant Pelaksana</th>
                    <th>Pelaksana</th>
                    <th>Superintendant Pemohon</th>
                    <th>Pemohon</th>
                </tr>
                <tr>
                    <td><br><br><br><br>________________</td>
                    <td><br><br><br><br>________________</td>
                    <td><br><br><br><br>________________</td>
                    <td><br><br><br><br>________________</td>
                </tr>
            </table>
        </section>

        <footer>
            <p> 
                <strong>Masa Simpan Dokumen:</strong> 1 Tahun &nbsp;&nbsp;&nbsp;|| &nbsp; &nbsp;  &nbsp;    
                <strong>Disimpan Oleh:</strong> HRD &nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;   &nbsp;  
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($data['Tanggal Order'])->translatedFormat('d F Y') }}
            </p>
        </footer>
        
    </div>

</body>
</html>
