@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<div class="container-status">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-4">
            Selamat Datang Di Dashboard || 
            <span style="font-size: 0.8em; opacity: 0.7; font-style: italic;">
                Silahkan Filter Tahun
            </span>
        </h1>

        <select id="year-selector" class="form-select w-auto">
            @for ($year = now()->year; $year >= now()->year - 5; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>
    </div>

    <div class="row">
        @php
            $boxes = [
                ['label' => 'TOTAL', 'icon' => 'bi-folder-fill', 'color' => 'bg-secondary', 'class' => 'data-total'],
                ['label' => 'OPEN', 'icon' => 'bi-gear-fill', 'color' => 'bg-orange', 'class' => 'data-open'],
                ['label' => 'CLOSE', 'icon' => 'bi-check-circle-fill', 'color' => 'bg-success', 'class' => 'data-close'],
            ];
        @endphp

        @foreach($boxes as $box)
        <div class="col-12 col-sm-4">
            <div class="info-box">
                <span class="info-box-icon {{ $box['color'] }} text-white shadow-sm">
                    <i class="bi {{ $box['icon'] }}"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ $box['label'] }}</span>
                    <span class="info-box-number {{ $box['class'] }}">0</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="card mb-4">
    <div class="card-header border-0 pb-0">
        <h3 class="card-title">Data WO Tiap Bulan</h3>
    </div>
    <div class="card-body">
        <div class="position-relative">
            <div id="sales-chart"></div>
        </div>
    </div>
</div>

<!-- Row untuk menampung kedua chart -->
<div class="row">
    @php
        $charts = [
            ['title' => 'Departemen', 'id' => 'pie-chart-department'],
            ['title' => 'Jenis Pekerjaan', 'id' => 'pie-chart-jobtype']
        ];
    @endphp

    @foreach($charts as $chart)
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">{{ $chart['title'] }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div id="{{ $chart['id'] }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Aset CSS dan JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.categories.min.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection
