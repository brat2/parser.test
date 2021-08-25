<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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
if ($_POST['parse'] == true) {
  $parse = $article->parse();
}
if (isset($_GET['id'])) {
  $parse = $article->getFullText($_GET['id']);
  echo $data = json_encode($parse);
  exit;
}
$data = $article->getData();
echo $data = json_encode($data);
