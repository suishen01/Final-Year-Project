<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Mark $mark
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Mark'), ['action' => 'edit', $mark->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Mark'), ['action' => 'delete', $mark->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mark->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Marks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Mark'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="marks view large-9 medium-8 columns content">
    <h3><?= h($mark->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $mark->has('user') ? $this->Html->link($mark->user->id, ['controller' => 'Users', 'action' => 'view', $mark->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Test') ?></th>
            <td><?= $mark->has('test') ? $this->Html->link($mark->test->name, ['controller' => 'Tests', 'action' => 'view', $mark->test->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($mark->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Marks') ?></th>
            <td><?= $this->Number->format($mark->marks) ?></td>
        </tr>
    </table>
</div>
