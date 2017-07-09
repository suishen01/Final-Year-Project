<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Test $test
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Test'), ['action' => 'edit', $test->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Test'), ['action' => 'delete', $test->id], ['confirm' => __('Are you sure you want to delete # {0}?', $test->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tests'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Marks'), ['controller' => 'Marks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Mark'), ['controller' => 'Marks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Prerequisites'), ['controller' => 'Prerequisites', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Prerequisite'), ['controller' => 'Prerequisites', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tests view large-9 medium-8 columns content">
    <h3><?= h($test->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($test->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Course') ?></th>
            <td><?= $test->has('course') ? $this->Html->link($test->course->name, ['controller' => 'Courses', 'action' => 'view', $test->course->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($test->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Marks') ?></h4>
        <?php if (!empty($test->marks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Marks') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Test Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($test->marks as $marks): ?>
            <tr>
                <td><?= h($marks->id) ?></td>
                <td><?= h($marks->marks) ?></td>
                <td><?= h($marks->user_id) ?></td>
                <td><?= h($marks->test_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Marks', 'action' => 'view', $marks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Marks', 'action' => 'edit', $marks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Marks', 'action' => 'delete', $marks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $marks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Prerequisites') ?></h4>
        <?php if (!empty($test->prerequisites)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Required Marks') ?></th>
                <th scope="col"><?= __('Pre Id') ?></th>
                <th scope="col"><?= __('Test Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($test->prerequisites as $prerequisites): ?>
            <tr>
                <td><?= h($prerequisites->id) ?></td>
                <td><?= h($prerequisites->required_marks) ?></td>
                <td><?= h($prerequisites->pre_id) ?></td>
                <td><?= h($prerequisites->test_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Prerequisites', 'action' => 'view', $prerequisites->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Prerequisites', 'action' => 'edit', $prerequisites->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Prerequisites', 'action' => 'delete', $prerequisites->id], ['confirm' => __('Are you sure you want to delete # {0}?', $prerequisites->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
