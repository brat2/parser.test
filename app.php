<?php
require_once('db.php');
require_once('articleController.php');
require_once('articleModel.php');
require_once('paginator.php');
require_once('parser.php');

$url = 'https:\/\/habr.com\/';
$countPag = 3;
$dbName = 'articleDb';
$dbPass = 'a1234b';
$tableName = 'article';
