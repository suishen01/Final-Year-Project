<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Enrollment'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="enrollment form large-9 medium-8 columns content">
    <?= $this->Form->create($enrollment) ?>
    <fieldset>
        <legend><?= __('Add Enrollment') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('course_id', ['options' => $courses]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
