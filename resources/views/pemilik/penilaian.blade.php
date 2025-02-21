@extends('pemilik/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penilaian</h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>Nama Alternatif</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($alternatif as $alt) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $alt->nama_alternatif ?></td>
                                <td class="text-center">
                                    <?php if ($alt->status == 2) : ?>
                                        <button class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="bottom"
                                            title="Edit" data-toggle="modal"
                                            data-target="#penilaianModal<?= $alt->id_alternatif ?>"><i
                                                class="fas fa-plus"></i>&nbsp;Input</button>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="bottom"
                                            title="Edit" data-toggle="modal"
                                            data-target="#editModal<?= $alt->id_alternatif ?>"><i
                                                class="fas fa-edit"></i>&nbsp;Edit</button>
                                    <?php endif; ?>
                                </td>

                                <!-- Penilaian Modal -->
                                <div class="modal fade" id="penilaianModal<?= $alt->id_alternatif ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Penilaian</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('input_penilaian', $alt->id_alternatif) }}"
                                                    method="post">
                                                    @csrf
                                                    <?php foreach ($kriteria as $kri) : ?>
                                                        <div class="control-group mb-3 col">
                                                            <label class="control-label font-weight-bold"
                                                                for="<?= $kri->kode_kriteria ?>"><?= $kri->nama_kriteria ?></label>
                                                            <div class="controls">
                                                                <select name="nilai[]" id="<?= $kri->kode_kriteria ?>"
                                                                    class="form-control bg-light small" required>
                                                                    <option value="" selected>Pilih...</option>
                                                                    <?php foreach ($sub_kriteria as $sk) : ?>
                                                                        <?php if ($sk->id_kriteria == $kri->id_kriteria) : ?>
                                                                            <option value="<?= $sk->nilai ?>">
                                                                                <?= $sk->nama_sub_kriteria ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </select>

                                                                <input type="hidden" name="id_kriteria[]"
                                                                    value="<?= $kri->id_kriteria ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success btn-icon-split mb-3">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-plus"></i>
                                                    </span>
                                                    <span class="text">Input</span>
                                                </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $alt->id_alternatif ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Penilaian</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('edit_penilaian') }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <?php foreach ($penilaian as $pen) : ?>
                                                        <?php if ($pen->id_alternatif == $alt->id_alternatif) : ?>
                                                            <div class="control-group mb-3 col">
                                                                <label class="control-label font-weight-bold"
                                                                    for="<?= $pen->id_kriteria ?>"><?= $pen->nama_kriteria ?></label>
                                                                <div class="controls">
                                                                    <select name="nilai[]" id="<?= $pen->id_kriteria ?>"
                                                                        class="form-control bg-light small" required>
                                                                        <option value="" selected>Pilih...</option>
                                                                        <?php foreach ($sub_kriteria as $sk) : ?>
                                                                            <?php if ($sk->id_kriteria == $pen->id_kriteria) : ?>
                                                                                <option value="<?= $sk->nilai ?>"
                                                                                    <?= $sk->nilai == $pen->nilai ? 'selected' : '' ?>>
                                                                                    <?= $sk->nama_sub_kriteria ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>

                                                                    <input type="hidden" name="id_penilaian[]"
                                                                        value="<?= $pen->id_penilaian ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <!-- <?php foreach ($kriteria as $kri) : ?>
                                                        <div class="control-group mb-3 col">
                                                            <label class="control-label font-weight-bold"
                                                                for="<?= $kri->kode_kriteria ?>"><?= $kri->nama_kriteria ?></label>
                                                            <div class="controls">
                                                                <select name="nilai[]" id="<?= $kri->kode_kriteria ?>"
                                                                    class="form-control bg-light small" required>
                                                                    <option value="" selected>Pilih...</option>
                                                                    <?php foreach ($sub_kriteria as $sk) : ?>
                                                                        <?php if ($sk->id_kriteria == $kri->id_kriteria) : ?>
                                                                            <option value="<?= $sk->nilai ?>" <?php foreach ($penilaian as $pen) {
                                                                                                                    if ($pen->id_alternatif == $alt->id_alternatif && $pen->id_kriteria == $kri->id_kriteria && $pen->nilai == $sk->nilai) {
                                                                                                                        echo "selected";
                                                                                                                    }
                                                                                                                } ?>>
                                                                                <?= $sk->nama_sub_kriteria ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </select>

                                                                <input type="hidden" name="id_kriteria[]"
                                                                    value="<?= $kri->id_kriteria ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?> -->
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection