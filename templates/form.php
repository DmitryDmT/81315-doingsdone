<?php
 
 $name = $_POST['name'] ?? '';
 $project = $_POST['project'] ?? '';
 $date = $_POST['date'] ?? '';

?>
   <div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>

    <form class="form" action="index.php" method="post" enctype="multipart/form-data">
      <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?php in_array('name', $templateData['errors']) ? 'form__input--error' : ''; ?>" type="text" name="name" id="name" value="<?=$name;?>" placeholder="Введите название">
        
      </div>

      <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select" name="project" id="project">
          <?php foreach ($templateData['arr_projects'] as $key => $value): ?>
            <option value="<?=$key;?>"<?= ($key == $projects_id) ? 'selected' : '';?>><?=$value;?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form__row">
        <label class="form__label" for="date">Дата выполнения <sup>*</sup></label>

        <input class="form__input form__input--date" type="text" name="date" id="date" value="<?=$date;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
      </div>

      <div class="form__row">
        <label class="form__label">Файл</label>

        <div class="form__input-file">
          <input class="visually-hidden" type="file" name="preview" id="preview" value="">

          <label class="button button--transparent" for="preview">
              <span>Выберите файл</span>
          </label>
        </div>
      </div>

      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="addf" value="Добавить">
      </div>
    </form>
</div>