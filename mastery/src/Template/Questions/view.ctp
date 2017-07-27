
<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="courses form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= h($question->description) ?></legend>
        <?php
            echo $this->Form->control('answer', ['type' => 'textarea']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
