<?php

$show_complete_tasks = $templateData['show_complete'];
$arr_tasks = $templateData['arr_tasks_sh'];

?>
                

                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <div class="radio-button-group">
                        <label class="radio-button">
                            <input class="radio-button__input visually-hidden" type="radio" name="radio" checked="">
                            <span class="radio-button__text">Все задачи</span>
                        </label>

                        <label class="radio-button">
                            <input class="radio-button__input visually-hidden" type="radio" name="radio">
                            <span class="radio-button__text">Повестка дня</span>
                        </label>

                        <label class="radio-button">
                            <input class="radio-button__input visually-hidden" type="radio" name="radio">
                            <span class="radio-button__text">Завтра</span>
                        </label>

                        <label class="radio-button">
                            <input class="radio-button__input visually-hidden" type="radio" name="radio">
                            <span class="radio-button__text">Просроченные</span>
                        </label>
                    </div>

                    <label class="checkbox">
                        <input id="show-complete-tasks" class="checkbox__input visually-hidden" type="checkbox" <?php if ($show_complete_tasks == 1) echo "checked"; ?>>
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach ($arr_tasks as $key => $value): ?>
                        <tr class="tasks__item task <?php if ($value['done'] == 'Да') echo "task--completed"; ?>">
                            <td class="task__select">
                                <label class="checkbox task__checkbox">
                                    <input class="checkbox__input visually-hidden" type="checkbox" <?php if ($value['done'] == 'Да') echo "checked"; ?>>
                                    <span class="checkbox__text"><?=$value['task']; ?></span>
                                </label>
                            </td>

                            <td class="task__date">
                                <?=$value['deadline']; ?>
                            </td>

                            <td class="task__controls">
                                <button class="expand-control" type="button" name="button"><?=$value['task']; ?></button>

                                <ul class="expand-list hidden">
                                    <li class="expand-list__item">
                                        <a href="#">Выполнить</a>
                                    </li>

                                    <li class="expand-list__item">
                                        <a href="#">Удалить</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                
               
              
<!--
             $errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
  if (isset($_POST['addf'])) {
    $required = ['name', 'date', 'project'];
    
    foreach ($_POST as $key => $value) {
      if (in_array($key, $required) && $value == '') {
        array_push($errors, $key);
      }
    }
    
    if (!count($errors)) {
      if (isset($_FILES['preview'])) {
        $file_name = $_FILES['preview']['name'];
        $file_path = __DIR__ . '/';
        $file_url = '/' . $file_name;
        
        move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name);
      }
      
      $new_task = [
        'task' => $_POST['name'],
        'deadline' => $_POST['date'],
        'category' => $_POST['project'],
        'done' => 'Нет'
      ];
      array_unshift($arr_tasks, $new_task);
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

if (isset($_GET['add']) || count($errors)) {
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
-->
