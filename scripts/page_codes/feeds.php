<?php 
include '_codes/image_uploader.php';
?>

<div style="width:550px;min-height:540px;height:auto;margin: 0 auto;margin-top:5px;">
<div style="width:100%;float:left;height:auto;">

<div style="width:100%;min-height:30px;height:auto;float:left;margin-bottom:15px;">
<form action="" method="post" name="newPostForm" enctype="multipart/form-data">
<input type="hidden" name="fileSize" value="500000">
<textarea onfocus="if(this.value=='Post something here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Post something here';this.style.color='#888';}" name="newPost" id="newPost" style="background-color:#fff;font-family:arial;font-size:0.9em;min-width:100%;max-width:100%;min-height:30px;height:auto;color:#888;border:solid 1px #eee;">Whats happening in your area? Share your experiences with the Discover - Health Team</textarea>
<div onclick="if(document.newPostForm.newPost.value=='Post something here'){alert('You cant make an empty post. Write something to post');}else{make_feed_post('<?php print($activeUser_date);?>');}" style="text-align:center;cursor:pointer;width:70px;line-height:20px;height:20px;background-color:#006BB3;color:#fff;float:right;margin-top:5px;" onmouseover="this.style.backgroundColor='#88e';" onmouseout="this.style.backgroundColor='#006BB3';">Post</div>

<div style="width:100%;height:auto;float:left;color:green;" id="uploaded_images"></div>

<input type="file" name="postImg" style="cursor:pointer;z-index:1;opacity:0;display:none;" id="post_image">
<div id="addImg" style="width:80px;line-height:20px;height:20px;background-color:orange;color:white;text-align:center;cursor:pointer;" onclick="open_uploader('process_feed_image()',1);$('#image_0').click();" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';">Add images</div>
</form>
</div>
</div>

<?php 

$posts = mysqli_query($connect,"select * from posts where companyID = $company_id order by id desc") or die(mysqli_error($connect));
if(mysqli_num_rows($posts) == 0){?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;font-weight:bold;text-align:center;" id="no_data_message">
	No posts where found.
</div>
	
	<?php
}
?>
<div style="width:100%;float:left;min-height:550px;height:auto;" id="postings">

<?php
for($p=0;$p<mysqli_num_rows($posts);$p++){
	$postResults = mysqli_fetch_array($posts, MYSQLI_ASSOC);

	$company_id = $postResults['companyID'];
	$company = mysqli_query($connect,"select * from companies where id = $company_id")or die(mysqli_error($connect));
	$company_results = mysqli_fetch_array($company,MYSQLI_ASSOC);
	
	$postDate = $postResults['postDate'];
	$postID = $postResults['id'];

?>
<div style="width:100%;min-height:30px;height:auto;float:left;margin-top:10px;font-size:1.2em;">
<div style="width:100%;float:left;">
<font size="3px" color="#006BB3"><?php print($company_results['_name']);?> - Posted <?php if(date('jS M, Y', time()) == date('jS M, Y',$postDate)){print("today");}elseif((time() - $postDate) < 172800){print("yesterday");}else{print("on ".date('dS M, Y',$postDate));} print(' at '.date('H:i:s',$postDate));?></font>
<div style="width:100%;height:auto;float:left;color:#000;font-size:0.9em;"><?php print($postResults['details']);?></div>
</div>
<?php
if($postResults['postImg'] != ''){
	$post_images_array = explode(",",$postResults['postImg']);
		
	$image_width = (550 / count($post_images_array)) - 10;
	if($image_width < 105){
		$image_width = 100;
	}
?>
<div style="width:100%;height:auto;margin-top:5px;float:left;">
<?php
	for($i=0;$i<count($post_images_array);$i++){
		print('<div style="width:'.$image_width.'px;height:auto;float:left;border:solid 1px #aaa;margin:2px;cursor:pointer" onmouseover="this.style.border=\'solid 1px #006bb3\';" onmouseout="this.style.border=\'solid 1px #aaa\';" onclick="change_gallery_big_view(\'imgs/'.$post_images_array[$i].'\');"><img src="imgs/'.$post_images_array[$i].'" style="width:'.$image_width.'px"></div>');
			
	}
	?>
</div>
<?php
}
?>
</div>

<div style="width:100%;height:auto;" id="blog_comment_holder_<?php print($postResults['id']);?>">
<?php
$comments = mysqli_query($connect,"select * from postcomments where postID = $postID order by id asc") or die(mysqli_error($connect));

for($c=0;$c<mysqli_num_rows($comments);$c++){
	$commentResults = mysqli_fetch_array($comments, MYSQLI_ASSOC);
	$commentDate = $commentResults['commentDate'];
	$comment_company_id = $commentResults['company_id'];

	$commentOwner = mysqli_query($connect,"select * from companies where id = $comment_company_id") or die(mysqli_error($connect));
	
	$commentOwnerResults = mysqli_fetch_array($commentOwner, MYSQLI_ASSOC);
	$comment_owner_name = $commentOwnerResults['_name'];
	
?>
<div style="padding:5px;width:98%;min-height:30px;height:auto;float:left;margin-bottom:3px;background-color:#eef;">
<div style="width:90%;float:left;">
<font size="2px" color="#006BB3"><?php print($comment_owner_name);?> - Commented <?php if(date('jS M-Y', time()) == date('jS M-Y',$commentDate)){print("today");}elseif((time() - $commentDate) < 172800){print("yesterday");}else{print("on ".date('jS M-Y',$postDate));} print(' at '.date('H:i:s',$commentDate));?></font>
<div style="width:100%;min-height:30px;height:auto;float:left;color:#000;font-size:0.9em;"><?php print($commentResults['details']);?></div>
</div>
</div>
<?php
}
?>
</div>
<div style="width:100%;height:auto;margin-top:5px;float:left;margin-bottom:5px;">
<div style="width:100%;min-height:30px;height:auto;float:left;"><textarea name="post_commment_<?php print($postResults['id']);?>" id="post_commment_<?php print($postResults['id']);?>" style="min-width:100%;max-width:100%;min-height:30px;height:auto;color:#aaa;border:solid 1px #eee;border-bottom:solid 1px #eee;font-family:arial;" onfocus="if(this.value=='Add comment'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Add comment';this.style.color='#888';}">Add comment</textarea></div>
<div onclick="if($('#post_commment_'+<?php print($postResults['id']);?>).val()=='Add comment'){alert('You cant make an empty comment. Put something to comment');}else{new_post_comment(<?php print($postResults['id']);?>);}" style="margin-top:5px;text-align:center;cursor:pointer;width:70px;height:20px;background-color:#88e;color:#fff;float:right;" onmouseover="this.style.backgroundColor='#aaf';" onmouseout="this.style.backgroundColor='#88e';">Comment</div>
</div>
<?php
}
?>
</div>
</div>