<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Prerequisite[]|\Cake\Collection\CollectionInterface $prerequisites
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Prerequisite'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="prerequisites index large-9 medium-8 columns content">
    <h3><?= __('Prerequisites') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('required_marks') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pre_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('test_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prerequisites as $prerequisite): ?>
            <tr>
                <td><?= $this->Number->format($prerequisite->id) ?></td>
                <td><?= $this->Number->format($prerequisite->required_marks) ?></td>
                <td><?= $this->Number->format($prerequisite->pre_id) ?></td>
                <td><?= $prerequisite->has('test') ? $this->Html->link($prerequisite->test->name, ['controller' => 'Tests', 'action' => 'view', $prerequisite->test->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $prerequisite->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $prerequisite->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $prerequisite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $prerequisite->id)]) ?>
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
