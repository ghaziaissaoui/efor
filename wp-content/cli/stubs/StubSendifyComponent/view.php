<?php
$fullW = $this->displaySetting('full-width', $settings, true) !== 'no' ? 'full-width="full-width"' : '';
?>
<mj-section <?= $fullW ?> css-class="padding" padding="<?= $global['padding'] ?>px">
</mj-section>
