@extends('admin.layout')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kriteria</h6>
        </div>
        <div class="card-body">
            {{-- Select Kriteria --}}
            <div class="alert alert-warning" role="alert" id="alert">
                Pilih kategori <b>Kriteria</b> dibawah ini!!!
              </div>
            <div class="controls mb-3">
                <select name="kat_kriteria" id="kat_kriteria"
                    class="form-control bg-light small" onchange="selectKriteria('kriteria')" autofocus>
                    <option value="">Pilih...</option>
                    <option value="1">Staff</option>
                    <option value="2">Sales</option>
                </select>
            </div>

            <!-- Add Button -->
            <button class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#addModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </button>

            <div class="table-responsive select-kriteria">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($kriteria as $kri) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $kri->kode_kriteria ?></td>
                            <td><?= $kri->nama_kriteria ?></td>
                            <td><?= $kri->bobot_kriteria ?></td>
                            <td><?= $kri->jenis_kriteria ?></td>
                            <td class="d-flex justify-content-center">
                                <a href=""><button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                    title="Edit"><i class="fas fa-edit"></i></button>
                                    </a>
                                        <form id="deleteForm<?= $kri->id_kriteria ?>" action="{{ route('delete_kriteria', $kri->id_kriteria) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-kriteria" data-tooltip="tooltip" data-placement="bottom"
                                            title="Delete"><i
                                                class="fas fa-trash"></i></button>
                                        </form>
                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $kri->id_kriteria ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Kriteria</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{route('edit_kriteria', $kri->id_kriteria)}}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="kode_kriteria_edit">Kode
                                                            Kriteria</label>
                                                        <div class="controls">
                                                            <input type="text" name="kode_kriteria" id="kode_kriteria_edit"
                                                                placeholder="Masukkan Kode Kriteria"
                                                                class="form-control bg-light small"
                                                                value="<?= $kri->kode_kriteria ?>" required>
                                                                <div class="invalid-feedback">
                                                                    Sudah ada kriteria dengan kode tersebut.
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="nama_kriteria_edit">Nama
                                                            Kriteria</label>
                                                        <div class="controls">
                                                            <input type="text" name="nama_kriteria" id="nama_kriteria_edit"
                                                                placeholder="Masukkan Nama Kriteria"
                                                                class="form-control bg-light small"
                                                                value="<?= $kri->nama_kriteria ?>" required>
                                                                <div class="invalid-feedback">
                                                                    Sudah ada kriteria dengan nama tersebut.
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="bobot">Bobot</label>
                                                        <div class="controls">
                                                            <input type="text" name="bobot_kriteria" id="bobot"
                                                                placeholder="Masukkan Bobot"
                                                                class="form-control bg-light small"
                                                                value="<?= $kri->bobot_kriteria ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="control-group mb-3 col">
                                                        <label class="control-label" for="jenis_kriteria">Jenis
                                                            Kriteria</label>
                                                        <div class="controls">
                                                            <select name="jenis_kriteria" id="jenis_kriteria"
                                                                class="form-control bg-light small" required>
                                                                <option value="">Pilih...</option>
                                                                <option value="Benefit"
                                                                    <?= $kri->jenis_kriteria == 'Benefit' ? 'selected' : '' ?>>
                                                                    Benefit</option>
                                                                <option value="Cost"
                                                                    <?= $kri->jenis_kriteria == 'Cost' ? 'selected' : '' ?>>
                                                                    Cost</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning btn-icon-split mb-3" id="editBtnKri">
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('add_kriteria')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="kode_kriteria_add">Kode Kriteria</label>
                                <div class="controls">
                                    <input type="text" name="kode_kriteria" id="kode_kriteria_add"
                                        placeholder="Masukkan Kode Kriteria" class="form-control bg-light small"
                                        required>
                                        <div class="invalid-feedback">
                                            Sudah ada kriteria dengan kode tersebut.
                                        </div>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="nama_kriteria_add">Nama Kriteria</label>
                                <div class="controls">
                                    <input type="text" name="nama_kriteria" id="nama_kriteria_add"
                                        placeholder="Masukkan Nama Kriteria" class="form-control bg-light small"
                                        required>
                                        <div class="invalid-feedback">
                                            Sudah ada kriteria dengan nama tersebut.
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="bobot">Bobot</label>
                                <div class="controls">
                                    <input type="text" name="bobot_kriteria" id="bobot" placeholder="Masukkan Bobot"
                                        class="form-control bg-light small" required>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="jenis_kriteria">Jenis Kriteria</label>
                                <div class="controls">
                                    <select name="jenis_kriteria" id="jenis_kriteria"
                                        class="form-control bg-light small" required>
                                        <option value="" selected>Pilih...</option>
                                        <option value="Benefit">Benefit</option>
                                        <option value="Cost">Cost</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="kat_kriteria">Kategori Kriteria</label>
                                <div class="controls">
                                    <select name="kat_kriteria" id="kat_kriteria"
                                        class="form-control bg-light small" required>
                                        <option value="" selected>Pilih...</option>
                                        <option value="1">Staff</option>
                                        <option value="2">Sales</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split mb-3" id="addBtnKri">
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

@endsection