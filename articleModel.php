<?php

class articleModel
{

  private $conn;
  private $table_name;

  public function __construct($db, $table_name)
  {
    $this->conn = $db;
    $this->table_name = $table_name;
  }

  public function getIds(): array
  {
    $query = "SELECT  article_id  FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    if ($num == 0) return $article_id = [];

    $article_id = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $article_id[] = $row['article_id'];
    }
    return $article_id;
  }

  public function create($data)
  {
    $data = array_reverse($data);
    $query = "INSERT INTO " . $this->table_name . " SET  article_id=:article_id, title=:title, text=:text, url=:url";
    $stmt = $this->conn->prepare($query);
    foreach ($data as $item) {
      $value = array(
        'article_id' => $item['article_id'],
        'title' => $item['title'],
        'text' =>  $item['text'],
        'url' =>  $item['url']
      );
      $stmt->execute($value);
    }
  }

  public function read($page, $per_page): array
  {
    $total = 47;
    $page222  = Paginator::get($page, $per_page, $total);

    $query = "SELECT  *  FROM " . $this->table_name . "  ORDER BY id DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    if ($num == 0) return $products_arr = [];

    $products_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      extract($row);
      $text = htmlspecialchars_decode($text);
      $text = strip_tags($text);
      $text = substr($text, 0, 200);
      $text = rtrim($text, "!,.-");
      $text = substr($text, 0, strrpos($text, ' '));
      $text = $text . "… ";
      $article = array(
        "id" => $id,
        "article_id" => $article_id,
        "title" => $title,
        "text" => $text,
        "url" => $url
      );

      array_push($products_arr, $article);
    }

    http_response_code(200);
    return $products_arr;
  }

  public function readOne($id): array
  {
    $query = "SELECT  text  FROM " . $this->table_name . "  WHERE article_id = " . $id . " LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($row);
    $text = htmlspecialchars_decode($text);
    $article = ["text" => $text];

    http_response_code(200);
    return $article;
  }
}
