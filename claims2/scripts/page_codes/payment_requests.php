<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#b4649d;cursor:pointer;" onclick="$('#filter_options').slideToggle('fast');">Activity Bill Payment Tracker</div>

<?php
include '_codes/filter_options.php';
?>

<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_script('_codes/tracker.php?a=3','tracker');tab_item_change(3);">For amendment (<font id="count_3">?</font>)</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_script('_codes/tracker.php?a=2','tracker');tab_item_change(2);">Amended (<font id="count_2">?</font>)</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_script('_codes/tracker.php?a=0','tracker');tab_item_change(0);">Pending (<font id="count_0">?</font>)</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_script('_codes/tracker.php?a=1','tracker');tab_item_change(1);">Completed (<font id="count_1">?</font>)</div>
</div>

<div class="general_holder" id="tracker">


</div>

</div>

<script>
fetch_script('_codes/tracker.php?a=0','tracker');tab_item_change(0);
</script>