<?php

$title = "Главная страница";
require __DIR__ . '/header.php';
require "db.php";
?>

<div class="container mt-4">
	<div class="row">
		<div class="col">
			<center>
				<h1>Добро пожаловать на наш сайт!</h1>
			</center>
		</div>
	</div>
</div>


<?php if (isset($_SESSION['logged_user'])) : ?>
	Привет, <?php echo $_SESSION['logged_user']->name; ?>,
	<?php echo $_SESSION['logged_user']->email; ?></br>


	<a href="logout.php">Выйти</a>
<?php else : ?>


	<a href="login.php">Авторизоваться</a><br>
	<a href="signup.php">Регистрация</a>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>