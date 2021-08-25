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
    .articles {
      padding: 20px;
    }

    .article {
      background: #f1ece5;
      padding: 20px;
      margin-bottom: 20px;
    }

    .paginate {
      text-align: center;
      padding-bottom: 20px;
      font-size: 14pt;
    }

    #info {
      color: purple;
      height: 14pt;
      padding: 5px 0 0 0;
    }

    .full {
      width: 100%;
      display: none;
    }

    .full img {
      width: 100%;
    }

    .top {
      text-align: center;
      padding: 10px 0 0 0;
    }
  </style>
</head>

<body>
  <div class="top">
    <button id="parse">Загрузить</button>
    <div id="info"></div>
  </div>

  <hr>
  <div class="articles"></div>
  <div class="paginate"></div>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js">
  </script>
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
            getData(data);
          }
        });
      });

      $(document).on('click', '.fullText', function(e) {
        var id = $(this).parent().attr('id');
        var but = $(this);
        var url = "app.php?fulltext=" + id;
        $.getJSON(url, function(data) {
          $(but).after("<div class='full' id='full_" + id + "'>" + data.text + "</div>");
          Fancybox.show([{
            src: "#full_" + id,
            type: "inline"
          }]);
        });
      });

      $(document).on('click', '.paginate a', function(e) {
        var url = $(this).attr('href');
        $.getJSON(url, function(data) {
          getData(data);
        });
        return false;
      });

      function getData(data) {
        $(".articles").empty();
        $(".paginate").empty();
        $("#info").empty();
        $.each(data.articles, function(key, val) {
          content = `
       <div id="` + val.article_id + `" class="article"><h4><a href="` + val.url + `" target="_blank">` + val.title + `</a></h4>
        <p>` + val.text + `</p>
        <button class="fullText" >полный текст</button></div>`;
          $(".articles").append(content);
        });
        $.each(data.meta, function(key, val) {
          $(".paginate").append(val);
        });
      }
    });
  </script>
</body>

</html>