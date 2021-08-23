<?php

class Paginator
{
  public static function get($current_page, $per_page, $total): array
  {
    $last = ceil($total / $per_page);
    $arr = [
      'total' => $total,
      'first' => 1,
      'first_url' => self::getLink($current_page, $last, 'first'),
      'last' => $last,
      'last_url' => self::getLink($current_page, $last, 'last'),
      'previous' => ($current_page - 1),
      'previous_url' => self::getLink($current_page, $last, 'previous'),
      'next' => ($current_page + 1),
      'next_url' => self::getLink($current_page, $last, 'next'),
      'per_page' => $per_page,
      'current_page' => $current_page
    ];

    return $arr;
  }

  protected static function getLink($current, $last, $type)
  {
    return $type;
  }
}
