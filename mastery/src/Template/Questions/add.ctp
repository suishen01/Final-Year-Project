<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="questions form large-9 medium-8 columns content">
    <?= $this->Form->create($question) ?>
    <fieldset>
        <legend><?= __('Add Question') ?></legend>
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
        <?php echo $this->Form->control('test_id', ['options' => $tests]);?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<script>
  var textareas = document.getElementsByTagName('textarea');
  var count = textareas.length;
  for(var i=0;i<count;i++){
    textareas[i].onkeydown = function(e){
        if(e.keyCode==9 || e.which==9){
            e.preventDefault();
            var s = this.selectionStart;
            this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
            this.selectionEnd = s+1;
        }
    }
  }
</script>
