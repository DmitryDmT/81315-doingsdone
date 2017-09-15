<?php
 
$errors = $templateData['errors'];
$name = $_POST['name'] ?? '';
$project = $_POST['project'] ?? 0;
$date = $_POST['date'] ?? '';
$form_err = 'form__input--error';

?>
<div class="modal">
  <button class="modal__close" type="button" name="button">Закрыть</button>

  <h2 class="modal__heading">Добавление задачи</h2>

  <form class="form" action="index.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>
      <span class="form__error"><?= in_array('name', $errors) ? 'Заполните это поле' : '';?></span>
      <input class="form__input <?= in_array('name', $errors) ? $form_err : '';?>" type="text" name="name" id="name" value="<?=htmlspecialchars($name);?>" placeholder="Введите название">
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект <sup>*</sup></label>
      <select class="form__input form__input--select" name="project" id="project">
        <?php foreach ($templateData['arr_projects'] as $key => $value): ?>
          <option value="<?=$key;?>"><?=$value;?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form__row">
      <label class="form__label" for="date">Дата выполнения <sup>*</sup></label>
      <span class="form__error"><?= in_array('date', $errors) ? 'Заполните это поле или введите верное значение' : '';?></span>
      <input class="form__input form__input--date <?= in_array('date', $errors) ? $form_err : '';?>" type="text" name="date" id="date" value="<?=htmlspecialchars($date);?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
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