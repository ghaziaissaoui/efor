<?php
//$setting = $this->displaySetting('setting-name', $settings, true);

if ($global['fullWidth'] === 'yes') {
    include __DIR__ . '/layout/full-width.php';
} else {
    include __DIR__ . '/layout/stretch-width.php';
}
