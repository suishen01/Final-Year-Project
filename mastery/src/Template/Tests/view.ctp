<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Test $test
  */

echo $this->Html->css('button');


/*
*<nav class="large-3 medium-4 columns" id="actions-sidebar">
*    <ul class="side-nav">
*        <li class="heading"><?= __('Actions') ?></li>
*        <li><?= $this->Html->link(__('Back to Course Page'), ['controller' => 'Courses', 'action' => 'view', $test->course_id]) ?></li>
*        <li><?= $this->Html->link(__('Edit Test'), ['action' => 'edit', $test->id]) ?> </li>
*        <li><?= $this->Form->postLink(__('Delete Test'), ['action' => 'delete', $test->id], ['confirm' => __('Are you sure you want to delete # {0}?', $test->id)]) ?> </li>
*        <li><?= $this->Html->link(__('New Question'), ['controller' => 'Questions', 'action' => 'add', $test->id]) ?> </li>
*    </ul>
*</nav>
**/
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Go Back'), ['controller' => 'Courses', 'action' => 'view', $test->course_id]) ?></li>
    </ul>
</nav>
<div class="tests view large-9 medium-8 columns content">
    <h3><?= h($test->name) ?></h3>
    <div class="related">
        <?php if (!empty($test->questions)): ?>
        <table cellpadding="0" cellspacing="0" style="width:20%">
            <thead>
                <tr>
                    <th scope="col"><?= __('Question') ?></th>
                    <th scope="col"><?= __('Status') ?></th>
                </tr>
            </thead>
            <tbody>
              <?php $index = 1; ?>
              <?php foreach ($test->questions as $q){ ?>
                <tr>
                  <td><?= h($index) ?></td>
                  <?php $status = False;
                  foreach($completed as $c) {
                    if($c == $q->id): ?>
                      <td>Completed</td>
                    <?php $status = True;
                    endif;
                  }
                  if($status == False): ?>
                    <td>Not Completed</td>
                  <?php endif; ?>
                </tr>
              <?php $index++; ?>
              <?php } ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <?= $this->Html->link("Begin Test", array('controller' => 'Questions','action'=> 'view', $test->questions[0]->id), array( 'class' => 'myButton')) ?>
</div>
