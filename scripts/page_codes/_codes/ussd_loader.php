<div style="width:100%;height:auto;float:left;">
	<div style="width:400px;height:auto;margin:0 auto;">
	
		<div style="width:100%;height:30px;line-height:30px;float:left;">
			<div style="width:150px;height:30px;float:left;">Phone number:</div>
			<div style="width:220px;float:right;height:30px;"><input type="text" value="260978763044" placeholder="Enter phone number here" style="width:90%;height:30px;float:left;" id="c_id" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='260978763044';alert('Phone number has to be made of digits only');}"></div>
		</div>
		
		<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:2px;">
			<div style="width:150px;height:30px;float:left;">USSD string:</div>
			<div style="width:220px;float:right;height:30px;"><input type="text" value="573" placeholder="Enter string here" style="width:90%;height:30px;float:left;" id="ussd_string" onfocusout="if(this.value==''){this.value='0';}" onfocus="this.value=''" onkeyup="if(event.keyCode == 13){fetch_ussd_loader();}"></div>
		</div>
		
		<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:2px;">
			<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="meeting_fetch_button" onclick="fetch_ussd_loader()" title="Click to request">Send</div>
		</div>
		
		
		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #aaa;margin-top:10px;text-align:center;font-weight:bold;">USSD response</div>
		<div style="width:100%;min-height:200px;height:auto;float:left;border-bottom:solid 1px #aaa;margin-bottom:10px;" id="ussd_response"></div>
		
		<div style="width:100%;height:auto;float:left;">
			<?php
				for($i=0;$i<16;$i++){
					?>
					<div style="text-align:center;margin:2px;width:25px;height:25px;line-height:25px;text-align:center;float:left;cursor:pointer;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="$('#ussd_string').val(<?php print($i);?>);fetch_ussd_loader()"><?php print($i);?></div>
					
					<?php
				}
			?>
			
			<div style="text-align:center;margin:2px;width:25px;height:25px;line-height:25px;text-align:center;float:left;cursor:pointer;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="$('#ussd_string').val('b');fetch_ussd_loader()">b</div>
			
			<div style="text-align:center;margin:2px;width:25px;height:25px;line-height:25px;text-align:center;float:left;cursor:pointer;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="$('#ussd_string').val('b');fetch_ussd_loader()">y</div>
			
			<div style="text-align:center;margin:2px;width:25px;height:25px;line-height:25px;text-align:center;float:left;cursor:pointer;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="$('#ussd_string').val('b');fetch_ussd_loader()">n</div>
		</div>
		
	</div>
</div>

<script>
fetch_ussd_loader();
</script>