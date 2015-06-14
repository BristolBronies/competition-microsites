<?php 
	require "partials/_html-header.php";
	require "partials/_header.php";
	$alreadyEntered = false;
	$testIp = $connection->prepare("SELECT * FROM entrants WHERE ip = :ip AND competition = :competition LIMIT 1");
	$testIp->execute(array("ip" => clientIp(), "competition" => COMPETITION_ID));
	$rows = $testIp->fetchAll();
	if(count($rows) > 0) {
		$alreadyEntered = true;
	}
?>

<div class="grid">

<?php if(time() >= strtotime(COMPETITION_CLOSE)) : ?>

	<aside class="form form--completed" id="form">
		<header class="form__header">
			<h1 class="form__title">Too bad!</h1>
		</header>
		<div class="form__body">
			<p>This entry period for this giveaway has now ended. Keep an eye on the <a href="http://twitter.com/bristolbronies">@bristolbronies Twitter account</a> for information on upcoming giveaways and competitions!</p>
		</div>
	</aside>

<?php else : ?>

	<?php if($alreadyEntered) : ?>

		<aside class="form form--completed" id="form">
			<header class="form__header">
				<h1 class="form__title">We got it!</h1>
			</header>
			<div class="form__body">
				<p>You've successfully entered this super-ultra-extreme-awesome-mazing giveaway. We'll get in touch with you if you win anything. Good luck!</p>
			</div>
		</aside>

	<?php else : ?>

		<form class="form form--completed" rel="form" id="form">
			<header class="form__header">
				<h1 class="form__title">Entry form</h1>
			</header>
			<div class="form__body">
				<div class="form__row">
					<label for="name" class="form__label">Full name</label>
					<div class="form__controls">
						<input class="form__input" type="text" name="name" id="name" placeholder="Your name" required>
					</div>
				</div>
				<div class="form__row">
					<label for="email" class="form__label">Email address</label>
					<div class="form__controls">
						<input class="form__input" type="email" name="email" id="email" placeholder="Your email address" required>
					</div>
				</div>
				<div class="form__row form__row--legal">
					<p><small>Please provide a real email address, we need it to contact you if you win anything. We won't use it for anything else, Pinkie promise!</small></p>
				</div>
				<div class="form__row">
					<div class="form__controls">
						<label class="form__checkbox">
							<input type="checkbox" name="terms" id="terms">
							I accept the <a href="?view=terms">terms and conditions</a> of entry.
						</label>
					</div>
				</div>
				<div class="form__row form__row--submit">
					<button type="submit" class="form__submit">Enter!</button>
				</div>
			</div>
		</form>

	<?php endif; ?>

<?php endif; ?>

</div>

<?php 
	require "partials/_footer.php";
	require "partials/_html-footer.php";
?>