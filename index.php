<?php
require_once('app.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Парсер</title>
</head>

<body>
  <form action="app.php" method="post">
    <input type="hidden" name="parse" value="1">
    <input type="submit" value="Загрузить">
  </form>
  <?php

  foreach ($data as $dat) {
    $text = htmlspecialchars_decode($dat['text']);
    $text = strip_tags($text);
    $text = substr($text, 0, 200);
    $text = rtrim($text, "!,.-");
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text."… ";
    

    echo '<h3><a href="' . $dat['url'] . '" target="_blank">' . $dat['title'] . '</a></h3>';
    echo '<p>' . $text . '</p>';
    echo '<button> полный текст</button>';
  }
  ?>
</body>

</html>