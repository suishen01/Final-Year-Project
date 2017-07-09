<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Prerequisites'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?></li>
    </ul>
</nav>
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
