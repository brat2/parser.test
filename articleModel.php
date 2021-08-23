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

  public function create($data)
  {
    $query = "INSERT INTO " . $this->table_name . " SET  article_id=:article_id, title=:title, text=:text, url=:url";

    $stmt = $this->conn->prepare($query);
    $value = array(
      'article_id' => $data[0]['article_id'],
      'title' => $data[0]['title'],
      'text' =>  $data[0]['text'],
      'url' =>  $data[0]['url']
    );

    if ($stmt->execute($value)) return true;

    return false;
  }

  public function read($page, $per_page): array
  {
    $total = 47;
    $page222  = Paginator::get($page, $per_page, $total);

    $query = "SELECT  *  FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    if ($num == 0) return $products_arr = [];

    $products_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      extract($row);

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
}
