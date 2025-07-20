<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-list_items-' . $identifier_getString, t('List')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('hideBlock'), t("Hide Block")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->select($view->field('hideBlock'), (isset($btFieldsRequired) && in_array('hideBlock', $btFieldsRequired) ? [] : ["" => "--" . t("Select") . "--"]) + [0 => t("No"), 1 => t("Yes")], isset($hideBlock) ? $hideBlock : null, []); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-list_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php $repeatable_container_id = 'btOurTeamBlock-list-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $list_items,
                        'order' => array_keys($list_items),
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
                        <?php echo t('List') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('list'); ?>[{{id}}][date]" class="control-label"><?php echo t("Joining Date"); ?></label>
    <?php echo isset($btFieldsRequired['list']) && in_array('date', $btFieldsRequired['list']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('list'); ?>[{{id}}][date]" id="<?php echo $view->field('list'); ?>[{{id}}][date]" class="form-control" type="text" value="{{ date }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('list'); ?>[{{id}}][name]" class="control-label"><?php echo t("Name"); ?></label>
    <?php echo isset($btFieldsRequired['list']) && in_array('name', $btFieldsRequired['list']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('list'); ?>[{{id}}][name]" id="<?php echo $view->field('list'); ?>[{{id}}][name]" class="form-control" type="text" value="{{ name }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('list'); ?>[{{id}}][designation]" class="control-label"><?php echo t("Designation"); ?></label>
    <?php echo isset($btFieldsRequired['list']) && in_array('designation', $btFieldsRequired['list']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('list'); ?>[{{id}}][designation]" id="<?php echo $view->field('list'); ?>[{{id}}][designation]" class="form-control" type="text" value="{{ designation }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('list'); ?>[{{id}}][image]" class="control-label"><?php echo t("Image"); ?></label>
    <?php echo isset($btFieldsRequired['list']) && in_array('image', $btFieldsRequired['list']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="list-image-image-{{id}}" class="ccm-file-selector ft-image-list-image-file-selector">
<concrete-file-input file-id="{{ image }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('list'); ?>[{{id}}][image]">
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
    Concrete.event.publish('btOurTeamBlock.list.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>