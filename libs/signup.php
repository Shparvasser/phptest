<?php
session_start();
$tite = "Форма регистриации";
require_once __DIR__ . "/header.php";
require "/OpenServer/domains/TaskTestPhpTwo/dbConfig/db.php";

if (isset($_POST['do_signup'])) {
	$errors = array();

	if (empty($login)) {
		$errors['login'] = 'Введите логин!';
	}

	if (empty($email)) {
		$errors['email'] = 'Введите Email!';
	}

	if (empty($name)) {
		$errors['name'] = 'Введите Имя!';
	}

	if (empty($surname)) {
		$errors['surname'] = 'Введите Фамилию!';
	}

	if (empty($password)) {
		$errors['password'] = 'Введите пароль!';
	}

	if (empty($password2) || $password2 != $password) {
		$errors['password_2'] = 'Повторный пароль введен не верно!';
	}

	if ((mb_strlen($login) < 5 || mb_strlen($login) > 35) && empty($errors['login'])) {
		$errors['login'] = 'Недопустимая длина логина';
	}

	if ((mb_strlen($name) < 3 || mb_strlen($name) > 35) && empty($errors['name'])) {
		$errors['name'] = 'Недопустимая длина имени';
	}

	if ((mb_strlen($surname) < 5 || mb_strlen($surname) > 35) && empty($errors['surname'])) {
		$errors['surname'] = 'Недопустимая длина фамилии';
	}

	if (preg_match("/[^a-zA-Z]/i", $name) && empty($errors['name'])) {
		$errors['name'] = 'Вы ввели некоректный сивол!Разрешены только буквы!';
	}

	if (preg_match("/[^a-zA-Z]/i", $surname) && empty($errors['surname'])) {
		$errors['surname'] = 'Вы ввели некоректный сивол!Разрешены только буквы!';
	}

	if (preg_match("/[^a-zA-Z0-9]/i", $login) && empty($errors['login'])) {
		$errors['login'] = 'Вы ввели некоректный сивол!Разрешены только буквы и цифры!';
	}

	if (preg_match("/[^a-zA-Z0-9]/i", $password) && empty($errors['password'])) {
		$errors['password'] = 'Вы ввели некоректный сивол!Разрешены только буквы и цифры!';
	}

	if (preg_match("/[^a-zA-Z0-9]/i", $password2) && empty($errors['password2'])) {
		$errors['password2'] = 'Вы ввели некоректный сивол!Разрешены только буквы и цифры!';
	}

	if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email) && empty($errors['email'])) {
		$errors['email'] = 'Неверно введен е-mail';
	}

	$query = $mysqli->query("SELECT * FROM `users` WHERE `login` = '$login'");
	$fetchedArray = $query->fetch_assoc();
	if (!empty($fetchedArray['login'])) {
		$errors['login'] = 'Пользователь стаким логином уже сущесвует!';
	}

	$query = $mysqli->query("SELECT * FROM `users` WHERE `email` = '$email'");
	$fetchedArray = $query->fetch_assoc();
	if (!empty($fetchedArray['email'])) {
		$errors['email'] = 'Пользователь стаким Email уже сущесвует!';
	}

	if ($privacy == false) {
		$errors['privacy'] = 'Дайте свое согласие на обработку данных';
	}
	$currentDateTime = "$day/$month/$year";
	$currentDateTimeMy = date("j/n/Y");
	if ($currentDateTime > $currentDateTimeMy) {
		$errors['date'] = 'Введена неправильная дата!';
	}

	if (empty($errors)) {

		$mysqli->query("INSERT INTO `users` (`login`, `email`, `name`, `surname`,`day`,`month`,`year`,`country`,`privacy`,`password`,`registration_time`)
		VALUES('$login', '$email', '$name','$surname', '$day', '$month','$year', '$country', '$privacy','$password', '$registrationTime')");
		$mysqliResult = $mysqli->query("SELECT * FROM `users` WHERE `login` = '$login'");
		$user = $mysqliResult->fetch_assoc();
		$_SESSION['logged_user'] = $user;
		$mysqli->close();
		header('Location:index.php');
		return;
	}
	$savedLogin = $_POST['login'];
	$savedEmail = $_POST['email'];
	$savedName = $_POST['name'];
	$savedSurname = $_POST['surname'];
	$savedPrivacy = $_POST['privacy'];
}
?>

<div class="container mt-4">
	<div class="row">
		<div class="col">
			<h2>Форма регистрации</h2>
			<form action="signup.php" method="post">
				<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" value="<?php echo (isset($savedLogin)) ? $savedLogin : ''; ?>">
				<div style="color: red;"><?php echo $errors['login']; ?></div><br>
				<input type="email" class="form-control" name="email" id="email" placeholder="Введите Email" value="<?php echo (isset($savedEmail)) ? $savedEmail : ''; ?>">
				<div style="color: red;"><?php echo $errors['email']; ?></div><br>
				<input type="text" class="form-control" name="name" id="name" placeholder="Введите имя" value="<?php echo (isset($savedName)) ? $savedName : ''; ?>">
				<div style="color: red;"><?php echo $errors['name']; ?></div><br>
				<input type="text" class="form-control" name="surname" id="surname" placeholder="Введите фамилию" value="<?php echo (isset($savedSurname)) ? $savedSurname : ''; ?>">
				<div style="color: red;"><?php echo $errors['surname']; ?></div><br>
				<tr>
					<th><label for="birthDate_d">Дата рождения:</label></th>
					<td>
						<select name="birthDate_d" id="birthDate_d">
							<?php for ($i = 1; $i <= 31; $i++) {
								if ($i == $row['day'])
									$selected = "selected=\"selected\"";
								else
									$selected = "";
								printf("<option value='%s' " . $selected . ">%s</option>", $i, str_pad($i, 2, "0", STR_PAD_LEFT));
							} ?>
						</select>
						<select name="birthDate_m" id="birthDate_m">
							<?php for ($i = 1; $i <= 12; $i++) {
								if ($i == $row['month'])
									$selected = "selected=\"selected\"";
								else
									$selected = "";
								printf("<option value='%s' " . $selected . ">%s</option>", $i, str_pad($i, 2, "0", STR_PAD_LEFT));
							} ?>
						</select>
						<select name="birthDate_y" id="birthDate_y">
							<?php for ($i = date("Y"), $n = date("Y") - 70; $i >= $n; $i--) {
								if ($i == $row['year'])
									$selected = "selected=\"selected\"";
								else
									$selected = "";
								printf("<option value='%s' " . $selected . ">%s </option>", $i, $i);
							}
							?>
						</select><br>
					</td>
				</tr>
				<div style="color: red;"><?php echo $errors['date']; ?></div><br>
				<tr>
					<th><label>Выберите город:</label></th>
					<td>
						<select name="country" class="form-select" value="">
							<?php
							while ($rows = $resultSet->fetch_assoc()) {
								$country = $rows['country'];
								echo "<option value = '$country'> $country </option>";
							}
							?>
						</select>
					</td>
				</tr><br>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="privacy" id="privacy" <?php echo empty($savedPrivacy) ? '' : ' checked="checked" '; ?> />
					Согласен на обработку персональных данных.
				</div>
				<div style="color: red;"><?php echo $errors['privacy']; ?></div><br>
				<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
				<div style="color: red;"><?php echo $errors['password']; ?></div><br>
				<input type="password" class="form-control" name="password_2" id="password_2" placeholder="Повторите пароль">
				<div style="color: red;"><?php echo $errors['password_2']; ?></div><br>
				<button type="submit" class="btn btn-success" name="do_signup">Зарегистрировать</button>
			</form>
			<br>
			<p>Если вы зарегистрированы, тогда нажмите <a href="login.php"> cюда</a>.</p>
			<p>Вернуться на <a href="index.php"> главную</a>.</p>
		</div>
	</div>
</div>
<?php
require_once __DIR__ . "/footer.php";
?>