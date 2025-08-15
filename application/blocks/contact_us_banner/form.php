<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('subtitle'), t("Subtitle")); ?>
    <?php echo isset($btFieldsRequired) && in_array('subtitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('subtitle'), isset($subtitle) ? $subtitle : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('titleOne'), t("Title 1")); ?>
    <?php echo isset($btFieldsRequired) && in_array('titleOne', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('titleOne'), isset($titleOne) ? $titleOne : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('titleTwo'), t("Title 2")); ?>
    <?php echo isset($btFieldsRequired) && in_array('titleTwo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('titleTwo'), isset($titleTwo) ? $titleTwo : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('description_1'), t("Description")); ?>
    <?php echo isset($btFieldsRequired) && in_array('description_1', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('description_1'), isset($description_1) ? $description_1 : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($titleImage) && $titleImage > 0) {
        $titleImage_o = File::getByID($titleImage);
        if (!is_object($titleImage_o)) {
            unset($titleImage_o);
        }
    } ?>
    <?php echo $form->label($view->field('titleImage'), t("Title Image")); ?>
    <?php echo isset($btFieldsRequired) && in_array('titleImage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-contact_us_banner-titleImage-' . $identifier_getString, $view->field('titleImage'), t("Choose Image"), isset($titleImage_o) ? $titleImage_o : null); ?>
</div>