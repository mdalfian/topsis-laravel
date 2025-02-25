@extends('leader/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Alternatif</h6>
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
                        <th>Nama Alternatif</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($alternatif as $alt) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $alt->nama_alternatif ?></td>
                            <td><?= $alt->jenis_kelamin ?></td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                    title="Edit" data-toggle="modal"
                                    data-target="#editModal<?= $alt->id_alternatif ?>"><i
                                        class="fas fa-edit"></i></button>
                                        <form id="deleteForm<?= $alt->id_alternatif ?>" action="{{ route('delete_alternatif', $alt->id_alternatif) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-alternatif" data-tooltip="tooltip" data-placement="bottom"
                                            title="Delete"><i
                                                class="fas fa-trash"></i></button>
                                        </form>
                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $alt->id_alternatif ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Alternatif</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('edit_alternatif', $alt->id_alternatif) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                <div class="control-group mb-3 col">
                                                    <label class="control-label" for="nama_alternatif_edit">Nama
                                                        Alternatif</label>
                                                    <div class="controls">
                                                        <input type="text" name="nama_alternatif" id="nama_alternatif_edit"
                                                            placeholder="Masukkan Nama Alternatif"
                                                            class="form-control bg-light small"
                                                            value="<?= $alt->nama_alternatif ?>" required>
                                                            <div class="invalid-feedback">
                                                                Sudah ada alternatif dengan nama tersebut.
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="control-group mb-3 col">
                                                    <label class="control-label" for="jenis_kelamin">Jenis Kelamin</label>
                                                    <div class="controls">
                                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control bg-light small" required>
                                                            <option value="" selected>Pilih...</option>
                                                          <option value="Laki - Laki" {{ $alt->jenis_kelamin == 'Laki - Laki' ? 'selected' : '' }}>Laki - Laki</option>
                                                          <option value="Perempuan" {{ $alt->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning btn-icon-split mb-3" id="editbtnAlt">
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
                    <form action="{{ route('add_alternatif') }}" method="post">
                        @csrf
                        <div class="row">
                        <div class="control-group mb-3 col">
                            <label class="control-label" for="nama_alternatif">Nama
                                Alternatif</label>
                            <div class="controls">
                                <input type="text" name="nama_alternatif" id="nama_alternatif_add"
                                    placeholder="Masukkan Nama Alternatif" class="form-control bg-light small" required>
                                    <div class="invalid-feedback">
                                        Sudah ada alternatif dengan nama tersebut.
                                    </div>
                            </div>
                        </div>
                        <div class="control-group mb-3 col">
                            <label class="control-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="controls">
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control bg-light small" required>
                                    <option value="" selected>Pilih...</option>
                                  <option value="Laki - Laki">Laki - Laki</option>
                                  <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split mb-3" id="addBtnAlt">
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