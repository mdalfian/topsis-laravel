@extends('admin/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>
        <div class="card-body">
            <!-- Add Button -->
            <button class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#addModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </button>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($user as $usr) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $usr->name ?></td>
                            <td><?= $usr->username ?></td>
                            <td><?= $usr->nama_jabatan ?></td>
                            <td class="d-flex justify-content-center">
                                <!-- <button class="btn btn-sm btn-primary" data-tooltip="tooltip" data-placement="bottom"
                                    title="Detail" data-toggle="modal" data-target="#detailModal<?= $usr->id ?>"><i
                                        class="fas fa-info-circle"></i></button> -->
                                <button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                    title="Edit" data-toggle="modal" data-target="#editModal<?= $usr->id ?>"><i
                                        class="fas fa-edit"></i></button>
                                        <form id="deleteForm<?= $usr->id ?>" action="{{ route('delete_user', $usr->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-user" data-tooltip="tooltip" data-placement="bottom"
                                            title="Delete"><i
                                                class="fas fa-trash"></i></button>
                                        </form>
                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $usr->id ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('edit_user', $usr->id) }}"
                                                method="post">
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
                                                                value="<?= $usr->name ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="username">Username</label>
                                                        <div class="controls">
                                                            <input type="text" name="username" id="username"
                                                                placeholder="Masukkan Username"
                                                                class="form-control bg-light small"
                                                                value="<?= $usr->username ?>" required>
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
                                                        <input type="hidden" name="op" value="<?= $usr->password ?>">
                                                    </div>
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="level">Level</label>
                                                        <div class="controls">
                                                            <select name="level" id="level"
                                                                class="form-control bg-light small" required>
                                                                <option value="" selected>Pilih...</option>
                                                                <option value="Admin"
                                                                    <?= $usr->level == 'Admin' ? 'selected' : '' ?>>
                                                                    Admin</option>
                                                                <option value="Pemilik"
                                                                    <?= $usr->level == 'Pemilik' ? 'selected' : '' ?>>
                                                                    Pemilik</option>
                                                                <option value="Karyawan"
                                                                    <?= $usr->level == 'Karyawan' ? 'selected' : '' ?>>
                                                                    Karyawan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="jabatan">Jabatan</label>
                                                        <div class="controls">
                                                            <select name="jabatan" id="jabatan" class="form-control bg-light small" required>
                                                                <option value="" selected>Pilih...</option>
                                                                @foreach ($jabatan as $jab)
                                                                <option value="{{$jab->id_jabatan}}" {{$jab->id_jabatan == $usr->id_jabatan ? 'selected' : ''}}>{{ $jab->nama_jabatan }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
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
                            </div>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Alternatif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_user') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="nama_lengkap">Nama
                                    Lengkap</label>
                                <div class="controls">
                                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                                        placeholder="Masukkan Nama Lengkap" class="form-control bg-light small"
                                        required>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="username">Username</label>
                                <div class="controls">
                                    <input type="text" name="username" id="username" placeholder="Masukkan Username"
                                        class="form-control bg-light small" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" placeholder="Masukkan Password"
                                        class="form-control bg-light small" required>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="level">Level</label>
                                <div class="controls">
                                    <select name="level" id="level" class="form-control bg-light small" required>
                                        <option value="" selected>Pilih...</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Pemilik">Pemilik</option>
                                        <option value="Karyawan">Karyawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="jabatan">Jabatan</label>
                                <div class="controls">
                                    <select name="jabatan" id="jabatan" class="form-control bg-light small" required>
                                        <option value="" selected>Pilih...</option>
                                        @foreach ($jabatan as $jab)
                                        <option value="{{$jab->id_jabatan}}">{{ $jab->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection