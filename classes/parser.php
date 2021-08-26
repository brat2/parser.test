<?php

class Parser
{
  public function parse(array $ids): array
  {
    $data = [];
    $html = file_get_contents(Config::$url);
    $doc = phpQuery::newDocument($html);
    $articles = $doc->find('.tm-articles-list__item:lt(' . (Config::$count_parse - 1) . ')');
    foreach ($articles as $article) {
      $pqArticle = pq($article);
      $article_id = $pqArticle->attr('id');
      if (in_array($article_id, $ids)) continue;
      $title = $pqArticle->find('.tm-article-snippet__title-link span')->text();
      $url = 'https://habr.com' . $pqArticle->find('.tm-article-snippet__title-link')->attr('href');
      $text = $this->parseText($url);
      $data[] = array(
        'article_id' => $article_id,
        'title' => $title,
        'text' => htmlspecialchars($text),
        'url' => $url
      );
    }
    phpQuery::unloadDocuments();
    return $data;
  }

  private function parseText(string $url): string
  {
    $html = file_get_contents($url);
    $doc = phpQuery::newDocument($html);
    $text = $doc->find('.tm-article-body')->html();
    return $text;
  }
}
