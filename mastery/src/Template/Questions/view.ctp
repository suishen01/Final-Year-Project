

<?php
/**
  * @var \App\View\AppView $this
  */

echo $this->Html->css('codemirror');
echo $this->Html->css('show-hint');
echo $this->Html->css('eclipse');
echo $this->Html->css('button');
echo $this->Html->script('codemirror', array('inline' => 'false'));
echo $this->Html->script('anyword-hint', array('inline' => 'false'));
echo $this->Html->script('clike', array('inline' => 'false'));
echo $this->Html->script('show-hint', array('inline' => 'false'));
echo $this->Html->script('matchbrackets', array('inline' => 'false'));

?>

<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Go Back'), ['controller' => 'Tests', 'action' => 'view', $question->test_id]) ?></li>
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
<div class="courses form large-10 large-10 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= h($question->description) ?></legend>
        <?php
            echo $this->Form->control('answer', ['type' => 'textarea']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), array('class' => 'myButton')) ?>
    <?= $this->Form->end() ?>
    <button class="myButton" id="detail" onClick="clicked()">DETAILS</button>
</div>

<script type="text/javascript">
  var editor = CodeMirror.fromTextArea(answer, {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-java",
	theme: "eclipse",
	extraKeys:{"Ctrl":"autocomplete"}
  });
var result = document.getElementById("result").value;
//$('#result').html(output);
alert(result);

function clicked(){
	var output = document.getElementById("output").value;
	if (output == "" || output == undefined || output == null) {
	} else {
	alert(output);
	}
}
</script>
