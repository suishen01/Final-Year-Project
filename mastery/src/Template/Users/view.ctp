<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User $user
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Enrollment'), ['controller' => 'Enrollment', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Enrollment'), ['controller' => 'Enrollment', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Marks'), ['controller' => 'Marks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Mark'), ['controller' => 'Marks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Enrollment') ?></h4>
        <?php if (!empty($user->enrollment)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->enrollment as $enrollment): ?>
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
        <h4><?= __('Related Marks') ?></h4>
        <?php if (!empty($user->marks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Marks') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Test Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->marks as $marks): ?>
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
</div>
