<?php

class articleModel
{
  public function create ($db): void
  {
    # code...
  }

  public function selectAll($db)
  {
    return [[
      'article_id' => 1,
      'title'=> 'Заголовок статьи 1',
      'text'=> 'Этого текст принадлежит статье с идентификатором - 1. Таких статей может быть много'
    ],
    [
      'article_id' => 2,
      'title'=> 'Заголовок статьи 2',
      'text'=> 'Этого текст принадлежит статье с идентификатором - 2. Таких статей может быть много'
    ]];
  }
}