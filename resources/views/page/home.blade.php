@extends('layout.app')

@push('scripts')
    
@endpush

@section('navbar')
    <!-- Navbar -->
    <x-navbar role_active="{{ $role }}"/>
    <!-- End Navbar -->
@endsection

@section('header')
    <!-- Header -->
    <!-- Jika Role adalah petugas_indikator -->
    @if($role === 'petugas_indikator')    
        @if(url()->current() == route('petugas_indikator.dashboard'))
            <div class="mt-3">
                <x-headerKonten role_active="{{ $role }}" halaman="dashboard" judulHalaman=""/>
            </div>
        @elseif(url()->current() == route('petugas_indikator.data-pasien.index'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Data Pasien')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Data Pasien"/>
        @elseif(url()->current() == route('petugas_indikator.data-bangsal.index'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Data Bangsal')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Data Bangsal"/>
        @elseif(url()->current() == route('petugas_indikator.data-perawat.index'))
                <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
                @section('title', 'Data Perawat')
                <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Data Perawat"/> 
        @elseif(url()->current() == route('petugas_indikator.laporan.index'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Laporan')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Laporan Terkirim"/>
        @elseif(url()->current() == route('petugas_indikator.laporan.rekap'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Rekaptulasi')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="INDIKATOR SENSUS HARIAN RAWAT INAP"/>
        @endif
    
    <!-- Jika Role adalah perawat -->
    @elseif($role === 'perawat')    
        @if(url()->current() == route('perawat.dashboard'))
            <div class="mt-3">
                <x-headerKonten role_active="{{ $role }}" halaman="dashboard" judulHalaman=""/>
            </div>
        @elseif(url()->current() == route('perawat-pasienMasuk.index'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Pasien Masuk')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Pasien Masuk"/>
        @elseif(url()->current() == route('perawat-pasienPindah.index'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Pasien Pindah')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Pasien Pindah"/>
        @elseif(url()->current() == route('perawat-pasienKeluar.index'))
            <x-profile role_active="{{ $role }}" nama="{{ $nama }}"/>
            @section('title', 'Pasien Keluar')
            <x-headerKonten role_active="{{ $role }}" halaman="konten" judulHalaman="Pasien Keluar"/>
        @endif
    @endif
    
    <!-- End Header -->
@endsection

@section('content')
    <!-- Content -->
        <!-- Jika Role adalah petugas_indikator -->
        @if($role === 'petugas_indikator')
            @if(url()->current() == route('petugas_indikator.dashboard'))
                @include('content.dashboard')
            @elseif(url()->current() == route('petugas_indikator.data-pasien.index'))
                @include('content.dataPasien.admin-dataPasien')
            @elseif(url()->current() == route('petugas_indikator.data-bangsal.index'))
                @include('content.dataBangsal.admin-dataBangsal')
            @elseif(url()->current() == route('petugas_indikator.data-perawat.index'))
                @include('content.dataPerawat.admin-dataPerawat')
            @elseif(url()->current() == route('petugas_indikator.laporan.index'))
                @include('content.laporan.admin-laporan')
            @elseif(url()->current() == route('petugas_indikator.laporan.rekap'))
                @include('content.laporan.admin-laporanRekap')
            @endif
        
        <!-- Jika Role adalah perawat -->
        @elseif($role === 'perawat')
            @if(url()->current() == route('perawat.dashboard'))
                @include('content.dashboard')
            @elseif(url()->current() == route('perawat-pasienPindah.index'))
                @include('content.dataPasien.perawat-pasienPindah')
            @elseif(url()->current() == route('perawat-pasienMasuk.index'))
                @include('content.dataPasien.perawat-pasienMasuk')
            @elseif(url()->current() == route('perawat-pasienKeluar.index'))
                @include('content.dataPasien.perawat-pasienKeluar')
            @endif
        @endif

    <!-- End Content -->
    
@endsection

