<?php 

include("includes/header.php"); // لتضمين ملف header.php

$message_obj = new Message($con, $userLoggedIn); // إنشاء كائن من كلاس Message

// الحصول على الرسائل الأخيرة أو اسم المستخدم أو رسالة جديدة
if(isset($_GET['u']))
	$user_to = $_GET['u'];
else {
	$user_to = $message_obj->getMostRecentUser();

	if($user_to == false)
		$user_to = 'new';
}

if($user_to != "new")
	$user_to_obj = new User($con, $user_to);

// عند إرسال رسالة
if(isset($_POST['post_message'])) {

	if(isset($_POST['message_body'])) {

		$body = mysqli_real_escape_string($con, $_POST['message_body']);
		$date = date("Y-m-d H:i:s");
		$message_obj->sendMessage($user_to, $body, $date);
	}

}

?>

<div class="user_details column">
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];

			 ?>
			</a>
			<br>
			<?php echo "المنشورات: " . $user['num_posts']. "<br>"; 
			echo "الإعجابات: " . $user['num_likes'];

			?>
		</div>
</div>

<div class="main_column column" id="main_column">
	<?php  
	if($user_to != "new"){
		echo "<h4>أنت و<a style='text-decoration: none;' href='$user_to'>" . $user_to_obj->getFirstAndLastName() . "</a></h4><hr><br>";

		echo "<div class='loaded_messages' id='scroll_messages'>";
			echo $message_obj->getMessages($user_to);
		echo "</div>";
	}
	else {
		echo "<h4>رسالة جديدة</h4>";
	}
	?>

	<div class="message_post">
		<form action="" method="POST">
			<?php
			if($user_to == "new") {
				echo "اختر الصديق الذي ترغب بمراسلته <br><br>";
				?> 
				إلى: <input type='text' onkeyup='getUsers(this.value, "<?php echo $userLoggedIn; ?>")' name='q' placeholder='الاسم' autocomplete='off' id='seach_text_input'>

				<?php
				echo "<div class='results'></div>";
			}
			else {
				echo "<textarea name='message_body' id='message_textarea' placeholder='اكتب رسالتك ...'></textarea>";
				echo "<input type='submit' name='post_message' class='info' id='message_submit' value='إرسال'>";
			}

			?>
		</form>
	</div>

	<script>
		var div = document.getElementById("scroll_messages");
		div.scrollTop = div.scrollHeight;
	</script>

</div>

<div class="user_details column" id="conversations">
		<h4>المحادثات</h4>

		<div class="loaded_conversations">
			<?php echo $message_obj->getConvos(); ?>
		</div>
		<br>
		<a href="messages.php?u=new">رسالة جديدة</a>

</div>
