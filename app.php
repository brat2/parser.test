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
  'count_parse' => 5,
  'host' => 'localhost',
  'username' => 'root',
  'db_name' => 'articledb',
  'password' => '',
  'table_name' => 'articles'
);

$article = new Controller($config);
if ($_POST['parse'] == true) $article->parse();

if ($_GET['fulltext']) {
  $full_text = $article->getFullText($_GET['fulltext']);
  echo $data = json_encode($full_text);
  exit;
}

$data = $article->getData($_GET['page'] ?? 1);
echo $data = json_encode($data);
