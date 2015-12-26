<?php

function htmlSPC($string, $flags=null) { return htmlspecialchars($string, $flags, 'cp1251'); }
function SPCQA($s) { return str_replace(array("&amp;", "&quot;"), array("&", "\""), SPCQ($s)); }
function SPCQ($s) { return htmlSPC($s, ENT_QUOTES); }
function dierr($typ="", $prm=""){ error_log("$typ $prm"); die("$typ"); }
function RN($s) { return str_replace(array("\r","\n"),array("","<br>"),trim($s)); }
