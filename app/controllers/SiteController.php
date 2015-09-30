<?php

namespace app\controllers;

use app\lib\Controller;
use app\App;
use app\lib\Db;

class SiteController extends Controller 
{

    public function actionIndex() 
    {

        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
            $title = 'Главная';
            $content = 'Добро пожаловать на сайт!';
        } else {
            $title = 'Home';
            $content = 'Welcome to the site!';
        }

        return $this->render('index', compact('title', 'content'));
    }

    public function actionLogin() 
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['email']) and !empty($_POST['password'])) {
                $email = trim(strip_tags($_POST['email']));
                $password = trim(strip_tags($_POST['password']));

                $pdo = new Db();
                $sql = 'SELECT id, email, password FROM user WHERE email = :email';
                $stmt = $pdo->db->prepare($sql);
                $stmt->bindValue(':email', $email);
                $stmt->execute();
                $row = $stmt->fetch();
                if ($row) {
                    if (password_verify($password, $row['password'])) {

                        setcookie("user", $row['id'] . ':' . bin2hex(openssl_random_pseudo_bytes(16)), 
                            time() + 3600);
                        return header('Location: /profile');
                    } else {
                        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                            $_SESSION['error']['identity'] = 'Неверный email или пароль.';
                        } else {
                            $_SESSION['error']['identity'] = 'Invalid email or password.';
                        }
                    }

                } else {
                    if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                        $_SESSION['error']['identity'] = 'Неверный email или пароль.';
                    } else {
                        $_SESSION['error']['identity'] = 'Invalid email or password.';
                    }
                }
            } else {
                if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                    $_SESSION['error']['fields'] = 'Заполните поля.';
                } else {
                    $_SESSION['error']['fields'] = 'Fill fields.';
                }
            }

        }

        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
            $title = 'Войти';
        } else {
            $title = 'Login';
        }

        return $this->render('login', compact('title'));
    }

    public function actionSignup() 
    { 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['_csrf']) and $_POST['_csrf'] !== $_COOKIE['_csrf']) {
                return header('Location: /400');
            }

            $_SESSION['error'] = [];
            if (!empty($_POST['username']) and 
                !empty($_POST['email']) and !empty($_POST['password'])) {
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                        $_SESSION['error']['email'] = 'Не валидный Email.';
                    } else {
                        $_SESSION['error']['email'] = 'No valid Email.';
                    }
                       
                } else {
                    // unique email
                    $pdo = new Db();
                    $sql = 'SELECT email FROM user WHERE email = :email';
                    $stmt = $pdo->db->prepare($sql);
                    $stmt->bindValue(':email', trim(strip_tags($_POST['email'])));
                    $stmt->execute();
                    $row = $stmt->fetch();
                    if ($row) {
                        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                            $_SESSION['error']['email_unique'] = 
                                'Такой email уже используется.';
                        } else {
                            $_SESSION['error']['email_unique'] = 
                                'This email is already used.';
                        }
                        return header('Location: /signup');
                    }
                  

                    if (mb_strlen($_POST['password']) < 3) {
                        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                            $_SESSION['error']['password'] = 'Маленькая длина пароля.';
                        } else {
                            $_SESSION['error']['password'] = 'Small length of password.';
                        }
                    } else {
                        $username = trim(strip_tags($_POST['username']));
                        $email = trim(strip_tags($_POST['email']));
                        $password = password_hash(trim(strip_tags($_POST['password'])), 
                            PASSWORD_DEFAULT);

                        if ($_FILES['avatar']['name']) {
                            $formats = ['image/gif', 'image/jpg', 'image/png', 'image/jpeg'];

                            if (!in_array($_FILES['avatar']['type'], $formats)) {
                                if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                                    $_SESSION['error']['avatar'] = 
                                        'Расширения картинки должно быть .png, .jpg, .gif.';
                                } else {
                                    $_SESSION['error']['avatar'] = 
                                        'Extensions should be pictures .png, .jpg, .gif.';
                                }

                                return header('Location: /signup');
                            }
                            $uploadDir = dirname($_SERVER['SCRIPT_FILENAME']) . '/upload/';
                            $tokenImage = date("dmYHis") . bin2hex(openssl_random_pseudo_bytes(8));
                            $avatar = $tokenImage . $_FILES['avatar']['name'];
                            $isUploaded = move_uploaded_file($_FILES['avatar']['tmp_name'], 
                                $uploadDir . $avatar);
                        }
  
                        $pdo = new Db();
                        $sql = 'INSERT INTO user (username, email, password, avatar) ';
                        $sql .= 'VALUES (:username, :email, :password, :avatar)';
                        $stmt = $pdo->db->prepare($sql);
                        $stmt->bindValue(':username', $username);
                        $stmt->bindValue(':email', $email);
                        $stmt->bindValue(':password', $password);
                        $stmt->bindValue(':avatar', $avatar);
                        $stmt->execute();
                        return header('Location: /login');
                    }
                }
            } 
        }

        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
            $title = 'Регистрация';
        } else {
            $title = 'Sign Up';
        }
        
        return $this->render('signup', compact('title'));
    }

    public function actionLogout() 
    {
        if (isset($_COOKIE['user'])) {
            unset($_COOKIE['user']);
            setcookie('user', null, -1, '/');

            return header('Location: /');
        } else {
            return header('Location: /400');
        }
    }

    public function actionProfile() 
    {
        if (isset($_COOKIE['user'])) {
            $res = preg_match("/^(?P<id>\d+):/", $_COOKIE['user'],  $matches);
            if ($res) {
                $id = $matches['id'];
                $pdo = new Db();
                $sql = 'SELECT username, email, avatar FROM user WHERE id = :id';
                $stmt = $pdo->db->prepare($sql);
                $stmt->bindValue(':id', $id);
                $stmt->execute();
                $row = $stmt->fetch();
                if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
                    $title = 'Профайл ' . $row['username'];
                } else {
                    $title = 'Profile ' . $row['username'];
                }
                if (!$row) {
                    return header('Location: /400');
                }
            } else {
                return header('Location: /403');
            }

            return $this->render('profile', compact('title', 'row'));

        } else {
            return header('Location: /403');
        }
    }

    public function actionEmailUnique() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = new Db();
            $sql = 'SELECT email FROM user WHERE email = :email';
            $stmt = $pdo->db->prepare($sql);
            $stmt->bindValue(':email', trim(strip_tags($_POST['email'])));
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return header('Location: /404');
        }
    }

    public function actionVerifyPassword() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim(strip_tags($_POST['password']));
            $pdo = new Db();
            $sql = 'SELECT id, email, password FROM user WHERE email = :email';
            $stmt = $pdo->db->prepare($sql);
            $stmt->bindValue(':email', trim(strip_tags($_POST['email'])));
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row) {
                if (password_verify($password, $row['password'])) {
                    return 'done';
                } else {
                    return 'fail';
                }
            } else {
                return 'fail';
            }

        } else {
            return header('Location: /404');
        }
    }
}