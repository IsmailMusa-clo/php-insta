<?php
include("includes/header.php");

if(isset($_POST['cancel'])) {
	header("Location: settings.php");
}

if(isset($_POST['close_account'])) {
	$close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
	session_destroy();
	header("Location: register.php");
}
?>

<div class="main_column column" style="direction:rtl">

	<h4>إغلاق الحساب</h4>

	هل أنت متأكد أنك تريد إغلاق حسابك؟<br><br>
	إغلاق حسابك سيخفي ملفك الشخصي وجميع أنشطتك من المستخدمين الآخرين.<br><br>
	يمكنك إعادة فتح حسابك في أي وقت عن طريق تسجيل الدخول مجددًا.<br><br>

	<form action="close_account.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="نعم! أغلِقه!" class="danger settings_submit">
		<input type="submit" name="cancel" id="update_details" value="لا! لن أفعل!" class="info settings_submit">
	</form>

</div>
