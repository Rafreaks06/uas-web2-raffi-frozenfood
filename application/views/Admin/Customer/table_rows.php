<?php 
$no = 1;
if(!empty($customer)): 
    foreach ($customer as $row): 
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row->nama ?></td>

    <?php if (!$is_offline): ?>
        <td><?= $row->no_hp ?></td>
        <td><?= $row->alamat ?></td>
    <?php endif; ?>

    <td>
        <span class="badge badge-<?= $row->badge_color ?>">
            <?= $row->badge_label ?>
        </span>
    </td>
    <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
    <td>
        <a href="<?= base_url('admin/customer/detail/' . $row->id . '/' . $row->tipe) ?>" 
           class="btn btn-info btn-sm">
            <i class="fas fa-eye"></i> Detail
        </a>
    </td>
</tr>
<?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="<?= $is_offline ? '5' : '7' ?>" class="text-center text-muted font-italic">
            Data tidak ditemukan.
        </td>
    </tr>
<?php endif; ?>