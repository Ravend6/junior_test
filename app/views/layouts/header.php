<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"> 
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="all">
    <title>Junior Test - <?= $title ?></title>
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/app.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-sm-2">
                <div id="select-lang">
                    <select class="form-control" id="lang" name="lang">
                        <?php if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru'): ?>
                            <option>Выберите язык</option>
                        <?php else: ?>
                            <option>Choose language</option>
                        <?php endif; ?>
                        <option>en</option>
                        <option>ru</option>
                    </select>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col-sm-12">
                <nav>
                    <ul>
                        <?php if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru'): ?>
                            <li><a href="/">Главная</a></li>
                            <?php if (isset($_COOKIE['user'])): ?>
                                <li><a href="/profile">Профиль</a></li>
                                <li><a href="/logout">Выйти</a></li>
                            <?php else: ?>
                                <li><a href="/login">Войти</a></li>
                                <li><a href="/signup">Регистрация</a></li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li><a href="/">Home</a></li>
                             <?php if (isset($_COOKIE['user'])): ?>
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/logout">Logout</a></li>
                            <?php else: ?>
                                <li><a href="/login">Login</a></li>
                                <li><a href="/signup">Sign Up</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>   
        </div>
        
    
