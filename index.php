<?php

if (!session_id()) {
    session_start();
}

require_once('./initialize.php');

$app = new App();