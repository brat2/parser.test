<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once("vendor/autoload.php");
require_once('classes/database.php');
require_once('classes/controller.php');
require_once('classes/article.php');
require_once('classes/paginator.php');
require_once('classes/parser.php');

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
if ($_POST['parse'] == true) {
  $parse = $article->parse();
}
if ($_GET['fulltext']) {
  $parse = $article->getFullText($_GET['fulltext']);
  echo $data = json_encode($parse);
  exit;
}

$page = $_GET['page'] ?? 1;

$data = $article->getData($page);
echo $data = json_encode($data);
