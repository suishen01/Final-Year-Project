<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Enrollment $enrollment
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Enrollment'), ['action' => 'edit', $enrollment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Enrollment'), ['action' => 'delete', $enrollment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrollment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Enrollment'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="enrollment view large-9 medium-8 columns content">
    <h3><?= h($enrollment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $enrollment->has('user') ? $this->Html->link($enrollment->user->id, ['controller' => 'Users', 'action' => 'view', $enrollment->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Course') ?></th>
            <td><?= $enrollment->has('course') ? $this->Html->link($enrollment->course->name, ['controller' => 'Courses', 'action' => 'view', $enrollment->course->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($enrollment->id) ?></td>
        </tr>
    </table>
</div>
