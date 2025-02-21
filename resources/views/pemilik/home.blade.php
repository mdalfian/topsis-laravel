@extends('pemilik.layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Welcome</h6>
        </div>
        <div class="card-body">
            <h6>Selamat Datang, {{Auth::user()->name}}</h6>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection