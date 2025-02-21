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
            <form action="{{Route('edit_profile', $profile->id)}}" method="post">
                @csrf
                @method('put')
                <div class="row">
                    <div class="control-group mb-3 col">
                        <label class="control-label" for="nama_lengkap">Nama
                            Lengkap</label>
                        <div class="controls">
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                placeholder="Masukkan Nama Lengkap"
                                class="form-control bg-light small"
                                value="<?= $profile->name ?>" required>
                        </div>
                    </div>
                    <div class="control-group mb-3 col">
                        <label class="control-label" for="username">Username</label>
                        <div class="controls">
                            <input type="text" name="username" id="username"
                                placeholder="Masukkan Username"
                                class="form-control bg-light small"
                                value="<?= $profile->username ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="control-group mb-3 col">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input type="password" name="password" id="password"
                                placeholder="Masukkan Password"
                                class="form-control bg-light small">
                        </div>
                        <input type="hidden" name="op" value="<?= $profile->password ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-warning btn-icon-split mb-3">
                    <span class="icon text-white-50">
                        <i class="fas fa-edit"></i>
                    </span>
                    <span class="text">Edit</span>
                </button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection