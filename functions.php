<?php

function add_task($arr_tasks, $name, $date, $project, $done) {
  array_unshift($arr_tasks, [
    'task' => $name,
    'deadline' => $date,
    'category' => $project,
    'done' => $done
  ]);
}

function count_tasks($list_tasks, $name_project) {
  $count = 0;
  
  foreach ($list_tasks as $key => $value):
    if ($value['category'] == $name_project) {
      $count = $count + 1;
    }
  endforeach;
  
  if ($name_project == 'Все') {
    return count($list_tasks);
  }
  
  return $count;
}

function renderTemplate($templatePath, $templateData) {
    $result = "";  
  
    if (file_exists($templatePath)) {
      
      ob_start('ob_gzhandler');
      require_once $templatePath;
      $html = ob_get_clean();
      ob_end_flush();
      return $html;
      
    } else {
      
      return $result;
      
    }
}

function show_project_tasks($list_tasks, $name_project) {
  $all_tasks = 'Все';
  $result = [];
  
  if ($name_project == $all_tasks) {
    $result = $list_tasks;
  } else {
    foreach ($list_tasks as $key => $value) {
      if ($value['category'] == $name_project) {
        array_push($result, $value);
      }
    }
  }
  
  return $result;
}

?>