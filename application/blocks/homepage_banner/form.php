<?php defined("C5_EXECUTE") or die("Access Denied."); 
$linkTag_File = "";
$linkTag_Image = "";
?>

<div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('title'), t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('title'), isset($title) ? $title : null); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('featureTitle'), t("Feature Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('featureTitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('featureTitle'), isset($featureTitle) ? $featureTitle : null, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label($view->field('featureValue'), t("Feature Value")); ?>
    <?php echo isset($btFieldsRequired) && in_array('featureValue', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('featureValue'), isset($featureValue) ? $featureValue : null, array (
  'maxlength' => 255,
)); ?>
</div>

<?php $linkTag_ContainerID = 'btHomepageBanner-linkTag-container-' . $identifier_getString; ?>
<div class="ft-smart-link" id="<?php echo $linkTag_ContainerID; ?>">
	<div class="form-group">
		<?php echo $form->label($view->field('linkTag'), t("Link Tag")); ?>
	    <?php echo isset($btFieldsRequired) && in_array('linkTag', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
	    <?php echo $form->select($view->field('linkTag'), $linkTag_Options, isset($linkTag) ? $linkTag : null, array (
  'class' => 'form-control ft-smart-link-type',
)); ?>
	</div>
	
	<div class="form-group">
		<div class="ft-smart-link-options hidden d-none" style="padding-left: 10px;">
			<div class="form-group">
				<?php echo $form->label($view->field('linkTag_Title'), t("Title")); ?>
			    <?php echo $form->text($view->field('linkTag_Title'), isset($linkTag_Title) ? $linkTag_Title : null, []); ?>		
			</div>
			
			<div class="form-group hidden d-none" data-link-type="page">
			<?php echo $form->label($view->field('linkTag_Page'), t("Page")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/form/page_selector")->selectPage($view->field('linkTag_Page'), isset($linkTag_Page) ? $linkTag_Page : null); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="url">
			<?php echo $form->label($view->field('linkTag_URL'), t("URL")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo $form->text($view->field('linkTag_URL'), isset($linkTag_URL) ? $linkTag_URL : null, []); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="relative_url">
			<?php echo $form->label($view->field('linkTag_Relative_URL'), t("URL")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo $form->text($view->field('linkTag_Relative_URL'), isset($linkTag_Relative_URL) ? $linkTag_Relative_URL : null, []); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="file">
			<?php
			if ($linkTag_File > 0) {
				$linkTag_File_o = File::getByID($linkTag_File);
				if (!is_object($linkTag_File_o)) {
					unset($linkTag_File_o);
				}
			} ?>
		    <?php echo $form->label($view->field('linkTag_File'), t("File")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/concrete/asset_library")->file('ccm-b-homepage_banner-linkTag_File-' . $identifier_getString, $view->field('linkTag_File'), t("Choose File"), isset($linkTag_File_o) ? $linkTag_File_o : null); ?>	
		</div>

		<div class="form-group hidden d-none" data-link-type="image">
			<?php
			if ($linkTag_Image > 0) {
				$linkTag_Image_o = File::getByID($linkTag_Image);
				if (!is_object($linkTag_Image_o)) {
					unset($linkTag_Image_o);
				}
			} ?>
			<?php echo $form->label($view->field('linkTag_Image'), t("Image")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-linkTag_Image-' . $identifier_getString, $view->field('linkTag_Image'), t("Choose Image"), isset($linkTag_Image_o) ? $linkTag_Image_o : null); ?>
		</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	Concrete.event.publish('btHomepageBanner.linkTag.open', {id: '<?php echo $linkTag_ContainerID; ?>'});
	$('#<?php echo $linkTag_ContainerID; ?> .ft-smart-link-type').trigger('change');
</script>

<div class="form-group">
    <?php
    if (isset($imageOne) && $imageOne > 0) {
        $imageOne_o = File::getByID($imageOne);
        if (!is_object($imageOne_o)) {
            unset($imageOne_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageOne'), t("Image 1")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageOne', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageOne-' . $identifier_getString, $view->field('imageOne'), t("Choose Image"), isset($imageOne_o) ? $imageOne_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageTwo) && $imageTwo > 0) {
        $imageTwo_o = File::getByID($imageTwo);
        if (!is_object($imageTwo_o)) {
            unset($imageTwo_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageTwo'), t("Image 2")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageTwo', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageTwo-' . $identifier_getString, $view->field('imageTwo'), t("Choose Image"), isset($imageTwo_o) ? $imageTwo_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageThree) && $imageThree > 0) {
        $imageThree_o = File::getByID($imageThree);
        if (!is_object($imageThree_o)) {
            unset($imageThree_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageThree'), t("Image 3")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageThree', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageThree-' . $identifier_getString, $view->field('imageThree'), t("Choose Image"), isset($imageThree_o) ? $imageThree_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageFour) && $imageFour > 0) {
        $imageFour_o = File::getByID($imageFour);
        if (!is_object($imageFour_o)) {
            unset($imageFour_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageFour'), t("Image 4 ")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageFour', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageFour-' . $identifier_getString, $view->field('imageFour'), t("Choose Image"), isset($imageFour_o) ? $imageFour_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageFive) && $imageFive > 0) {
        $imageFive_o = File::getByID($imageFive);
        if (!is_object($imageFive_o)) {
            unset($imageFive_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageFive'), t("Image 5")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageFive', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageFive-' . $identifier_getString, $view->field('imageFive'), t("Choose Image"), isset($imageFive_o) ? $imageFive_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageSix) && $imageSix > 0) {
        $imageSix_o = File::getByID($imageSix);
        if (!is_object($imageSix_o)) {
            unset($imageSix_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageSix'), t("Image 6")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageSix', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageSix-' . $identifier_getString, $view->field('imageSix'), t("Choose Image"), isset($imageSix_o) ? $imageSix_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageSeven) && $imageSeven > 0) {
        $imageSeven_o = File::getByID($imageSeven);
        if (!is_object($imageSeven_o)) {
            unset($imageSeven_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageSeven'), t("Image 7")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageSeven', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageSeven-' . $identifier_getString, $view->field('imageSeven'), t("Choose Image"), isset($imageSeven_o) ? $imageSeven_o : null); ?>
</div>

<div class="form-group">
    <?php
    if (isset($imageEight) && $imageEight > 0) {
        $imageEight_o = File::getByID($imageEight);
        if (!is_object($imageEight_o)) {
            unset($imageEight_o);
        }
    } ?>
    <?php echo $form->label($view->field('imageEight'), t("Image 8")); ?>
    <?php echo isset($btFieldsRequired) && in_array('imageEight', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-homepage_banner-imageEight-' . $identifier_getString, $view->field('imageEight'), t("Choose Image"), isset($imageEight_o) ? $imageEight_o : null); ?>
</div>