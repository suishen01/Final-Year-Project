<?php
$key = isset($key) ? $key : '<%= key %>';
?>
<tr>
    <td>
        <?php echo $this->Form->control("prerequisites.{$key}.pre_id", ['options' => $tests, 'label' => false, 'empty' => ' ']); ?>
    </td>   
    <td>
        <?php echo $this->Form->control("prerequisites.{$key}.required_marks", ['label' => false, 'min' => 0, 'max' => 100]); ?>
    </td>
    <td class="actions">
        <a href="#" class="remove">Remove prerequisite</a>
    </td>
</tr>