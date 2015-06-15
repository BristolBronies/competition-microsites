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

		<noscript>
			<strong>Hold it!</strong> You need JavaScript enabled in order to submit this form. Chances are you do and your internet borked. Try refreshing the page and trying again.
		</noscript>

		<form class="form form--completed" rel="form" id="form">
			<header class="form__header">
				<h1 class="form__title">Entry form</h1>
			</header>
			<div class="form__body">
				<div class="form__row">
					<label for="name" class="form__label">Name</label>
					<div class="form__controls">
						<input class="form__input" type="text" name="name" id="name" placeholder="Your name" required>
						<span class="form__error" data-error="required">What should we call you?</span>
					</div>
				</div>
				<div class="form__row">
					<label for="email" class="form__label">Email address</label>
					<div class="form__controls">
						<input class="form__input" type="email" name="email" id="email" placeholder="Your email address" required>
						<span class="form__error" data-error="required">We can't get in touch unless you tell us how!</span>
						<span class="form__error" data-error="invalidformat">Err, something here seems amiss. Double check it, will you?</span>
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
						<span class="form__error" data-error="required">No T&amp;Cs, no entry, I'm afraid.</span>
					</div>
				</div>
				<div class="form__row form__row--submit">
					<button type="submit" class="form__submit">Enter!</button>
					<span class="form__error" data-error="alreadyentered">Our high-tech records say you're already in this one. No dupes, please!</span>
					<span class="form__error" data-error="savefail">It's not you, it's us. Accessing the database failed.</span>
					<span class="form__error" data-error="nodata">We lost your data somehow. Please try again.</span>
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