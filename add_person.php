<?php

/**
* Автор: Каралкина Ольга
*
* Утилита добавления новой записи в БД
*/

$page_title = "Создание записи о человеке";
require_once "header.php";
?>

<div class='right-button-margin'>
<a href='index.php' class='btn btn-primary pull-right'>
    <span class='glyphicon glyphicon-list'></span> Просмотр всех записей
</a>
</div>

<?php
// проверим, было ли получено значение в $_POST
if ($_POST) {

require 'database.php';
require 'people_class.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();
$output_people = new People($db,$id,
                            $_POST['name'], $_POST['surname'],
                            $_POST['birthday'], $_POST['gender'],
                            $_POST['city']);
}
?>
<!-- HTML-формы для создания записи -->
<form action="add_person.php" method="post">
<table class='table table-hover table-responsive table-bordered'>
  <tr>
      <td class="head_td">Имя (только буквы)</td>
      <td>
        <input type='text' id='name' name='name' class='form-control'
               required  pattern="^[A-Za-zА-Яа-яЁё\s]{2,}">
      </td>
  </tr>

  <tr>
      <td class="head_td">Фамилия (только буквы)</td>
      <td><input type='text' id='surname' name='surname' class='form-control'
                 required pattern="^[A-Za-zА-Яа-яЁё\s]{2,}"/>
      </td>
  </tr>

  <tr>
      <td class="head_td">Пол</td>
      <td>
        <select class='form-control' name='gender' required>
          <option value=''>Выбрать...</option>
          <option value='1'>Муж</option>
          <option value='0'>Жен</option>
        </select>
      </td>
  </tr>

  <tr>
      <td class="head_td">Дата рождения</td>
      <td>
        <input id="date" type='text' name='birthday' class='form-control'
                   required>
      </td>
  </tr>

  <tr>
      <td class="head_td">Город рождения</td>
      <td>
        <input type='text' name='city' class='form-control' required>
      </td>
  </tr>

  <tr>
      <td></td>
      <td>
          <button type="submit" class="btn btn-primary">Создать</button>
      </td>
  </tr>
</table>
</form>

<?php

require_once "footer.php";
?>