<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Course $course
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Course'), ['action' => 'edit', $course->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Course'), ['action' => 'delete', $course->id], ['confirm' => __('Are you sure you want to delete # {0}?', $course->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Course'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Enrollment'), ['controller' => 'Enrollment', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Enrollment'), ['controller' => 'Enrollment', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?> </li>        
    </ul>
</nav>
<div class="courses view large-9 medium-8 columns content">
    <h3><?= h($course->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($course->name) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($course->id) ?></td>
        </tr>        
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= $course->published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Enrollment') ?></h4>
        <?php if (!empty($course->enrollment)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($course->enrollment as $enrollment): ?>
            <tr>
                <td><?= h($enrollment->id) ?></td>
                <td><?= h($enrollment->user_id) ?></td>
                <td><?= h($enrollment->course_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Enrollment', 'action' => 'view', $enrollment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Enrollment', 'action' => 'edit', $enrollment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Enrollment', 'action' => 'delete', $enrollment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrollment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tests') ?></h4>
        <?php if (!empty($course->tests)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Published') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($course->tests as $tests): ?>
            <tr>
                <td><?= h($tests->id) ?></td>
                <td><?= $tests->published ? __('Yes') : __('No'); ?></td>
                <td><?= h($tests->name) ?></td>
                <td><?= h($tests->course_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tests', 'action' => 'view', $tests->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tests', 'action' => 'edit', $tests->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tests', 'action' => 'delete', $tests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tests->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
