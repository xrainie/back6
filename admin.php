<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');



// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
$user = 'u53712';
$pass = '5427961';
$db = new PDO('mysql:host=localhost;dbname=u53712', $user, $pass,
[PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


$stmt = $db->prepare("SELECT id, name, email, year, gender, limbs, biography, user_login FROM application ");

$stmt->execute();
print("<style>
table {
 width: 100%;
 border-spacing: 1px;
 border-collapse: collapse;
}
td, th {
  padding: 3px; /* Поля вокруг содержимого таблицы */
  border: 1px solid black; /* Параметры рамки */
 }
</style>");
print("<table><tr><th>id</th><th>Имя</th><th>Год рождения</th><th>Почта</th><th>Пол</th><th>Количество конечностей</th><th>Биография</th><th>Сверхспособности</th><th>Логин</th></tr>");

While($row = $stmt->fetch(PDO::FETCH_LAZY))
{
  print("<tr><td>" . $row["id"] . "</td>");
  print("<td>" . $row["name"] . "</td>");
  print("<td>" . $row["year"] . "</td>");
  print("<td>" . $row["email"] . "</td>");
  print("<td>" . $row["gender"] . "</td>");
  print("<td>" . $row["limbs"] . "</td>");
  print("<td>" . $row["biography"] . "</td>");
  $q = $db->prepare("SELECT ability FROM abilities WHERE id = :id");
  $q->bindParam(':id', $id);
  $id = $row['id'];
  $q->execute();
  print("<td>");
  While($abil = $q->fetch(PDO::FETCH_LAZY))
  {
    print("<p>" . $abil['ability'] . "</p>");
  }
  print("</td>");
  print("<td>" . $row["user_login"] . "</td>");
  print("<td><p><a href='update.php?id=" . $row["id"] . "'>Изменить данные</a></p>
  <p><a href='deleteUser.php?id=" . $row["id"] . "'>Удалить пользователя</a></td></tr>");
}

$stmt = $db->prepare("SELECT ability, COUNT(*) as count FROM abilities GROUP BY ability ");
$stmt->execute();

print("<h3>Количество людей с сверхспособностью: </h3>");
while($row = $stmt->fetch(PDO::FETCH_LAZY))
{
  print("<p>" . $row['ability'] . ": " . $row['count'] . "</p>");
}