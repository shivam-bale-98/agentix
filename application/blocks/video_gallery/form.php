<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-gallery_items-' . $identifier_getString, t('Gallery')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('paddingTop'), t("Padding Top")); ?>
    <?php echo isset($btFieldsRequired) && in_array('paddingTop', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('paddingTop'), (isset($btFieldsRequired) && in_array('paddingTop', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($paddingTop) ? $paddingTop : null, []); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-gallery_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php $repeatable_container_id = 'btVideoGallery-gallery-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $gallery_items,
                        'order' => array_keys($gallery_items),
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
                        <?php echo t('Gallery') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('gallery'); ?>[{{id}}][image]" class="control-label"><?php echo t("Image"); ?></label>
    <?php echo isset($btFieldsRequired['gallery']) && in_array('image', $btFieldsRequired['gallery']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="gallery-image-image-{{id}}" class="ccm-file-selector ft-image-gallery-image-file-selector">
<concrete-file-input file-id="{{ image }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('gallery'); ?>[{{id}}][image]">
                                </concrete-file-input>
</div>
</div>            <div class="form-group">
    <label for="<?php echo $view->field('gallery'); ?>[{{id}}][videoLink]" class="control-label"><?php echo t("Video Link"); ?></label>
    <?php echo isset($btFieldsRequired['gallery']) && in_array('videoLink', $btFieldsRequired['gallery']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('gallery'); ?>[{{id}}][videoLink]" id="<?php echo $view->field('gallery'); ?>[{{id}}][videoLink]" class="form-control" type="text" value="{{ videoLink }}" maxlength="255" />
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
    Concrete.event.publish('btVideoGallery.gallery.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>