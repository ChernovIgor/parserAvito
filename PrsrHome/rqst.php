<?php

$id = $_GET['id'];

$url ='http://dom.mingkh.ru/bashkortostan/salavat/';

$url .= $id;
$s = file_get_contents($url);