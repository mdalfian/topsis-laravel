<?php if($mode == 'kriteria'): ?>
    
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
                <a href="{{route('edit_view',['kriteria',$kri->id_kriteria])}}"><button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                    title="Edit"><i
                        class="fas fa-edit"></i></button>
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

<?php elseif ($mode == 'sub') : ?>
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
                                <a href="{{route('edit_view',['sub',$sk->id_sub_kriteria])}}"><button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                    title="Edit"><i class="fas fa-edit"></i></button></a>
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
                                                <div class="row">
                                                    <div class="col"></div>
                                                    <div class="col"></div>
                                                    <div class="col"></div>
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

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1"
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
                        action=""
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
                                        class="form-control bg-light small" required>
                                </div>
                            </div>
                            <div class="control-group mb-3 col">
                                <label class="control-label" for="nilai">Nilai</label>
                                <div class="controls">
                                    <input type="number" name="nilai" id="nilai"
                                        placeholder="Masukkan nilai"
                                        class="form-control bg-light small" required>
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
                    <form action="{{ route('add_sub_kriteria', $kri->id_kriteria) }}" id="formAddSub<?= $kri->id_kriteria ?>" method="post">
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
                    <button type="submit" class="btn btn-primary btn-icon-split mb-3" form="formAddSub<?= $kri->id_kriteria ?>" id="addBtnSub">
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

    <?php else: ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Matrik Keputusan (X)</h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <?php foreach ($kriteria as $kri) : ?>
                        <th class="text-center"><?= $kri->kode_kriteria ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($perhitungan as $per) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $per->nama_alternatif ?></td>
                            <?php foreach ($kriteria as $kri) : ?>
                            <?php foreach ($penilaian as $nilai) : ?>

                            <?php if ($nilai->id_kriteria == $kri->id_kriteria && $nilai->id_alternatif == $per->id_alternatif) : ?>
                            <td class="text-center"><?= $nilai->nilai ?></td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bobot Kriteria (W)</h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <?php foreach ($kriteria as $kri) : ?>
                        <th class="text-center"><?= $kri->kode_kriteria ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <tr> 
                            <?php foreach ($kriteria as $kr) : ?>
                            <td class="text-center"><?= $kr->bobot_kriteria ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Matriks Normalisasi (R)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <?php foreach ($kriteria as $kri) : ?>
                        <th class="text-center"><?= $kri->kode_kriteria ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        ?>
                        <?php foreach ($perhitungan as $per) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $per->nama_alternatif ?></td>
                            <?php foreach ($kriteria as $kri) : ?>
                            <?php foreach ($penilaian as $nilai) : ?>
                            <?php if ($nilai->id_kriteria == $kri->id_kriteria && $nilai->id_alternatif == $per->id_alternatif) : ?>
                            <?php foreach ($total as $tot) : ?>
                            <?php if ($nilai->id_kriteria == $tot->id_kriteria) : ?>
                            <td class="text-center"><?= round(normalisasi($nilai->nilai, $tot->total), 4) ?></td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Matriks Y</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="terbobot" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <?php foreach ($kriteria as $kri) : ?>
                        <th class="text-center"><?= $kri->kode_kriteria ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        ?>
                        <?php foreach ($perhitungan as $per) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $per->nama_alternatif ?></td>
                            <?php foreach ($kriteria as $kri) : ?>
                            <?php foreach ($penilaian as $nilai) : ?>
                            <?php if ($nilai->id_kriteria == $kri->id_kriteria && $nilai->id_alternatif == $per->id_alternatif) : ?>
                            <?php foreach ($total as $tot) : ?>
                            <?php if ($nilai->id_kriteria == $tot->id_kriteria) : ?>
                            <td class="text-center">
                                <?= round(normalisasi($nilai->nilai, $tot->total) * $kri->bobot_kriteria, 4) ?></td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Solusi Ideal Positif A<sup>+</sup></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <?php foreach ($kriteria as $kri) : ?>
                        <th class="text-center"><?= $kri->kode_kriteria ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($kriteria as $kri) : ?>
                            <?php foreach ($normalisasi as $norm) : ?>
                            <?php if ($kri->id_kriteria == $norm->id_kriteria) : ?>
                            <td class="text-center">
                                <?= $kri->jenis_kriteria == 'Benefit' ? round($norm->max, 4) : round($norm->min, 4) ?>
                            </td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Solusi Ideal Negatif A<sup>-</sup></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <?php foreach ($kriteria as $kri) : ?>
                        <th class="text-center"><?= $kri->kode_kriteria ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($kriteria as $kri) : ?>
                            <?php foreach ($normalisasi as $norm) : ?>
                            <?php if ($kri->id_kriteria == $norm->id_kriteria) : ?>
                            <td class="text-center">
                                <?= $kri->jenis_kriteria == 'Benefit' ? round($norm->min, 4) : round($norm->max, 4) ?>
                            </td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jarak Ideal Positif (S<sub>i</sub><sup>+</sup>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <th>No</th>
                        <th style="width: 70%;">Nama</th>
                        <th>Jarak Ideal Positif</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($perhitungan as $per) : ?>
                        <?php foreach ($solusi as $sol): ?>
                        <?php if ($sol->id_alternatif == $per->id_alternatif) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $per->nama_alternatif ?></td>
                            <td class="text-center"><?= round($sol->solusi_positif, 4) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jarak Ideal Negatif (S<sub>i</sub><sup>-</sup>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <th>No</th>
                        <th style="width: 70%;">Nama</th>
                        <th>Jarak Ideal Negatif</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($perhitungan as $per) : ?>
                        <?php foreach ($solusi as $sol): ?>
                        <?php if ($sol->id_alternatif == $per->id_alternatif) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $per->nama_alternatif ?></td>
                            <td class="text-center"><?= round($sol->solusi_negatif, 4) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kedekatan Relatif Terhadap Solusi Ideal (V)</h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <th>No</th>
                        <th style="width: 70%;">Nama</th>
                        <th class="text-center">Nilai</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($perhitungan as $per) : ?>
                        <?php foreach ($solusi as $sol): ?>
                        <?php if ($sol->id_alternatif == $per->id_alternatif) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $per->nama_alternatif ?></td>
                            <?php
                                        $kedekatan = kedekatan($sol->solusi_positif, $sol->solusi_negatif)
                                        ?>
                            <td class="text-center"><?= round($kedekatan, 4) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Akhir Perangkingan</h6>
        </div>
        <div class="card-body">
            <!-- Print Button -->
            <button class="btn btn-danger btn-icon-split mb-3" id="btnPdf">
                    <span class="icon text-white-50">
                        <i class="far fa-file-alt"></i>
                    </span>
                    <span class="text">Cetak</span>
            </button>

            <div class="table-responsive">
                <table class="table table-bordered" id="rank" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <th style="width: 70%;">Nama</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Rank</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>

                        <?php foreach ($ranking as $rank): ?>
                        <tr>
                            <td><?= $rank->nama_alternatif ?></td>
                            <td class="text-center"><?= round($rank->kedekatan, 4) ?></td>
                            <td class="text-center"><?= $no++ ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endif; ?>