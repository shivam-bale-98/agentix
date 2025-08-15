<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('textOne'), t("Text 1")); ?>
    <?php echo isset($btFieldsRequired) && in_array('textOne', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('textOne'), isset($textOne) ? $textOne : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('textTwo'), t("text 2")); ?>
    <?php echo isset($btFieldsRequired) && in_array('textTwo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('textTwo'), isset($textTwo) ? $textTwo : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('scrollToId'), t("ScrollToId")); ?>
    <?php echo isset($btFieldsRequired) && in_array('scrollToId', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('scrollToId'), isset($scrollToId) ? $scrollToId : null, array (
  'maxlength' => 255,
)); ?>
</div>