<?php

extract($GLOBALS);

require_once APP_PATH_DOCROOT . 'ControlCenter/header.php';

$title = RCView::img(['src' => APP_PATH_IMAGES . 'bell.png']) . ' ' . REDCap::escapeHtml('Control Center Page');
echo RCView::h4([], $title);
echo 'Hello World!!';

require_once APP_PATH_DOCROOT . 'ControlCenter/footer.php';
