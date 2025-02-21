@extends('admin/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Divisi</h6>
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
                        <th>Nama Divisi</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($divisi as $div) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $div->nama_divisi ?></td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                    title="Edit" data-toggle="modal"
                                    data-target="#editModal<?= $div->id_divisi ?>"><i
                                        class="fas fa-edit"></i></button>
                                        <form id="deleteForm<?= $div->id_divisi ?>" action="{{ route('delete_divisi', $div->id_divisi) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-divisi" data-tooltip="tooltip" data-placement="bottom"
                                            title="Delete"><i
                                                class="fas fa-trash"></i></button>
                                        </form>
                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $div->id_divisi ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Divisi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('edit_divisi', $div->id_divisi) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <div class="control-group mb-3 col">
                                                    <label class="control-label" for="nama_divisi">Nama
                                                        Divisi</label>
                                                    <div class="controls">
                                                        <input type="text" name="nama_divisi" id="nama_divisi"
                                                            placeholder="Masukkan Nama Divisi"
                                                            class="form-control bg-light small"
                                                            value="<?= $div->nama_divisi ?>" required>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_divisi') }}" method="post">
                        @csrf
                        <div class="control-group mb-3 col">
                            <label class="control-label" for="nama_divisi_add">Nama
                                Divisi</label>
                            <div class="controls">
                                <input type="text" name="nama_divisi" id="nama_divisi_add"
                                    placeholder="Masukkan Nama Divisi" class="form-control bg-light small" required>
                                    <div class="invalid-feedback">
                                        Sudah ada divisi dengan nama tersebut.
                                    </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split mb-3" id="addBtnDiv">
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