<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Задачник</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/index.js"></script>
</head>
<body>
<main class="container">
    <div class="modal fade" id="authAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Вход в админ-панель</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/auth" method="post" name="authForm">
                        <?php if(isset($_SESSION['error_auth'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php
                                echo $_SESSION['error_auth'];
                                unset($_SESSION['error_auth']);
                                ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input type="text" name="login" class="form-control" id="login" aria-describedby="emailHelp">
                            <p class="error" id="error-alert-login"></p>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password">
                            <p class="error" id="error-alert-password"></p>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); checkForm.validate('authForm'); checkForm.auth();">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <header class="row justify-content-between">
        <h1><a href="/">Задачник</a></h1>
        <p>
            <button id="openModalAuth" type="button" class="btn btn-primary" data-toggle="modal" data-target="#authAdmin">Войти в админку</button>
        </p>
    </header>
    <?=$content;?>
</main>
</body>
</html>