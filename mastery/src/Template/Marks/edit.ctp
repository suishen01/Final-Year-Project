<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $mark->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $mark->id)]
            )
        ?></li>
    </ul>
</nav>
<div class="marks form large-9 medium-8 columns content">
    <?= $this->Form->create($mark) ?>
    <fieldset>
        <legend><?= __('Edit Mark') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('question_id', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
