<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('_partials/head.php'); ?>
</head>

<body>
	<?php $this->load->view('_partials/navbar.php'); ?>

	<div class="container">
		<h1>Contact Us</h1>
		<p>Hubungi kami melalui form berikut</p>
		<form action="" method="post" style="max-width: 600px;">

			<!-- set_value() adalah fungsi untuk mengisi ulang nilai pada input field 
		dengan nilai sebelumnya. Fungsi ini akan mencegah input field dikosongkan 
		saat kita submit dan terjadi invalid. -->

			<!-- form_error() adalah fungsi untuk menampilkan pesan feedback saat 
		input field invalid. -->

			<div>
				<label for="name">Name*</label>
				<input type="text" name="name" class="<?= form_error('name') ? 'invalid' : '' ?>" placeholder="your name" value="<?= set_value('name') ?>" required maxlength="32" />
				<div class="invalid-feedback"><?= form_error('name') ?></div>
			</div>
			<div>
				<label for="email">Email*</label>
				<input type="email" name="email" class="<?= form_error('email') ? 'invalid' : '' ?>" placeholder="your email address" value="<?= set_value('email') ?>" required />
				<div class="invalid-feedback"><?= form_error('email') ?></div>
			</div>
			<div>
				<label for="messaage">Message*</label><br>
				<textarea name="message" cols="30" rows="5" class="<?= form_error('message') ? 'invalid' : '' ?>" required placeholder="write your message"><?= set_value('message') ?></textarea>
				<div class="invalid-feedback"><?= form_error('message') ?></div>
			</div>

			<div style="display: flex; gap: 1rem">
				<input type="submit" class="button button-primary" value="Kirim">
				<input type="reset" class="button" value="Reset">
			</div>
		</form>
	</div>

	<?php $this->load->view('_partials/footer.php'); ?>
</body>

</html>