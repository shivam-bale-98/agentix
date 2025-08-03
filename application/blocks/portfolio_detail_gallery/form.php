<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageFull) && $imageFull > 0) {
        $imageFull_o = File::getByID($imageFull);
        if (!is_object($imageFull_o)) {
            unset($imageFull_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageFull'), t("Image Full")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageFull', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-portfolio_detail_gallery-imageFull-' . $identifier_getString, $view->field('imageFull'), t("Choose Image"), isset($imageFull_o) ? $imageFull_o : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('video'), t("Video")); ?>
    <?php echo isset($btFieldsRequired) && in_array('video', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('video'), isset($video) ? $video : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php
    if (isset($ImageTwo) && $ImageTwo > 0) {
        $ImageTwo_o = File::getByID($ImageTwo);
        if (!is_object($ImageTwo_o)) {
            unset($ImageTwo_o);
        }
    } ?>
    <?php echo $form->label($view->field('ImageTwo'), t("Image2")); ?>
    <?php echo isset($btFieldsRequired) && in_array('ImageTwo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-portfolio_detail_gallery-ImageTwo-' . $identifier_getString, $view->field('ImageTwo'), t("Choose Image"), isset($ImageTwo_o) ? $ImageTwo_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageThree) && $imageThree > 0) {
        $imageThree_o = File::getByID($imageThree);
        if (!is_object($imageThree_o)) {
            unset($imageThree_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageThree'), t("Image3")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageThree', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-portfolio_detail_gallery-imageThree-' . $identifier_getString, $view->field('imageThree'), t("Choose Image"), isset($imageThree_o) ? $imageThree_o : null); ?>
</div>