<?php

class Parser
{
  public function parse($url, $count): array
  {
    $arr = [];
    for ($i = 0; $i < $count; $i++) {
      $arr[] = array(
        'article_id' => $i + 1,
        'title' => 'Заголовок статьи 1',
        'text' => 'Этого текст принадлежит статье с идентификатором - 1. Таких статей может быть много',
        'url' => $url
      );
    }
    return $arr;
  }
}
