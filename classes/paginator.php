<?php

class Paginator
{
  public static function get($current_page, $per_page, $total): array
  {

    $last = ceil($total / $per_page);

    $arr[0] = self::getLink($current_page, $last, -2, '<<');
    $arr[1] = self::getLink($current_page, $last, -1, ($current_page - 1));
    $arr[2] = self::getLink($current_page, $last, 0, $current_page);
    $arr[3] = self::getLink($current_page, $last, 1, ($current_page + 1));
    $arr[4] = self::getLink($current_page, $last, 2, '>>');
    return $arr;
  }

  protected static function getLink($current, $last, $ofset, $lable)
  {
    $page = ($current + $ofset);
    if ($current == 1 && $ofset < 0) return ' ';
    if ($current == $last && $ofset > 0) return ' ';
    if ($ofset == 0) return ' <b>' . $current . '</b> ';
    if ($ofset == -2) $page = 1;
    if ($ofset == 2) $page = $last;
    $link = ' <a href="/app.php?page=' . $page  . '">' . $lable . '</a> ';
    return $link;
  }
}
