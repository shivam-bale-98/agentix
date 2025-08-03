<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div>

<div class="form-group">
    <?php
    if (isset($image) && $image > 0) {
        $image_o = File::getByID($image);
        if (!is_object($image_o)) {
            unset($image_o);
        }
    } ?>
    <?php echo $form->label($view->field('image'), t("Image ")); ?>
    <?php echo isset($btFieldsRequired) && in_array('image', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-image_video_block-image-' . $identifier_getString, $view->field('image'), t("Choose Image"), isset($image_o) ? $image_o : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('smallVideoLink'), t("Small Video Link")); ?>
    <?php echo isset($btFieldsRequired) && in_array('smallVideoLink', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->textarea($view->field('smallVideoLink'), isset($smallVideoLink) ? $smallVideoLink : null, array (
  'rows' => 5,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('popupVideoLink'), t("Popup Video Link")); ?>
    <?php echo isset($btFieldsRequired) && in_array('popupVideoLink', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->textarea($view->field('popupVideoLink'), isset($popupVideoLink) ? $popupVideoLink : null, array (
  'rows' => 5,
)); ?>
</div>