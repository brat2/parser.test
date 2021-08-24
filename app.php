<?php
require_once("vendor/autoload.php");
require_once('database.php');
require_once('articleController.php');
require_once('articleModel.php');
require_once('paginator.php');
require_once('parser.php');

$config = array(
  'url' => 'https://habr.com/ru/all/',
  'per_page' => 5,
  'countParse' => 5,
  'host' => 'localhost',
  'username' => 'root',
  'db_name' => 'articledb',
  'password' => '',
  'table_name' => 'articles'
);

$article = new articleController($config);
if ($_POST['parse'] == 1) {
  $parse = $article->parse();
  echo '<meta http-equiv="refresh" content="0;URL=/index.php">';
}
$data = $article->getData(10);
