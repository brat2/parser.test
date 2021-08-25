<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Парсер</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

  <style>
    .article{
      background: #f1ece5;
      padding: 20px;
      margin-bottom: 20px;
    }
    #info {
      color: blueviolet;
    }
   
    .full {
      width: 100%;
      display: none;
    }

    .full img {
      width: 100%;
    }
  </style>
</head>

<body>
  <button id="parse">Загрузить</button>
  <span id="info"></span>
  <hr>
  <div class="articles"></div>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <script>
    $(document).ready(function() {
      $.getJSON("app.php", function(data) {
        getData(data);
      });

      $("#parse").click(function() {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'app.php',
          data: "parse=true",
          beforeSend: function() {
            $("#info").text('идёт загрузка с сайта!');
          },
          success: function(data) {
            $(".articles").empty();
            $("#info").empty();
            getData(data);
          }
        });
      });

      $(document).on('click', '.fullText', function(e) {
        var id = $(this).parent().attr('id');
        var but = $(this);
        var url = "app.php?id=" + id;
        $.getJSON(url, function(data) {
          $(but).after("<div class='full' id='full_" + id + "'>" + data.text + "</div>");
          Fancybox.show([{
            src: "#full_" + id,
            type: "inline"
          }]);

        });
      });

      function getData(data) {
        $.each(data, function(key, val) {
          content = `
       <div id="` + val.article_id + `" class="article"><h3><a href="` + val.url + `" target="_blank">` + val.title + `</a></h3>
        <p>` + val.text + `</p>
        <button class="fullText" > полный текст</button></div>`;

          $(".articles").append(content);
        });
      }
    });
  </script>
</body>

</html>