<?php
$s = 'Điện thoại,Apple';
$a = explode(',', $s);
$a = array_map(function ($e) { return "<span class='badge text-bg-warning'>$e</span>"; }, $a);
var_dump(implode($a));