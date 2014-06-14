<?php
$timervariable = microtime(true);
//timerlog("test");

function timerlog($name = 'undefined') {
    global $timervariable;

    $a = dirname(__FILE__);
    if ($ff = @fopen($a . "/timer.log", "a")) {
        $a = microtime(true);
        @fputs($ff, $name . " - " . date("Y-m-d H:i:s", $timervariable) . " - " . date("Y-m-d H:i:s", $a) . " - " . sprintf("%.3f", ($a - $timervariable) * 1000) . "ms\n");
        @fclose($ff);
    }
}
?>
