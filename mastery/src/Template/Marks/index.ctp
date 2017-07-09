<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Mark[]|\Cake\Collection\CollectionInterface $marks
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Mark'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="marks index large-9 medium-8 columns content">
    <h3><?= __('Marks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('marks') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('test_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marks as $mark): ?>
            <tr>
                <td><?= $this->Number->format($mark->id) ?></td>
                <td><?= $this->Number->format($mark->marks) ?></td>
                <td><?= $mark->has('user') ? $this->Html->link($mark->user->id, ['controller' => 'Users', 'action' => 'view', $mark->user->id]) : '' ?></td>
                <td><?= $mark->has('test') ? $this->Html->link($mark->test->name, ['controller' => 'Tests', 'action' => 'view', $mark->test->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $mark->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $mark->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $mark->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mark->id)]) ?>
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
