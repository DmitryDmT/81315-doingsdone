<?php
require_once "functions.php";
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

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    if (isset($_POST['addf'])) {
        $required = ['name', 'date', 'project'];
    
        foreach ($_POST as $key => $value) {
            if (in_array($key, $required) && $value == '') {
                array_push($errors, $key);
            } else {
                if ($key == 'date') {
                    if ($value !== date('d.m.Y', strtotime($value))) {
                        array_push($errors, $key);
                    }
                }
            }
        }
    
        if (empty($errors)) {
            $new_task = [
                'task' => $_POST['name'],
                'deadline' => $_POST['date'],
                'category' => $arr_projects[$_POST['project']],
                'done' => 'Нет'
            ];
            array_unshift($arr_tasks, $new_task);

            if(isset($_FILES['preview'])) {
                $file_name = $_FILES['preview']['name'];
                $file_path = __DIR__ . '/';
                $file_url = '/' . $file_name;

                move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name);
                print("<a href='$file_url'>$file_name</a>");
            }
        }
    }
}

$projects_id = $_GET['id'] ?? 0;

if (!array_key_exists($projects_id, $arr_projects)) {
    http_response_code(404);
} else {
    $showed_project_tasks = show_project_tasks($arr_tasks, $arr_projects[$projects_id]);
}

$page_data = [
    'arr_projects' => $arr_projects,
    'arr_tasks_sh' => $showed_project_tasks, 
    'show_complete' => $show_complete_tasks
];
$page_content = renderTemplate('templates/index.php', $page_data);

if (isset($_GET['add']) || !empty($errors)) {
    $page_data_m = [
        'arr_projects' => $arr_projects,
        'arr_tasks_sh' => $showed_project_tasks, 
        'errors' => $errors
    ];

    $page_content_m = renderTemplate('templates/form.php', $page_data_m);
}


$layout_data = [
    'title' => 'Дела в порядке!',
    'content' => $page_content,
    'form' => $page_content_m,
    'arr_projects' => $arr_projects, 
    'arr_tasks' => $arr_tasks,
    'user_name' => $user_name,
    'projects_id' => $projects_id
];

$layout_content = renderTemplate('templates/layout.php', $layout_data);

print($layout_content);

?>