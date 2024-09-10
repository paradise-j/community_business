<?php
    require_once 'connect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>ลงชื่อเข้าใช้งานระบบ</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	
	<link rel="icon" type="image/png" href="img/login2.png">
	<link href="https://fonts.googleapis.com/css?family=Kanit:300,400,700&display=swap" rel="stylesheet" />

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

	<link rel="stylesheet" href="css/style.css" />
</head>

<body class="img js-fullheight" style="background-image: url(img/bg2.png)">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center my-5">
				<div class="col-md-6 text-center ">
					<h2 class="heading-section">ระบบธุรกิจอัจฉริยะสำหรับกลุ่มวิสาหกิจชุมชน จังหวัดสุราษฎร์ธานี</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4 ">
					<div class="login-wrap p-0">
						<form action="Check_login.php"  method="POST">
							<div class="form-group">
								<input type="tel"name="username" class="form-control" placeholder="ชื่อผู้ใช้งาน" required />
							</div>
							<div class="form-group">
								<input id="password-field" name="password" type="password" class="form-control" placeholder="รหัสผ่าน"
									required />
								<span toggle="#password-field"
									class="fa fa-eye-slash field-icon toggle-password"></span>
							</div>
							<div class="form-group">
								<button type="submit" class="form-control btn btn-primary submit px-3" name="btn_login">
									เข้าสู่ระบบ
								</button>
							</div>
							<div class="form-group d-md-flex">
								<!-- <div class="w-50">
									<label class="checkbox-wrap checkbox-primary">Remember Me
										<input type="checkbox" checked />
										<span class="checkmark"></span>
									</label>
								</div> -->
								<div class="w-100 text-md-right">
									<a href="#" style="color: #fff">ลืมรหัสผ่าน</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>