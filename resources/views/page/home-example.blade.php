@extends('layout.app')

@section('title', 'Home Page')

@section('navbar')
    <a class="navbar-brand" href="#">MyApp</a>
@endsection

@section('header')
    <h1>Welcome to MyApp</h1>
@endsection

@section('content')
    <p>Ini adalah halaman utama aplikasi.</p>
    <button class="btn btn-primary" onclick="showAlert()">Klik Saya</button>
@endsection

@push('scripts')
<script>
    function showAlert() {
        Swal.fire({
            title: 'Hello!',
            text: 'Ini adalah contoh SweetAlert2',
            icon: 'success',
        });
    }
</script>
@endpush

