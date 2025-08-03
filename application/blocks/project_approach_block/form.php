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
    <?php echo $form->label($view->field('title'), t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('title'), isset($title) ? $title : null); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('subtitle'), t("Subtitle")); ?>
    <?php echo isset($btFieldsRequired) && in_array('subtitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('subtitle'), isset($subtitle) ? $subtitle : null); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('description_1'), t("Description")); ?>
    <?php echo isset($btFieldsRequired) && in_array('description_1', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('description_1'), isset($description_1) ? $description_1 : null); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-features_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php $repeatable_container_id = 'btProjectApproachBlock-features-container-' . $identifier_getString; ?>
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
    <label for="<?php echo $view->field('features'); ?>[{{id}}][prefix]" class="control-label"><?php echo t("prefix"); ?></label>
    <?php echo isset($btFieldsRequired['features']) && in_array('prefix', $btFieldsRequired['features']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('features'); ?>[{{id}}][prefix]" id="<?php echo $view->field('features'); ?>[{{id}}][prefix]" class="form-control" type="text" value="{{ prefix }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('features'); ?>[{{id}}][title]" class="control-label"><?php echo t("Title"); ?></label>
    <?php echo isset($btFieldsRequired['features']) && in_array('title', $btFieldsRequired['features']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('features'); ?>[{{id}}][title]" id="<?php echo $view->field('features'); ?>[{{id}}][title]" class="form-control" type="text" value="{{ title }}" maxlength="255" />
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
    Concrete.event.publish('btProjectApproachBlock.features.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>