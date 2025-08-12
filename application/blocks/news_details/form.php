<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('body'), t("Body")); ?>
    <?php echo isset($btFieldsRequired) && in_array('body', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('body'), isset($body) ? $body : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageOne) && $imageOne > 0) {
        $imageOne_o = File::getByID($imageOne);
        if (!is_object($imageOne_o)) {
            unset($imageOne_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageOne'), t("Image1")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageOne', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-news_details-imageOne-' . $identifier_getString, $view->field('imageOne'), t("Choose Image"), isset($imageOne_o) ? $imageOne_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageTwo) && $imageTwo > 0) {
        $imageTwo_o = File::getByID($imageTwo);
        if (!is_object($imageTwo_o)) {
            unset($imageTwo_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageTwo'), t("Image2")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageTwo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-news_details-imageTwo-' . $identifier_getString, $view->field('imageTwo'), t("Choose Image"), isset($imageTwo_o) ? $imageTwo_o : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('bodyTwo'), t("Body 2")); ?>
    <?php echo isset($btFieldsRequired) && in_array('bodyTwo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('bodyTwo'), isset($bodyTwo) ? $bodyTwo : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('quote'), t("Quote")); ?>
    <?php echo isset($btFieldsRequired) && in_array('quote', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->textarea($view->field('quote'), isset($quote) ? $quote : null, array (
  'rows' => 5,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('author'), t("Author")); ?>
    <?php echo isset($btFieldsRequired) && in_array('author', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('author'), isset($author) ? $author : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('bodyThree'), t("Body 3")); ?>
    <?php echo isset($btFieldsRequired) && in_array('bodyThree', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('bodyThree'), isset($bodyThree) ? $bodyThree : null); ?>
</div>