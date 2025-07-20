<?php defined("C5_EXECUTE") or die("Access Denied."); 
$link_File = "";
$link_Image = "";
?>

<div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div>

<?php $link_ContainerID = 'btFillTextBlock-link-container-' . $identifier_getString; ?>
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

		<div class="form-group hidden d-none" data-link-type="file">
			<?php
			if ($link_File > 0) {
				$link_File_o = File::getByID($link_File);
				if (!is_object($link_File_o)) {
					unset($link_File_o);
				}
			} ?>
		    <?php echo $form->label($view->field('link_File'), t("File")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/concrete/asset_library")->file('ccm-b-fill_text_block-link_File-' . $identifier_getString, $view->field('link_File'), t("Choose File"), isset($link_File_o) ? $link_File_o : null); ?>	
		</div>

		<div class="form-group hidden d-none" data-link-type="image">
			<?php
			if ($link_Image > 0) {
				$link_Image_o = File::getByID($link_Image);
				if (!is_object($link_Image_o)) {
					unset($link_Image_o);
				}
			} ?>
			<?php echo $form->label($view->field('link_Image'), t("Image")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-fill_text_block-link_Image-' . $identifier_getString, $view->field('link_Image'), t("Choose Image"), isset($link_Image_o) ? $link_Image_o : null); ?>
		</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	Concrete.event.publish('btFillTextBlock.link.open', {id: '<?php echo $link_ContainerID; ?>'});
	$('#<?php echo $link_ContainerID; ?> .ft-smart-link-type').trigger('change');
</script>

<div class="form-group">
    <?php echo $form->label($view->field('content'), t("Content")); ?>
    <?php echo isset($btFieldsRequired) && in_array('content', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->textarea($view->field('content'), isset($content) ? $content : null, array (
  'rows' => 5,
)); ?>
</div>