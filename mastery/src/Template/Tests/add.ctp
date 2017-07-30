<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="tests form large-9 medium-8 columns content">
    <?= $this->Form->create($test) ?>
    <fieldset>
        <legend><?= __('Add Test') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <fieldset>
        <script id="prerequisite-template" type="text/x-underscore-template">
            <?php echo $this->element('prerequisites');?>
        </script>
        <legend><?php echo __('Prerequisite (Optional)');?></legend>
        <table id="prerequisite-table">
            <thead>
                <tr>
                    <th>Prereuisite Test</th>
                    <th>Mark Required (%)</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody><?php if (!empty($this->request->data['Prerequisite'])) :?>
                    <?php for ($key = 0; $key < count($this->request->data['Prerequisite']); $key++) :?>
                        <?php echo $this->element('prerequisites', array('key' => $key));?>
                    <?php endfor;?>
                <?php endif;?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="actions">
                        <a href="#" class="add">Add prerequisite</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function() {
    var
        prerequisiteTable = $('#prerequisite-table'),
        prerequisiteBody = prerequisiteTable.find('tbody'),
        prerequisiteTemplate = _.template($('#prerequisite-template').remove().text()),
        numberRows = prerequisiteTable.find('tbody > tr').length;

    prerequisiteTable
        .on('click', 'a.add', function(e) {
            e.preventDefault();

            $(prerequisiteTemplate({key: numberRows++}))
                .hide()
                .appendTo(prerequisiteBody)
                .fadeIn('fast');
        })
        .on('click', 'a.remove', function(e) {
                e.preventDefault();

            $(this)
                .closest('tr')
                .fadeOut('fast', function() {
                    $(this).remove();
                });
        });
});
</script>
