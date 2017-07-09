<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Prerequisite $prerequisite
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Prerequisite'), ['action' => 'edit', $prerequisite->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Prerequisite'), ['action' => 'delete', $prerequisite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $prerequisite->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Prerequisites'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Prerequisite'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="prerequisites view large-9 medium-8 columns content">
    <h3><?= h($prerequisite->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Test') ?></th>
            <td><?= $prerequisite->has('test') ? $this->Html->link($prerequisite->test->name, ['controller' => 'Tests', 'action' => 'view', $prerequisite->test->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($prerequisite->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Required Marks') ?></th>
            <td><?= $this->Number->format($prerequisite->required_marks) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pre Id') ?></th>
            <td><?= $this->Number->format($prerequisite->pre_id) ?></td>
        </tr>
    </table>
</div>
