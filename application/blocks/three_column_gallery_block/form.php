<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div>

<div class="form-group">
    <?php
    if (isset($cardOneImage) && $cardOneImage > 0) {
        $cardOneImage_o = File::getByID($cardOneImage);
        if (!is_object($cardOneImage_o)) {
            unset($cardOneImage_o);
        }
    } ?>
    <?php echo $form->label($view->field('cardOneImage'), t("Card One Image (350X430)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardOneImage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-three_column_gallery_block-cardOneImage-' . $identifier_getString, $view->field('cardOneImage'), t("Choose Image"), isset($cardOneImage_o) ? $cardOneImage_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($logo) && $logo > 0) {
        $logo_o = File::getByID($logo);
        if (!is_object($logo_o)) {
            unset($logo_o);
        }
    } ?>
    <?php echo $form->label($view->field('logo'), t("Logo (20x20)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('logo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-three_column_gallery_block-logo-' . $identifier_getString, $view->field('logo'), t("Choose Image"), isset($logo_o) ? $logo_o : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('cardTitle'), t("Card Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardTitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('cardTitle'), isset($cardTitle) ? $cardTitle : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('cardSubtitle'), t("Card Subtitle")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardSubtitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('cardSubtitle'), isset($cardSubtitle) ? $cardSubtitle : null, array (
  'maxlength' => 255,
)); ?>
</div>

<?php $link_ContainerID = 'btThreeColumnGalleryBlock-link-container-' . $identifier_getString; ?>
<div class="ft-smart-link" id="<?php echo $link_ContainerID; ?>">
	<div class="form-group">
		<?php echo $form->label($view->field('link'), t("Link")); ?>
	    <?php echo isset($btFieldsRequired) && in_array('link', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
	    <?php echo $form->select($view->field('link'), $link_Options, isset($link) ? $link : null, array (
  'class' => 'form-control ft-smart-link-type',
)); ?>
	</div>
	
	<div class="form-group">
		<div class="ft-smart-link-options hidden d-none" style="padding-left: 10px;">
			<div class="form-group">
				<?php echo $form->label($view->field('link_Title'), t("Title")); ?>
			    <?php echo $form->text($view->field('link_Title'), isset($link_Title) ? $link_Title : null, []); ?>		
			</div>
			
			<div class="form-group hidden d-none" data-link-type="page">
			<?php echo $form->label($view->field('link_Page'), t("Page")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/form/page_selector")->selectPage($view->field('link_Page'), isset($link_Page) ? $link_Page : null); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="url">
			<?php echo $form->label($view->field('link_URL'), t("URL")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo $form->text($view->field('link_URL'), isset($link_URL) ? $link_URL : null, []); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="relative_url">
			<?php echo $form->label($view->field('link_Relative_URL'), t("URL")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo $form->text($view->field('link_Relative_URL'), isset($link_Relative_URL) ? $link_Relative_URL : null, []); ?>
		</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	Concrete.event.publish('btThreeColumnGalleryBlock.link.open', {id: '<?php echo $link_ContainerID; ?>'});
	$('#<?php echo $link_ContainerID; ?> .ft-smart-link-type').trigger('change');
</script>

<div class="form-group">
    <?php
    if (isset($cardTwoImage) && $cardTwoImage > 0) {
        $cardTwoImage_o = File::getByID($cardTwoImage);
        if (!is_object($cardTwoImage_o)) {
            unset($cardTwoImage_o);
        }
    } ?>
    <?php echo $form->label($view->field('cardTwoImage'), t("Card Two Image (350X430)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardTwoImage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-three_column_gallery_block-cardTwoImage-' . $identifier_getString, $view->field('cardTwoImage'), t("Choose Image"), isset($cardTwoImage_o) ? $cardTwoImage_o : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('cardThreeVideo'), t("Card Three Video (350X430)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardThreeVideo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->textarea($view->field('cardThreeVideo'), isset($cardThreeVideo) ? $cardThreeVideo : null, array (
  'rows' => 5,
)); ?>
</div>

<div class="form-group">
    <?php
    if (isset($cardThreeImage) && $cardThreeImage > 0) {
        $cardThreeImage_o = File::getByID($cardThreeImage);
        if (!is_object($cardThreeImage_o)) {
            unset($cardThreeImage_o);
        }
    } ?>
    <?php echo $form->label($view->field('cardThreeImage'), t("Card Three Image (optional)(350X430)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardThreeImage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-three_column_gallery_block-cardThreeImage-' . $identifier_getString, $view->field('cardThreeImage'), t("Choose Image"), isset($cardThreeImage_o) ? $cardThreeImage_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($cardFourImage) && $cardFourImage > 0) {
        $cardFourImage_o = File::getByID($cardFourImage);
        if (!is_object($cardFourImage_o)) {
            unset($cardFourImage_o);
        }
    } ?>
    <?php echo $form->label($view->field('cardFourImage'), t("Card Four Image (350X430)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('cardFourImage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-three_column_gallery_block-cardFourImage-' . $identifier_getString, $view->field('cardFourImage'), t("Choose Image"), isset($cardFourImage_o) ? $cardFourImage_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageRight) && $imageRight > 0) {
        $imageRight_o = File::getByID($imageRight);
        if (!is_object($imageRight_o)) {
            unset($imageRight_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageRight'), t("ImageRight (700X900)")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageRight', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-three_column_gallery_block-imageRight-' . $identifier_getString, $view->field('imageRight'), t("Choose Image"), isset($imageRight_o) ? $imageRight_o : null); ?>
</div>