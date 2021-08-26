<?php

class Controller
{
  private $article;

  public function __construct()
  {
    $db = (new Database)->getConnection();
    $this->article = new Article($db);
  }

  public function getData(int $page = 1): array
  { 
    return $this->article->read($page);
  }

  public function getFullText(int $id): array
  {
    return $this->article->readOne($id);
  }

  public function parse(): void
  {
    $parser = new Parser();
    $ids = $this->article->getIds();
    $data = $parser->parse($ids);
    $this->article->create($data);
  }
}
