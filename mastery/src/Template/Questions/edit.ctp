<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $question->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $question->id)]
            )
        ?></li>
    </ul>
</nav>
<div class="questions form large-9 medium-8 columns content">
    <?= $this->Form->create($question) ?>
    <fieldset>
        <legend><?= __('Edit Question') ?></legend>
        <?php echo $this->Form->control('description');?>
            <div>
            <fieldset>
                <legend><?= __('Code') ?></legend>
                <?php echo $this->Form->control('field1');?>
                <h4>Student's Answer Here</h4>
                <?php echo $this->Form->control('field2');?>
            </fieldset>
            </div>
        <?php echo $this->Form->control('test_id', ['options' => $tests]);?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
