<?php
/**
*    Класс People для работы с базой данных людей.
*    Класс имеет конструктор, который  либо  берет информацию из БД по id,
*     либо создает человека в БД с заданной информацией, при этом вызываются
*     соответствующие методы readOne() и create(). Также в классе реализованы
*     методы:
*        readOne() - метод чтения информации о человеке из БД. Ему передается
*                    значение ID записи человека, после выполнения SQL запроса
*                    он заполняет поля класса соответствующего человека;
*         create() - метод создает новую запись в БД согласно информации, которую
*                    ввели в поля класса;
*       countAll() - метод расчитывает общее количество записей в БД и возвращает
*                    это значение;
*         delete() - метод удаляет запись о человеке из БД согласно принятому ID.
*                    Возвращает true или false согласно результату выполнения;
*        readAll() - метод возвращает массив данных о всех записях в БД;
*  calculate_age() - метод принимает аргумент "Дата рождения", расчитывает
*                    и возвращает количество полных лет;
*  change_gender() - метод принимает аргумент "Пол" в двоичной системе,
*                    переводит в текстовую (Муж., Жен.) и возвращает
*                    преобразованное значение;
*  format_person() - метод, в зависимости от параметров "Пол" и "Возраст"
*                    (вызывает уже упомянутый выше метод change_gender()),
*                    форматирует человека с преобразованными соответствующими
*                    полями, передавая переменную в которой содержится
*                    код стиля строки.
 */
class People
{
    // подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = 'people';

    //свойства для пункта 6 Задания 1
    private $format_part1="style='background-color: rgb(";
    private $male = '110 69 249 / ';
    private $fmale = '255 111 0 / ';
    private $format_part2="); color: white;'";

    // свойства объекта
    public $id;
    public $name;
    public $surname;
    public $birthday;
    public $gender;
    public $city;

    //Конструктор класса либо берет информацию из БД по id, либо создает человека в БД с заданной информацией
    public function __construct($db, $id = '', $name = '', $surname = '',
      $birthday = '', $gender = '', $city= ''
    ){
      $this->conn = $db;
      //берет информацию по id
      if ($id!='') {
        $this->readOne($id);
      }
      //создает человека в БД с заданной информацией
      else if ($name != ''){
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->city = $city;

        $this->create();
      }
    }

    // метод создания записи о человеке
    function create()
    {
      // запрос MySQL для вставки записей в таблицу БД
      $query = "INSERT INTO " . $this->table_name
             . " SET name=:name, surname=:surname, gender=:gender,"
             . " birthday=:birthday, city=:city";

      // подготавливаем запрос
      $stmt = $this->conn->prepare($query);

      // опубликованные значения
      $this->name=htmlspecialchars(strip_tags($this->name));
      $this->surname=htmlspecialchars(strip_tags($this->surname));
      $this->gender=htmlspecialchars(strip_tags($this->gender));
      $this->birthday=htmlspecialchars(strip_tags($this->birthday));
      $this->city=htmlspecialchars(strip_tags($this->city));

      // привязываем значения
      $stmt->bindParam(":name", $this->name);
      $stmt->bindParam(":surname", $this->surname);
      $stmt->bindParam(":gender", $this->gender);
      $stmt->bindParam(":birthday", $this->birthday);
      $stmt->bindParam(":city", $this->city);


      if ($stmt->execute()) {
          echo "<div class='alert alert-success'>Информация успешно добавлена.</div>";
        } else {
          echo "<div class='alert alert-danger'>Невозможно создать запись.</div>";
        }

    }

    // считать все записи из БД
    function readAll($from_record_num, $records_per_page)
    {
      // запрос MySQL
      $query = "SELECT id, name, surname, birthday, gender, city "
             . "FROM " . $this->table_name
             . " ORDER BY name ASC "
             . "LIMIT {$from_record_num}, {$records_per_page}";

      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    // используется для пагинации данных о людях
    public function countAll()
    {
      // запрос MySQL
      $query = "SELECT id FROM " . $this->table_name . "";
      $stmt = $this->conn->prepare( $query );
      $stmt->execute();
      $num = $stmt->rowCount();

      return $num;
    }

    // удаление данных о человеке
    function delete()
    {
      // запрос MySQL для удаления
      $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      if ($result = $stmt->execute()) {
          return true;
      } else {
          return false;
      }
    }

    // чтение одной записи
    function readOne($id)
    {
      // MySQL запрос для вывода одной записи по ID
      $query = "SELECT name, surname, birthday, gender, city FROM " . $this->table_name
             . " WHERE id = ? "
             . "LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->name = $row['name'];
      $this->surname = $row['surname'];
      $this->birthday = $row['birthday'];
      $this->gender = $row['gender'];
      $this->city = $row['city'];

    }

    //static преобразование даты рождения в возраст (полных лет)
    public static function calculate_age($birthday)
    {
      $birthday_timestamp = strtotime($birthday);
      $age = date('Y') - date('Y', $birthday_timestamp);
      if (date('md', $birthday_timestamp) > date('md')) {
        $age--;
      }
      return $age;
    }

    //static преобразование пола из двоичной системы в текстовую (муж, жен)
    static function change_gender($gnd)
    {

      if ($gnd == 1) {
          $gnd = "Муж.";
      } else {
          $gnd = "Жен.";
      }
      return $gnd;
    }

    //Форматирование человека по возрасту и полу
    function format_person($gender,$birthday)
    {
      $age = People::calculate_age($birthday);
      if ($age <= '20') {
              if ($gender == 1) {
                $str_style = $this->format_part1.$this->male."40%".$this->format_part2;
              } else {
                $str_style = $this->format_part1.$this->fmale."40%".$this->format_part2;
              }
      }
       if ($age > '20'){
                if ($gender == 1){
                  $str_style = $this->format_part1.$this->male."60%".$this->format_part2;
                } else {
                  $str_style = $this->format_part1.$this->fmale."60%".$this->format_part2;
                }

      }

      echo $str_style;

    }

}
