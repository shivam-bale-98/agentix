<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-features_items-' . $identifier_getString, t('Features')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div><div class="form-group">
    <?php
    if (isset($image) && $image > 0) {
        $image_o = File::getByID($image);
        if (!is_object($image_o)) {
            unset($image_o);
        }
    } ?>
    <?php echo $form->label($view->field('image'), t("Image")); ?>
    <?php echo isset($btFieldsRequired) && in_array('image', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-image_content_list_block-image-' . $identifier_getString, $view->field('image'), t("Choose Image"), isset($image_o) ? $image_o : null); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('videoLink'), t("Video Link")); ?>
    <?php echo isset($btFieldsRequired) && in_array('videoLink', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('videoLink'), isset($videoLink) ? $videoLink : null, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('subTitle'), t("Sub Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('subTitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('subTitle'), isset($subTitle) ? $subTitle : null, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('title'), t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('title'), isset($title) ? $title : null, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('content'), t("Content")); ?>
    <?php echo isset($btFieldsRequired) && in_array('content', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('content'), isset($content) ? $content : null); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-features_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
            <?php
	$core_editor = Core::make('editor');
	if (method_exists($core_editor, 'outputStandardEditorInitJSFunction')) {
		/* @var $core_editor \Concrete\Core\Editor\CkeditorEditor */
		?>
		<script type="text/javascript">var blockDesignerEditor = <?php echo $core_editor->outputStandardEditorInitJSFunction(); ?>;</script>
	<?php
	} else {
	/* @var $core_editor \Concrete\Core\Editor\RedactorEditor */
	if(method_exists($core_editor, 'requireEditorAssets')){
		$core_editor->requireEditorAssets();
	} ?>
		<script type="text/javascript">
			var blockDesignerEditor = function (identifier) {$(identifier).redactor(<?php echo json_encode(array('plugins' => ['concrete5magic'] + $core_editor->getPluginManager()->getSelectedPlugins(), 'minHeight' => 300,'concrete5' => array('filemanager' => $core_editor->allowFileManager(), 'sitemap' => $core_editor->allowSitemap()))); ?>).on('remove', function () {$(this).redactor('core.destroy');});};
		</script>
		<?php
	} ?><?php $repeatable_container_id = 'btImageContentListBlock-features-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $features_items,
                        'order' => array_keys($features_items),
                    ]
                )
            ); ?>">
            </div>

            <a href="#" class="btn btn-primary add-entry add-entry-last">
                <?php echo t('Add Entry'); ?>
            </a>
        </div>

        <script class="repeatableTemplate" type="text/x-handlebars-template">
            <div class="sortable-item" data-id="{{id}}">
                <div class="sortable-item-title">
                    <span class="sortable-item-title-default">
                        <?php echo t('Features') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('features'); ?>[{{id}}][value]" class="control-label"><?php echo t("Value"); ?></label>
    <?php echo isset($btFieldsRequired['features']) && in_array('value', $btFieldsRequired['features']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('features'); ?>[{{id}}][value]" id="<?php echo $view->field('features'); ?>[{{id}}][value]" class="form-control" type="text" value="{{ value }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('features'); ?>[{{id}}][surfix]" class="control-label"><?php echo t("surfix"); ?></label>
    <?php echo isset($btFieldsRequired['features']) && in_array('surfix', $btFieldsRequired['features']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('features'); ?>[{{id}}][surfix]" id="<?php echo $view->field('features'); ?>[{{id}}][surfix]" class="form-control" type="text" value="{{ surfix }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('features'); ?>[{{id}}][info]" class="control-label"><?php echo t("Info"); ?></label>
    <?php echo isset($btFieldsRequired['features']) && in_array('info', $btFieldsRequired['features']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php echo $view->field('features'); ?>[{{id}}][info]" id="<?php echo $view->field('features'); ?>[{{id}}][info]" class="ft-features-info">{{ info }}</textarea>
</div></div>

                <span class="sortable-item-collapse-toggle"></span>

                <a href="#" class="sortable-item-delete" data-attr-confirm-text="<?php echo t('Are you sure'); ?>">
                    <i class="fa fa-times"></i>
                </a>

                <div class="sortable-item-handle">
                    <i class="fa fa-sort"></i>
                </div>
            </div>
        </script>
    </div>

<script type="text/javascript">
    Concrete.event.publish('btImageContentListBlock.features.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>