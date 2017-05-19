<div id="right1-sidebar">

<br>
<br>

<h2>Μπορείτε να πλοηγηθείτε με βάση τις παρακάτω επιλογές</h2>

<?php if (!isset($config['foreas']['no_decisions'])): ?>
        <div>
            <p></p>
            <div class="rounded_box" style="float: left;font: 17px Georgia;padding-top: 14px;height: 46px;">
                <a href="<?php echo $config['site_url'] . '/list.php?l=dtypes'; ?>">Δείτε ανά είδος</a>
            </div>
            <?php /*
            <div class="rounded_box" style="float: left;font: 17px Georgia;padding-top: 24px;height: 36px;">
                <a href="<?php echo $config['site_url'] . '/list.php?l=allsigner'; ?>">Δείτε με βάση τον Υπογράφοντα</a>
            </div>
            <div class="rounded_box" style="float: left;font: 17px Georgia;padding-top: 24px;height: 36px;">
                <a href="<?php echo $config['site_url'] . '/list.php?l=themes'; ?>">Δείτε με βάση την Θεματική</a>
            </div>
            */?>
            <div class="rounded_box" style="float: left;font: 17px Georgia;padding-top: 14px;height: 46px;">
                <a href="<?php echo $config['site_url'] . '/list.php?l=monades'; ?>">Δείτε με βάση την Εσωτερική Μονάδα</a>
            </div>
                    </div>
    <?php endif; ?>

</div>
