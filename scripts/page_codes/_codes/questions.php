
<?php
include 'new_question_set.php';
?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">

<?php
if($a){?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="show_window('new_question_set',1);$('#uploaded_files').val('');" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
<?php 
}
?>

</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:50px;float:left;height:20px;">ID</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:280px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:280px;float:left;height:20px;">Questionnaire</div>
<div style="width:40px;float:left;height:20px;">Order</div>
<div style="width:70px;float:left;height:20px;">Questions</div>
<div style="width:70px;float:left;height:20px;">Clients</div>
</div>
