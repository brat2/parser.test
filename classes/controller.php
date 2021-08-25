<?php

class Controller
{
  private $url;
  private $per_page;
  private $count_parse;
  private $table_name;
  private $db;

  public function __construct(array $arr)
  {
    $this->url = $arr['url'];
    $this->per_page = $arr['per_page'];
    $this->count_parse = $arr['count_parse'];
    $this->table_name = $arr['table_name'];

    $database = new Database($arr);
    $this->db = $database->getConnection();
  }

  public function getData($page = 1): array
  {
    $articles = new Article($this->db, $this->table_name);
    return $articles->read($page, $this->per_page);
  }

  public function getFullText($id)
  {
    $articles = new Article($this->db, $this->table_name);
    return $articles->readOne($id);
  }

  public function parse(): void
  {
    $parser = new Parser();
    $articles = new Article($this->db, $this->table_name);
    $ids = $articles->getIds();
    $data = $parser->parse($this->url, $this->count_parse, $ids);

    $articles->create($data);
  }
}
