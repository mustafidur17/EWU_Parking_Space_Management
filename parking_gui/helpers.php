<?php
// helpers.php — small utilities (redirect and safe() for HTML escaping)
function redirect($path) {
    header("Location: " . $path);
    exit();
}
function safe($s) {
    return htmlspecialchars((string)$s ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
?>