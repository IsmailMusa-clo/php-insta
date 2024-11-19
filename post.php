<?php  
include("includes/header.php");

// تحقق مما إذا كانت الـ ID موجودة في الرابط
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	$id = 0;
}
?>

<div class="user_details column">
	<a href="<?php echo $userLoggedIn; ?>">  
		<img src="<?php echo $user['profile_pic']; ?>"> 
	</a>

	<div class="user_details_left_right">
		<a href="<?php echo $userLoggedIn; ?>">
			<?php 
			// عرض اسم المستخدم الأول والأخير
			echo $user['first_name'] . " " . $user['last_name'];
			?>
		</a>
		<br>
		<?php 
		// عرض عدد المنشورات وعدد الإعجابات
		echo "المنشورات: " . $user['num_posts']. "<br>"; 
		echo "الإعجابات: " . $user['num_likes'];
		?>
	</div>
</div>

<div class="main_column column" id="main_column">

	<div class="posts_area">
		<!-- سيتم هنا عرض المنشورات الخاصة -->
	</div>

</div>
