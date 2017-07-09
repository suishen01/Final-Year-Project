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
                ['action' => 'delete', $course->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $course->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Courses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Enrollment'), ['controller' => 'Enrollment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Enrollment'), ['controller' => 'Enrollment', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="courses form large-9 medium-8 columns content">
    <?= $this->Form->create($course) ?>
    <fieldset>
        <legend><?= __('Edit Course') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
