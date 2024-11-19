<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
?>

<div class="main_column column"  style="direction: rtl;">

	<h4>إعدادات الحساب</h4>
	<?php
	echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
	?>
	<br>
	<a href="upload.php">رفع صورة شخصية جديدة</a> <br><br><br>

	قم بتعديل القيم واضغط على 'تحديث التفاصيل'

	<?php
	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	?>

	<form action="settings.php" method="POST">
		الاسم الأول: <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"><br>
		الاسم الأخير: <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"><br>
		البريد الإلكتروني: <input type="text" name="email" value="<?php echo $email; ?>" id="settings_input"><br>

		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="تحديث التفاصيل" class="info settings_submit"><br>
	</form>

	<h4>تغيير كلمة المرور</h4>
	<form action="settings.php" method="POST">
		كلمة المرور القديمة: <input type="password" name="old_password" id="settings_input"><br>
		كلمة المرور الجديدة: <input type="password" name="new_password_1" id="settings_input"><br>
		إعادة كلمة المرور الجديدة: <input type="password" name="new_password_2" id="settings_input"><br>

		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="save_details" value="تحديث كلمة المرور" class="info settings_submit"><br>
	</form>

	<h4>إغلاق الحساب</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="إغلاق الحساب" class="danger settings_submit">
	</form>

</div>
