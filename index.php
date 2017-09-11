<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$days = rand(-3, 3);
$task_deadline_ts = strtotime("+" . $days . " day midnight"); // метка времени даты выполнения задачи
$current_ts = strtotime('now midnight'); // текущая метка времени
$current_date = date("d.m.Y", $current_ts); // текущая дата

// запишите сюда дату выполнения задачи в формате дд.мм.гггг
$date_deadline = date("d.m.Y", $task_deadline_ts);

// в эту переменную запишите кол-во дней до даты задачи
$days_until_deadline = $date_deadline - $current_date;


$user_name = 'Дмитрий';

// массивы
$arr_projects = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$arr_tasks = [
  0 => [
    'task' => 'Собеседование в IT компании',
    'deadline' => '01.06.2018',
    'category' => 'Работа',
    'done' => 'Нет'
  ],
  1 => [
    'task' => 'Выполнить тестовое задание',
    'deadline' => '25.05.2018',
    'category' => 'Работа',
    'done' => 'Нет'
  ],
  2 => [
    'task' => 'Сделать задание первого раздела',
    'deadline' => '21.04.2018',
    'category' => 'Учеба',
    'done' => 'Да'
  ],
  3 => [
    'task' => 'Встреча с другом',
    'deadline' => '22.04.2018',
    'category' => 'Входящие',
    'done' => 'Нет'
  ],
  4 => [
    'task' => 'Купить корм для кота',
    'deadline' => '01.06.2018',
    'category' => 'Домашние дела',
    'done' => 'Нет'
  ],
  5 => [
    'task' => 'Заказать пиццу',
    'deadline' => '01.06.2018',
    'category' => 'Домашние дела',
    'done' => 'Нет'
  ]
];

require_once "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['add'])) {
    $page_data = [
      'arr_projects' => $arr_projects,
      'name' => '',
      'date' => '',
      'project' => '',
      'errors' => [],
      'overlay' => $overlay
    ];

    $page_content = renderTemplate('templates/form.php', $page_data);
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['add'])) {
    $name = $_POST['name'] ?? '';
    $project = $_POST['project'] ?? '';
    $date = $_POST['date'] ?? '';
    $required = ['name', 'project', 'date', 'preview'];
    $errors_form = [];
    
    foreach ($_POST as $key => $value) {
      if (in_array($key, $required) && $value == '') {
        array_push($errors_form, $key);
        break;
      }
      
      if (isset($_FILES['preview'])) {
        $file_name_p = $_FILES['preview']['name'];
        $file_path = __DIR__ . '/';
        $file_url = __DIR__ . $file_name_p;

        move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name_p);
        
        if (isset($_FILES['preview'])) {
          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $file_name = $_FILES['preview']['tmp_name'];
          $file_size = $_FILES['preview']['size'];
          $file_type = finfo_file($finfo, $file_name);

          if ($file_type !== 'image/png' || $file_type !== 'image/jpg' || $file_size > 2000000) {
            print("Загрузите картинку в формате PNG или JPG. Максимальный размер файла: 2Мб");
          } else {
            print("<a href='$file_url'>$file_name_p</a>");
          }
        }
      }
      
      if (!count($errors_form)) {
        add_task($arr_tasks, $name, $date, $project, 'Нет');
        $page_data = [
          'arr_projects' => $arr_projects,
          'arr_tasks' => $showed_project_tasks, 
          'show_complete' => $show_complete_tasks
        ];

        $page_content = renderTemplate('templates/index.php', $page_data);
      } else {
        $overlay = 'overlay';
        $page_data = [
          'arr_projects' => $arr_projects,
          'name' => $name,
          'date' => $date,
          'project' => $project,
          'errors' => $errors_form
        ];

        $page_content = renderTemplate('templates/form.php', $page_data);
      }
    }
  }
}

$projects_id = $_GET['id'] ?? 0;

if (!array_key_exists($projects_id, $arr_projects)) {
  http_response_code(404);
} else {
  $showed_project_tasks = show_project_tasks($arr_tasks, $arr_projects[$projects_id]);
  
  $page_data = [
    'arr_projects' => $arr_projects,
    'arr_tasks' => $showed_project_tasks, 
    'show_complete' => $show_complete_tasks
  ];

  $page_content = renderTemplate('templates/index.php', $page_data);

  $layout_data = [
    'title' => 'Дела в порядке!',
    'content' => $page_content,
    'arr_projects' => $arr_projects, 
    'arr_tasks' => $arr_tasks,
    'user_name' => $user_name,
    'projects_id' => $projects_id
  ];

  $layout_content = renderTemplate('templates/layout.php', $layout_data);

  print($layout_content);
}

?>