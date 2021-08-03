<div class="finishing">
    <div class="finishing-left">
        <span><strong>Finishing</strong></span><br><br>
        <div style="width: 80%; border: 1px solid #000; padding: 5px;">
            <span>Type Finishing</span><br>
            <?php foreach ($finishing_item as $f) : ?>
                <div style="padding: 2px; float: left; width: 95px">
                    <div class="finishing-item"><span><?= $f->nama_finishing_item ?></span></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="finishing-right">
        <span><strong>Cutting Pola :</strong></span><br><br>
        <?php $no = 0; ?>
        <?php foreach ($estimated_item as $item) : ?>
            <div>
                <div style="float:left; width: 70%">
                    <div style="width: 350px;">
                        <div style="width: 100%">
                            <table>
                                <tr>
                                    <td style="border: none;">&nbsp;</td>
                                    <td style="border: none; text-align: center"><?= $item->paper_size_plano_l ?></td>
                                </tr>
                                <tr>
                                    <td style="border: none;"><?= $item->paper_size_plano_p ?></td>
                                    <td style="padding: 50px 160px;"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="float:right;">
                    <table>
                        <tr>
                            <td style="border: none; text-align: center"><?= round($item->cutting_size_plano_l, 2) ?></td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 40px;"></td>
                            <td style="border: none;">&nbsp;<?= round($item->cutting_size_plano_p, 2) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php if ($no !== count($estimated_item) - 1) : ?>
                <hr>
            <?php endif; ?>
            <?php $no++; ?>
        <?php endforeach; ?>
    </div>
</div>
<div class="summary">
    <table>
        <thead>
            <tr>
                <th>Disiapkan</th>
                <th>Diperiksa</th>
                <th>Produksi</th>
                <th>Finishing</th>
                <th>Gudang</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding-top: 30px;"><?= $spk->penyiap ?></td>
                <td style="padding-top: 30px;"><?= $spk->pemeriksa ?></td>
                <td style="padding-top: 30px;"><?= $spk->produksi ?></td>
                <td style="padding-top: 30px;"><?= $spk->finishing ?></td>
                <td style="padding-top: 30px;"><?= $spk->gudang ?></td>
            </tr>
        </tbody>
    </table>
</div>