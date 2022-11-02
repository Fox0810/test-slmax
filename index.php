<?php

/**
* Автор: Каралкина Ольга
*
* Утилита вывода всех записей из БД и их форматирования
*/

 //Пагинация
  // страница, указанная в параметре URL, страница по умолчанию - 1
  $page = isset($_GET['page']) ? $_GET['page'] : 1;

  // устанавливаем ограничение количества записей на странице
  $records_per_page = 6;

  // подсчитываем лимит запроса
  $from_record_num = ($records_per_page * $page) - $records_per_page;

  // подключим файлы, необходимые для подключения к базе данных и файл класса
  require 'database.php';
  require 'people_class.php';

  // получаем соединение с базой данных
  $database = new Database();
  $db = $database->getConnection();

  // создаем экземпляр класса и массив данных всеx записей
  $output_people = new People($db);
  $stmt = $output_people->readAll($from_record_num, $records_per_page,$db);
  $num = $stmt->rowCount();

  // подсчёт всех записей в базе данных, чтобы подсчитать общее количество страниц
  $total_rows = $output_people->countAll();

  // установка заголовка страницы
  $page_title = "Вывод сведений о людях";

  // подключаем вернюю часть страницы
  require_once "header.php";
?>

  <div class='right-button-margin'>
      <a href='add_person.php' class='btn btn-default pull-right'>Добавить данные о человеке</a>
  </div>

<?php
  // отображаем сведения, если они есть
  if ($num > 0) {
    echo "<table class='table table-hover table-responsive table-bordered'>";
      echo "<tr>";
        echo "<th>Имя</th>";
        echo "<th>Фамилия</th>";
        echo "<th>Возраст</th>";
        echo "<th>Пол</th>";
        echo "<th>Город рождения</th>";
        echo "<th>Действия</th>";
      echo "</tr>";
      // проходим по массиву данных и построчно выводим
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        echo "<tr ";
        echo $output_people->format_person($gender,$birthday);
        echo '</tr>';
          echo "<td>{$name}</td>";
          echo "<td>{$surname}</td>";
          echo "<td>";
          echo People::calculate_age($birthday);
          echo "</td>";
          echo "<td>";
          echo People::change_gender($gender);
          echo "</td>";
          echo "<td>{$city}</td>";
          echo "<td>";
          // ссылки для просмотра, редактирования и удаления товара
          echo "<a href='read_person.php?id={$id}' class='btn btn-primary left-margin'>
                <span class='glyphicon glyphicon-list'></span> Просмотр
                </a>

                <a delete-id='{$id}' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Удалить
                </a>";
          echo "</td>";

        echo "</tr>";

        }

    echo "</table>";

    // страница, на которой используется пагинация
    $page_url = "index.php?";

    // пагинация
    include_once 'paging.php';
  }

  // сообщим пользователю, что сведений нет
  else {
      echo "<div class='alert alert-info'>Информация не найдена.</div>";
  }

?>
   <!-- Вывод информационной таблицы форматирования -->
   <table class='table table-bordered table-sm'>
     <thead>
      <tr>
        <td><h4>Форматирование мужчин по возрасту до и после 20лет</h4></td>
        <td class="smal_male_td">До</td>
        <td class="male_td">После</td>
      </tr>
    </thead>
      <tr>
        <td><h4>Форматирование женщин по возрасту до и после 20лет</h4></td>
        <td class="smal_fmale_td">До</td>
        <td class="fmale_td">После</td>
      </tr>
   </table>
<?php
  // подключаем нижнюю часть страницы
  require_once "footer.php";
?>

