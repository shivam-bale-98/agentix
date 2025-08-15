<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-faqs_items-' . $identifier_getString, t('Faqs')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('title'), t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('title'), isset($title) ? $title : null, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('paddingTop'), t("PaddingTop")); ?>
    <?php echo isset($btFieldsRequired) && in_array('paddingTop', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('paddingTop'), (isset($btFieldsRequired) && in_array('paddingTop', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($paddingTop) ? $paddingTop : null, []); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('paddingBottom'), t("Padding Bottom")); ?>
    <?php echo isset($btFieldsRequired) && in_array('paddingBottom', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('paddingBottom'), (isset($btFieldsRequired) && in_array('paddingBottom', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($paddingBottom) ? $paddingBottom : null, []); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-faqs_items-<?php echo $identifier_getString; ?>">
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
	} ?><?php $repeatable_container_id = 'btFaqBlock-faqs-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $faqs_items,
                        'order' => array_keys($faqs_items),
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
                        <?php echo t('Faqs') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('faqs'); ?>[{{id}}][faqTitle]" class="control-label"><?php echo t("Faq Title"); ?></label>
    <?php echo isset($btFieldsRequired['faqs']) && in_array('faqTitle', $btFieldsRequired['faqs']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('faqs'); ?>[{{id}}][faqTitle]" id="<?php echo $view->field('faqs'); ?>[{{id}}][faqTitle]" class="form-control" type="text" value="{{ faqTitle }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('faqs'); ?>[{{id}}][faqDescription]" class="control-label"><?php echo t("Faq Description"); ?></label>
    <?php echo isset($btFieldsRequired['faqs']) && in_array('faqDescription', $btFieldsRequired['faqs']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php echo $view->field('faqs'); ?>[{{id}}][faqDescription]" id="<?php echo $view->field('faqs'); ?>[{{id}}][faqDescription]" class="ft-faqs-faqDescription">{{ faqDescription }}</textarea>
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
    Concrete.event.publish('btFaqBlock.faqs.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>