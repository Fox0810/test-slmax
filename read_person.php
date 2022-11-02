<?php

/**
* Автор: Каралкина Ольга
*
* Утилита чтения данных одного выбранного польщователя из БД
*/

 // установка заголовка страницы
 $page_title = "Запись о выбраном человеке";
 // получаем ID товара
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: отсутствует ID.');

// подключим файлы, необходимые для подключения к базе данных и файлы с объектами
require 'database.php';
require 'people_class.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// создадим экземпляр класса output_people
$output_people = new People($db,$id);

// устанавливаем свойство ID человека для чтения
$output_people->id = $id;
 //подключаем вернюю часть страницы
 require_once "header.php";
 ?>

 <!-- ссылка на все вывод всех записей -->
 <div class='right-button-margin'>
     <a href='index.php' class='btn btn-primary pull-right'>
         <span class='glyphicon glyphicon-list'></span> Просмотр всех записей
     </a>
 </div>

 <!-- HTML-таблица для отображения информации о записях из полей класса -->
<table class='table table-hover table-responsive table-bordered'>
 <tr>
     <td class="head_td">Имя</td>
     <td><?php echo $output_people->name; ?></td>
 </tr>
 <tr>
     <td class="head_td">Фамилия</td>
     <td><?php echo $output_people->surname; ?></td>
 </tr>
 <tr>
     <td class="head_td">Пол</td>
     <!-- меняем двоичную систему на текстовую (Муж., Жен) -->
     <td><?php echo People::change_gender($output_people->gender); ?></td>
 </tr>
 <tr>
     <td class="head_td">Дата рождения</td>
     <td><?php echo $output_people->birthday; ?></td>
 </tr>
 <tr>
     <td class="head_td">Город рождения</td>
     <td><?php echo $output_people->city; ?></td>
 </tr>
</table>

 <?php
 // подключаем нижнюю часть страницы
 require_once "footer.php";
?>
