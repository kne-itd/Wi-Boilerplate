<?php
require_once 'views/common/common_top.php';

if (empty($page_content)) {
    $page_content = 'Hello world from home';
}

require_once 'views/common/common_bottom.php';
?>