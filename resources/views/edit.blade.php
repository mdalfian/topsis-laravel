@extends('admin.layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit <?= Str::ucfirst($mode) ?></h6>
        </div>
        <div class="card-body">
            <?php if($mode == 'sub') : ?>
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

<button type="submit" class="btn btn-warning btn-icon-split mb-3">
<span class="icon text-white-50">
    <i class="fas fa-edit"></i>
</span>
<span class="text">Edit</span>
</button>
</form>

<?php elseif($mode == 'kriteria') : ?>
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
                                            <button type="submit" class="btn btn-warning btn-icon-split mb-3" id="editBtnKri">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </button>
                                            </form>
<?php endif; ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection