<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Page Not Found</title>
  <style>
    html,
    body {
      box-sizing: border-box;
      height: 100%;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #FDFFEB;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #274D76;
      font-size: 40px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      font-weight: 100;
      text-align: center;
      justify-content: center;
    }

    img {
      width: 50%;
      min-width: 900px;
    }
  </style>
</head>

<body>
  <h1>404 Page Not Found</h1>
  <img src="<?= Flight::request()->base ?>/assets/img/404.png">
</body>

</html>
