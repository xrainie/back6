<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  printf('Был выполнен вход с логином %d, вы можете <a href="destroy.php">выйти </a>', $_SESSION['login']);
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="" method="post">
  <input name="login"/>
  <input name="pass" />
  <input type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  $user = 'u53712';
  $pass = '5427961';
  $db = new PDO('mysql:host=localhost;dbname=u53712', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  $stmt = $db->prepare("SELECT user_login, user_passwordHash FROM application WHERE user_login = :log");
  $stmt->bindParam(':log', $log);

  $log = $_POST['login'];

  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_LAZY);

  if(empty($row) or md5($_POST['pass']) != $row['user_passwordHash'])
  {
    print('Неверный логин или пароль');
  }

  else{
    // Если все ок, то авторизуем пользователя.
    $_SESSION['login'] = $_POST['login'];
    // Записываем ID пользователя.
    $_SESSION['uid'] = 123;
    // Делаем перенаправление.
  
    header('Location: ./');
  }

}