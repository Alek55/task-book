<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/index.js"></script>
</head>
<body>
<main class="container">
    <header class="row justify-content-between">
        <h1><a href="index">Админ-панель</a></h1>
        <a class="btn btn-primary" href="/admin/logout">Выход</a>
    </header>
    <?=$content;?>
</main>
</body>
</html>