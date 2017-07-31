<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="marks form large-9 medium-8 columns content">
    <?= $this->Form->create($mark) ?>
    <fieldset>
        <legend><?= __('Add Mark') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('question_id', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
