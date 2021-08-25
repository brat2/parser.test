<?php

class Parser
{
  public function parse($url, $count, $ids): array
  {
    $arr = [];
    $html = file_get_contents($url);

    $doc = phpQuery::newDocument($html);
    $articles = $doc->find('.tm-articles-list__item:lt(' . ($count - 1) . ')');
    foreach ($articles as $article) {
      $pqArticle = pq($article);

      $article_id = $pqArticle->attr('id');
      if (in_array($article_id, $ids)) continue;

      $title = $pqArticle->find('.tm-article-snippet__title-link span')->text();

      $url = 'https://habr.com' . $pqArticle->find('.tm-article-snippet__title-link')->attr('href');

      $text = $this->parseText($url);

      $arr[] = array(
        'article_id' => $article_id,
        'title' => $title,
        'text' => htmlspecialchars($text),
        'url' => $url

      );
    }

    phpQuery::unloadDocuments();
    return $arr;
  }

  private function parseText($url)
  {
    $html = file_get_contents($url);
    $doc = phpQuery::newDocument($html);
    $text = $doc->find('.tm-article-body')->html();

    return $text;
  }
}
