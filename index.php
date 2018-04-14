<?php

require_once("nct-v3.php");
date_default_timezone_set('Asia/Ho_Chi_Minh');

$nct = new NCT;

print_r($nct -> getVideoSearch("em chua 18",1,5));
print_r($nct -> getSongSearch("em chua 18",1,5));
print_r($nct -> getLyric("l6FPmkS3Yf8f"));
print_r($nct -> getUSUKVideoChart());
print_r($nct -> getPlaylistDetail("TT0XtXw7C3F6"));
?>