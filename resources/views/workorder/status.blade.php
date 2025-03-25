@extends('layouts.app')

@section('content')
@include('workorder._export_filter', ['departemen' => $departemen, 'jenisPekerjaan' => $jenisPekerjaan])


<div class="container">
    <h1 class="mb-4">Status Work Order</h1>

    <div class="table-responsive">
        <table id="woTable" class="table table-bordered table-striped table-hover w-100">
            <thead>
                <tr>
                    <th>Nomor WO</th>
                    <th>Status</th>
                    <th>Tanggal Order</th>
                    <th>Tanggal Selesai</th>
                    <th>Nama Pemohon</th>
                    <th>Departemen</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Deskripsi</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workOrders as $wo)
                <tr>
                    <td>{{ $wo->nomor_wo }}</td>
                    <td>{{ $wo->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($wo->tanggal_pembuatan)->translatedFormat('d F Y') }}</td>
                    <td>
                        {{ optional($wo->updates()->first())->tanggal_selesai 
                            ? \Carbon\Carbon::parse(optional($wo->updates()->first())->tanggal_selesai)->translatedFormat('d F Y') 
                            : 'Belum Selesai' }}
                    </td>
                    <td>{{ $wo->nama_pemohon }}</td>
                    <td>{{ $wo->departemen }}</td>
                    <td>{{ $wo->jenis_pekerjaan }}</td>
                    <td>{{ $wo->deskripsi }}</td>
                    <td>
                        <a href="{{ route('workorder.download', $wo->nomor_wo) }}" target="_blank" class="btn btn-primary btn-sm">
                            Download PDF
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
         @if(auth()->user()->role == 'admin' || auth()->user()->role == 'executor' )
        <a href="#" class="btn btn-success" id="openExportModal" data-url="{{ route('export.work_orders') }}">
            Export Excel
        </a>
        @endif
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/workorder_status.css') }}">

<script src="{{ asset('js/workorder_status.js') }}"></script>

@endsection
