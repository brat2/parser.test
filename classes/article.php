<?php

class Article
{
  private $conn;
  private $total;

  public function __construct(PDO $db)
  {
    $this->conn = $db;
    $this->total = $this->conn->query("SELECT COUNT(*) as count FROM " . Config::$table_name)->fetchColumn();
  }

  public function read(int $page): array
  {
    $from = (($page - 1) * Config::$per_page);
    $query = "SELECT  *  FROM " . Config::$table_name . "  ORDER BY id DESC LIMIT " . $from . ", " . Config::$per_page;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num == 0) return $data = [];
    $data = ['articles' => [], 'meta' => []];
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
      array_push($data['articles'], $article);
    }
    $data['meta'] = (new Paginator($page, $this->total))->get();
    http_response_code(200);
    return $data;
  }

  public function getIds(): array
  {
    $query = "SELECT  article_id  FROM " . Config::$table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num == 0) return $article_id = [];
    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $row['article_id'];
    }
    return $data;
  }

  public function create(array $data): void
  {
    $data = array_reverse($data);
    $query = "INSERT INTO " . Config::$table_name . " SET  article_id=:article_id, title=:title, text=:text, url=:url";
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

  public function readOne(int $id): array
  {
    $query = "SELECT  text  FROM " . Config::$table_name . "  WHERE article_id = " . $id . " LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $text = htmlspecialchars_decode($text);
    $data = ["text" => $text];
    http_response_code(200);
    return $data;
  }
}
