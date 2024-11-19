<?php  

require 'config/config.php'; // تضمين ملف config.php
require 'includes/form_handlers/register_handler.php'; // تضمين ملف register_handler.php
require 'includes/form_handlers/login_handler.php'; // تضمين ملف login_handler.php

?>

<!DOCTYPE html >
<html dir="rtl">
<head>
	<title>مرحباً بك في انستا..!!</title>
	<meta charset="utf8">

  <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php  
	if(isset($_POST['register_button'])) {

		echo '
		<script>

		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});

		</script>

		';
	}
	?>

	<div class="wrapper">

		<div class="login_box">

			<div class="login_header">
				<h1>انستا..!  </h1>
				<p> قم بتسجيل الدخول أو إنشاء حساب جديد أدناه! </p>
			</div>

			</br>

			<!-- قسم تسجيل الدخول -->

			<div id="first">

				<!-- نموذج تسجيل الدخول -->

				<form action="register.php" method="POST">

					<!-- البريد الإلكتروني -->

					<input type="email" name="log_email" placeholder="بريدك الإلكتروني" value="<?php 
					if(isset($_SESSION['log_email'])) {
						echo $_SESSION['log_email'];
					} 
					?>" required>
					<br>

					<!-- كلمة المرور -->

					<input type="password" name="log_password" placeholder="كلمة المرور">
					<br>

					<!-- قسم الأخطاء -->

					<?php if(in_array("بيانات الدخول غير صحيحة..!!<br>", $error_array)) echo  "بيانات الدخول غير صحيحة..!!<br>"; ?>

					<!-- زر تسجيل الدخول -->

					<input type="submit" name="login_button" value="تسجيل الدخول">
					<br>

					<!-- رابط للانتقال إلى نموذج التسجيل -->

					<a href="#" id="signup" class="signup">هل تحتاج إلى حساب؟ قم بالتسجيل هنا!</a>

				</form>

			</div>

			<!-- قسم التسجيل -->

			<div id="second">

				<!-- نموذج التسجيل -->

				<form action="register.php" method="POST">

					<!-- الاسم الأول -->

					<input type="text" name="reg_fname" placeholder="الاسم الأول" value="<?php 
					if(isset($_SESSION['reg_fname'])) {
						echo $_SESSION['reg_fname'];
					} 
					?>" required>

					<!-- اسم العائلة -->
					
					<input type="text" name="reg_lname" placeholder="اسم العائلة" value="<?php 
					if(isset($_SESSION['reg_lname'])) {
						echo $_SESSION['reg_lname'];
					} 
					?>" required>
					<br>

					<!-- قسم الأخطاء -->

					<?php if(in_array("يجب أن يكون الاسم الأول بين 2-25 حرفاً</br>",$error_array)) echo "يجب أن يكون الاسم الأول بين 2-25 حرفاً</br>"; ?>
					<?php if(in_array("يجب أن يكون اسم العائلة بين 2-25 حرفاً</br>",$error_array)) echo "يجب أن يكون اسم العائلة بين 2-25 حرفاً</br>"; ?>

					<!-- البريد الإلكتروني -->

					<input type="email" name="reg_email" placeholder="البريد الإلكتروني" value="<?php 
					if(isset($_SESSION['reg_email'])) {
						echo $_SESSION['reg_email'];
					} 
					?>" required>

					<!-- تأكيد البريد الإلكتروني -->
					
					<input type="email" name="reg_email2" placeholder="تأكيد البريد الإلكتروني" value="<?php 
					if(isset($_SESSION['reg_email2'])) {
						echo $_SESSION['reg_email2'];
					} 
					?>" required>
					<br>

					<!-- قسم الأخطاء -->

					<?php if(in_array("البريد الإلكتروني مستخدم بالفعل</br>",$error_array)) echo "البريد الإلكتروني مستخدم بالفعل</br>"; ?>
					<?php if(in_array("تنسيق البريد الإلكتروني غير صحيح</br>",$error_array)) echo "تنسيق البريد الإلكتروني غير صحيح</br>"; ?>
					<?php if(in_array("البريد الإلكتروني لا يتطابق</br>",$error_array)) echo "البريد الإلكتروني لا يتطابق</br>"; ?>
					
					<!-- كلمة المرور -->

					<input type="password" name="reg_password" placeholder="كلمة المرور" required>
					
					<input type="password" name="reg_password2" placeholder="تأكيد كلمة المرور" required>
					<br>

					<!-- قسم الأخطاء -->

					<?php if(in_array("كلمات المرور لا تتطابق</br>",$error_array)) echo "كلمات المرور لا تتطابق</br>"; ?>
					<?php if(in_array("يجب أن تحتوي كلمة المرور على أحرف وأرقام فقط</br>",$error_array)) echo "يجب أن تحتوي كلمة المرور على أحرف وأرقام فقط</br>"; ?>
					<?php if(in_array("يجب أن تكون كلمة المرور بين 5-30 حرفاً</br>",$error_array)) echo "يجب أن تكون كلمة المرور بين 5-30 حرفاً</br>"; ?>

					<!-- زر التسجيل -->

					<input type="submit" name="register_button" value="إنشاء حساب">
					<br>

					<!-- رسالة النجاح -->

					<?php if(in_array("<span style='color: #14C800;'>تم التسجيل بنجاح! قم بتسجيل الدخول الآن!</span><br>", $error_array)) echo "<span style='color: #14C800; margin-left: -80px;'>تم التسجيل بنجاح! قم بتسجيل الدخول الآن!</span><br>"; ?>

					<!-- رابط للانتقال إلى نموذج تسجيل الدخول -->
					
					<a href="#" id="signin" class="signin">هل لديك حساب بالفعل؟ قم بتسجيل الدخول هنا!</a>

				</form>

			</div>

		</div>

	</div>

</body>
</html>
