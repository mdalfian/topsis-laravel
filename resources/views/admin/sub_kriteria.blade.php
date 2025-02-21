@extends('admin/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <?php foreach ($kriteria as $kri) : ?>

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                <?= $kri->nama_kriteria . ' (' . $kri->kode_kriteria . ')'  ?>
            </h6>
            <!-- Add Button -->
            <button class="btn btn-sm btn-primary btn-icon-split" data-toggle="modal"
                data-target="#addModal<?= $kri->id_kriteria ?>">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </button>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Nama Sub Kriteria</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sub_kriteria as $sk) : ?>
                        <?php if ($kri->id_kriteria == $sk->id_kriteria) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $sk->nama_sub_kriteria ?></td>
                            <td><?= $sk->nilai ?></td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                    title="Edit" data-toggle="modal"
                                    data-target="#editModal<?= $sk->id_sub_kriteria ?>"><i
                                        class="fas fa-edit"></i></button>
                                        <form id="deleteForm<?= $kri->id_kriteria ?>" action="{{ route('delete_sub_kriteria', $sk->id_sub_kriteria) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-sub-kriteria" data-tooltip="tooltip" data-placement="bottom"
                                            title="Delete"><i
                                                class="fas fa-trash"></i></button>
                                        </form>
                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $sk->id_sub_kriteria ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Sub Kriteria</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('edit_sub_kriteria', $sk->id_sub_kriteria) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="nama_sub_kriteria">Nama Sub
                                                            Kriteria</label>
                                                        <div class="controls">
                                                            <input type="text" name="nama_sub_kriteria"
                                                                id="nama_sub_kriteria"
                                                                placeholder="Masukkan Nama Sub Kriteria"
                                                                class="form-control bg-light small"
                                                                value="<?= $sk->nama_sub_kriteria ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="nilai">Nilai</label>
                                                        <div class="controls">
                                                            <input type="number" name="nilai" id="nilai"
                                                                placeholder="Masukkan nilai"
                                                                class="form-control bg-light small"
                                                                value="<?= $sk->nilai ?>" required>
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
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal<?= $kri->id_kriteria ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_sub_kriteria', $kri->id_kriteria) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="nama_sub_kriteria">Nama Sub
                                    Kriteria</label>
                                <div class="controls">
                                    <input type="text" name="nama_sub_kriteria" id="nama_sub_kriteria_add" onkeyup="check_sub({{$kri->id_kriteria}})"
                                        placeholder="Masukkan Nama Sub Kriteria" class="form-control bg-light small"
                                        required>
                                        <div class="invalid-feedback">
                                            Sudah ada sub kriteria dengan nama tersebut.
                                        </div>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="nilai">Nilai</label>
                                <div class="controls">
                                    <input type="number" name="nilai" id="nilai" placeholder="Masukkan nilai"
                                        class="form-control bg-light small" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split mb-3" id="addBtnSub">
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

    <?php endforeach; ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection