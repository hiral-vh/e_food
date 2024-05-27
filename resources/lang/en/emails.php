<?php

return
	[
		'forgot_email' => 'e-food Reset Password',
		'forgot_email_body' => '<p style="font-family: "Poppins-SemiBold";">Hello Username,</p><br/> :HTMLTABLE',

		'otp_email' => 'e-food Register OTP',
		'otp_email_body' => '<p style="font-family: "Poppins-SemiBold";">Hello :USERNAME,</p><br/> :HTMLTABLE',



		'template' => '<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>e-food</title>
			<style>
				@font-face {
					font-family: "Poppins-Regular";
					src: url(' . URL::to('/') . '/mail-template\fonts/Poppins-Regular.ttf);
				}

				@font-face {
					font-family: "Poppins-SemiBold";
					src: url(' . URL::to('/') . '/mail-template/fonts/Poppins-SemiBold.ttf);
				}

				body {
					padding: 0;
					margin: 0;
					font-family: "Poppins-Regular";
					font-size: 14px;
				}

				.border tr,
				.border td {
					border-bottom: 1px solid #ccc;
					padding: 8px;
				}

				.border {
					border-spacing: 0;
				}
			</style>
		</head>

		<body>
			<table style="width: 600px;margin: 20px auto;">
				<tr>
					<td>
						<center><img src="' . URL::to('/') . '/mail-template/images/logo.png" style="width: 34%;" alt=""></center>
					</td>
				</tr>
			</table>
			<table style="    width: 600px;  margin: 20px auto;    background: #ede4e5;    font-size: 14px;    padding: 8px 20px;    border-radius: 15px;">
				<tr>
					<td>
					:BODYCONTENT
					</td>
				</tr>
			</table>
			<table style="    width: 600px;  margin: 20px auto;    background: #ede4e5;    font-size: 12px;    padding: 15px;    border-radius: 15px;">
				<tr>
					<td style="text-align: center;">' . date('Y') . ' © Food Services, All Right Reserved</td>
				</tr>
			</table>
		</body>
		</html>',
	];
