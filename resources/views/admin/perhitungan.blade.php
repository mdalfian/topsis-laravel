@extends('admin/layout')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content -->
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
                            <?php foreach ($kriteria as $kri) : ?>
                            <?php foreach ($kriteria as $kr) : ?>
                            <?php if ($kri->id_kriteria == $kr->id_kriteria) : ?>
                            <td class="text-center"><?= $kr->bobot_kriteria ?></td>
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
            <a href="{{ 'cetak/pdf' }}"> <button class="btn btn-danger btn-icon-split mb-3">
                    <span class="icon text-white-50">
                        <i class="far fa-file-alt"></i>
                    </span>
                    <span class="text">Cetak</span>
                </button>
            </a>

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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endSection