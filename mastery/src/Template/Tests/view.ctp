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
        <li><?= $this->Html->link(__('New Question'), ['controller' => 'Questions', 'action' => 'add']) ?> </li>
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
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= $test->published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
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
    <div class="related">
        <h4><?= __('Questions') ?></h4>
        <?php if (!empty($test->questions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($test->questions as $questions): ?>
            <tr>
                <td><?= h($questions->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Questions', 'action' => 'view', $questions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Questions', 'action' => 'edit', $questions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Questions', 'action' => 'delete', $questions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
