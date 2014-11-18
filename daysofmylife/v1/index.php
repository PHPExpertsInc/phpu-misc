<?php
/**
 * Days Of My Life App
 * Copyright © 2013 PHP Experts, Inc.
 * Author:  Theodore R. Smith <theodore@phpexperts.pro>
 *          http://users.phpexperts.pro/tsmith/
 * Created: 2013-03-10 10:48 CST
 */

/* Intro:

	The vast majority of people (particularly women) believe that programming is incredibly difficult.

	It's not!

	In fact, if you are able to imagine simplistic stories where various people/things do various actions,
	then *you* can become a master code craftsman/woman.  You just have to work on learning how to translate
	English sentences into code, and PHP is one of the more easier languages to pick up.

	Programming is so relatively simple that any true code craftsman's code should be readily understandable
	by almost anyone, even if they do not have any formal programming training.

	The great news is that if you work your way through understanding this little app, you will end up with
	just about the same level of knowledge as a person who has been attending computer science classes for
	two or three weeks ;o
*/

/* Step 0: Compose the background to the story (The Mission)

	Sarah wants to know how many days old she is.

	She also wants to know when she was, or will be, 1,000 days old, 5,000 days old, etc...

	Finally, she wants to know how many days she will have left if she lives to be X years old.
	OK, she admits that's a little morbid, but hell! She also figures it will help her with
	her time management.  Nothing like knowing you only have X days left ;-/
*/

// (In PHP, variables are things that hold pieces of data and can be changed, reset, or renewed
//  as desired.  They take the form of $variableName = 'Some piece of data.';)

// Step 1: Create the Day Difference Calculator script, otherwise known as a class.

class DayDifferenceCalculator
{
	// (Classes are akin to an Actor's script in a story [both animate and inanimate].
	//  Classes define exactly what an actor can do and say.)

	public $startDate;
	// (Variables like this inside of a class are called its "properties".
	//  Public properties are akin to settings that anyone should be able to see and change
	//  at will.)

	public function calcNumberOfDays($endDate)
	{
		// (Class functions are akin to the Actor's actions.)
		// (Public class functions are actions that anyone should be able to tell them to do.)

		// ($endDate is the function's "parameter"; it's just a variable who's data comes from
		//  outside of the function.)

		// Step 2: Calculate the number of days between two dates.
		// 2.0: Make sure the calling actor has set the startDate, if not, stop working and
		//      tell them why.
		if (empty($this->startDate))
		{
			throw new LogicException("Cannot calculate days with no start date set.");
		}

		// 2.1 Use PHP's DateTime actor to actually handle the complex calculation.
		// (This gets a little hairy, because this part of PHP is not as elegantly designed
		//  as I would like :-/)
		$startDateObject = new DateTime($this->startDate);
		// "$this->" signifies that we're looking for the class' property, listed up above.
		$endDateObject = new DateTime($endDate);

		// 2.2 Calculate difference in the dates.
		$dateInterval = $startDateObject->diff($endDateObject);

		// 2.3 Finesse out the desired interval (days). See http://www.php.net/manual/en/dateinterval.format.php
		$numberOfDays = $dateInterval->format("%r%a");

		// 2.4 Return the data to the caller.
		return $numberOfDays;
	}
}

// Step 7: Only run the birthdate calculator if the user has submitted their own birthdate:
if (!empty($_GET['birthdate']))
{
	// 7.1: For consistency, move the birthdate input here:
	// Step 0.1: Store Sarah's birthdate.
	// Step 6: I'm going to go back and plug in the user-submitted date.
	$birthDate = $_GET['birthdate'];

	// Step 3: Create the DayDifference actor.
	$dateDiffCalc = new DayDifferenceCalculator();
	// ($dateDiffCalc is a variable, holding what is called "an object" of class "DayDifferenceCalculator".
	//  That's a fancy way of saying that it's an actor following the DayDifferenceCalculator script.

	// 3.1 Set $dateDiff's start date to Sarah's birthdate (see line 40).
	$dateDiffCalc->startDate = $birthDate;

	// 3.2 Get today's date and store it.
	$todaysDate = date('Y-m-d'); // Returns the equiv. of 'YYYY-mm-dd'.

	// 3.3 Tell it to calculate and return the number of days between the birthdate and today, and
	//     store the number of days into a variable.
	$numberOfDays = $dateDiffCalc->calcNumberOfDays($todaysDate);

	// Step 5: Now I'm going to add an HTML form that will accept a birth date.

	// Pretty format number of days:
	$numberOfDays_formatted = number_format($numberOfDays);
}

$header['title'] = 'Days of My Life v1 - The Birthdate Calculator';

require '/var/www/phpu.cc/views/_header.tpl.php';
?>
<?php
	// Output the number of days here, so that it looks more consistent.
	if (isset($numberOfDays_formatted))
	{
?>
		<h2>You are <?php echo $numberOfDays_formatted; ?> days old!</h2>
<?php
	}
?>
		<div id="birthdate_form">
			<!-- Oops! I forgot the form! -->
			<form method="get">
				<div>Birthdate: <input type="text" name="birthdate" /></div>
				<div><input type="submit" value="Calculate Days"/></div>
			</form>
		</div>
<?php
require '/var/www/phpu.cc/views/_footer.tpl.php';
