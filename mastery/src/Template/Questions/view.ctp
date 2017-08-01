
<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Back to Test Page'), ['controller' => 'Tests', 'action' => 'view', $question->test_id]) ?></li>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('Questions') ?></th>
                </tr>
            </thead>
            <tbody>
              <?php $index = 1; ?>
              <?php foreach ($questions as $q){ ?>
                <tr>
                    <td>
                        <?= $this->Html->link($index, ['action' => 'view', $q->id]) ?>
                    </td>
                </tr>
              <?php $index++; ?>
              <?php } ?>
            </tbody>
        </table>
    </ul>
</nav>
<div class="courses form large-10 medium-8 columns content">
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
