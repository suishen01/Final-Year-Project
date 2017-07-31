<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="prerequisites form large-9 medium-8 columns content">
    <?= $this->Form->create($prerequisite) ?>
    <fieldset>
        <legend><?= __('Add Prerequisite') ?></legend>
        <?php
            echo $this->Form->control('required_marks');
            echo $this->Form->control('pre_id', ['options' => $tests]);
            echo $this->Form->control('test_id', ['options' => $tests]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
