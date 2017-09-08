<?php

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

?>