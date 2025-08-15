<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-categories_items-' . $identifier_getString, t('Categories')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('subtitle'), t("Subtitle")); ?>
    <?php echo isset($btFieldsRequired) && in_array('subtitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('subtitle'), isset($subtitle) ? $subtitle : null, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('title'), t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('title'), isset($title) ? $title : null, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php echo $form->label($view->field('form'), t("Form")); ?>
    <?php echo isset($btFieldsRequired) && in_array('form', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->selectMultiple($view->field('form'), $form_options, isset($form_selected) ? $form_selected : [], []); ?>
</div>

<script type="text/javascript">
    Concrete.event.publish('contact_form_block.form.stacks');
</script>


</div>

<div role="tabpanel" class="tab-pane" id="form-categories_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php $repeatable_container_id = 'btContactFormBlock-categories-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $categories_items,
                        'order' => array_keys($categories_items),
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
                        <?php echo t('Categories') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('categories'); ?>[{{id}}][interest]" class="control-label"><?php echo t("Interest"); ?></label>
    <?php echo isset($btFieldsRequired['categories']) && in_array('interest', $btFieldsRequired['categories']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('categories'); ?>[{{id}}][interest]" id="<?php echo $view->field('categories'); ?>[{{id}}][interest]" class="form-control" type="text" value="{{ interest }}" maxlength="255" />
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
    Concrete.event.publish('btContactFormBlock.categories.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>