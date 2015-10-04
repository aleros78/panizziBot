<?php

class log {

    public static function addLog($sText, $nUserChat = null) {
        $data = new DateTime();
        $filename = 'tempLog/' . $data->format('Ymd') . '-phpinput.log';
        $file = fopen($filename, 'a+');
        fwrite($file, $data->format('YmdHis') . " $sText " . PHP_EOL);
        fclose($file);
    }

}
