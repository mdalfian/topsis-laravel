<style>
table,
td,
th {
    border: 1px solid;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

h2 {
    text-align: center;
    margin-bottom: 2rem;
}
</style>

<h2>Hasil Perangkingan</h2>
<table id="rank" width="100%" cellspacing="0">
    <thead>
        <th style="width: 70%;">Nama</th>
        <th>Nilai</th>
        <th>Rank</th>
    </thead>
    <tbody>
        <?php $no = 1; ?>

        <?php foreach ($ranking as $rank): ?>
        <tr>
            <td><?= $rank->nama_alternatif ?></td>
            <td><?= round($rank->kedekatan, 4) ?></td>
            <td><?= $no++ ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>