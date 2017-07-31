<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Enrollment[]|\Cake\Collection\CollectionInterface $enrollment
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Enrollment'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="enrollment index large-9 medium-8 columns content">
    <h3><?= __('Enrollment') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('course_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($enrollment as $enrollment): ?>
            <tr>
                <td><?= $this->Number->format($enrollment->id) ?></td>
                <td><?= $enrollment->has('user') ? $this->Html->link($enrollment->user->id, ['controller' => 'Users', 'action' => 'view', $enrollment->user->id]) : '' ?></td>
                <td><?= $enrollment->has('course') ? $this->Html->link($enrollment->course->name, ['controller' => 'Courses', 'action' => 'view', $enrollment->course->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $enrollment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $enrollment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $enrollment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrollment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
