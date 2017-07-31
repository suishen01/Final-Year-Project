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
                <?php echo $this->Form->control('field1', ['label' => false]);?>
                <p> <font color="blue">***Student's Answer Here***</font></br></p>
                <?php echo $this->Form->control('field2', ['label' => false]);?>
            </fieldset>
            </div>
        <?php echo $this->Form->control('answer', ['label' => 'Expected Output']);?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
