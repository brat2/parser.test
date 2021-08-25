<?php

class Paginator
{
  private $current;
  private $total;
  private $last;

  public function __construct(int $current, int $total)
  {
    $this->current = $current;
    $this->total = $total;
    $this->last = ceil($total / Config::$per_page);
  }

  public function get(): array
  {
    $data[0] = $this->getLink(-2, '<<');
    $data[1] = $this->getLink(-1, ($this->current - 1));
    $data[2] = $this->getLink(0, $this->current);
    $data[3] = $this->getLink(1, ($this->current + 1));
    $data[4] = $this->getLink(2, '>>');
    return $data;
  }

  protected function getLink(int $ofset, string $lable): string
  {
    $page = ($this->current + $ofset);
    if ($this->current == 1 && $ofset < 0) return ' ';
    if ($this->current == $this->last && $ofset > 0) return ' ';
    if ($ofset == 0) return ' <b>' . $this->current . '</b> ';
    if ($ofset == -2) $page = 1;
    if ($ofset == 2) $page = $this->last;
    $link = ' <a href="/app.php?page=' . $page  . '">' . $lable . '</a> ';
    return $link;
  }
}
