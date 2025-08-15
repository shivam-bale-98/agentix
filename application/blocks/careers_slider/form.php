<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-slider_items-' . $identifier_getString, t('Slider')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('paddingBottom'), t("Padding Bottom")); ?>
    <?php echo isset($btFieldsRequired) && in_array('paddingBottom', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('paddingBottom'), (isset($btFieldsRequired) && in_array('paddingBottom', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($paddingBottom) ? $paddingBottom : null, []); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-slider_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php $repeatable_container_id = 'btCareersSlider-slider-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $slider_items,
                        'order' => array_keys($slider_items),
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
                        <?php echo t('Slider') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('slider'); ?>[{{id}}][image]" class="control-label"><?php echo t("Image"); ?></label>
    <?php echo isset($btFieldsRequired['slider']) && in_array('image', $btFieldsRequired['slider']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="slider-image-image-{{id}}" class="ccm-file-selector ft-image-slider-image-file-selector">
<concrete-file-input file-id="{{ image }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('slider'); ?>[{{id}}][image]">
                                </concrete-file-input>
</div>
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
    Concrete.event.publish('btCareersSlider.slider.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>