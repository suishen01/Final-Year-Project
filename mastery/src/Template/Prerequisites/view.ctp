<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Prerequisite $prerequisite
  */
?>
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
