<?php

function GetInt4d($data, $pos)
{
    $value = ord($data[$pos]) | (ord($data[$pos+1]) << 8) |
        (ord($data[$pos+2]) << 16) | (ord($data[$pos+3]) << 24);
    if ($value >= 4294967294)
    {
        $value = -2;
    }
    return $value;
}

class OLERead {
    var $data;
    function read($sFileName) {
        if (!is_readable($sFileName)) {
            return false;
        }
        $this->data = file_get_contents($sFileName);
        if (substr($this->data, 0, 8) != chr(0xD0).chr(0xCF).chr(0x11).chr(0xE0).chr(0xA1).chr(0xB1).chr(0x1A).chr(0xE1)) {
            return false;
        }
        return true;
    }
}
