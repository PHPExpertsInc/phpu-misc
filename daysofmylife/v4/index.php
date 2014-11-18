<?php
/**
 * Days Of My Life App
 * Copyright © 2013 PHP Experts, Inc.
 * Author:  Theodore R. Smith <theodore@phpexperts.pro>
 *          http://users.phpexperts.pro/tsmith/
 * Created: 2013-03-10 23:08 CST
 */

/* Step 0: Compose the background to the story (The Mission)

	[completed] Sarah wants to know how many days old she is.

	She also wants to know when she was, or will be, 1,000 days old, 5,000 days old, etc...

	Finally, she wants to know how many days she will have left if she lives to be X years old.
	OK, she admits that's a little morbid, but hell! She also figures it will help her with
	her time management.  Nothing like knowing you only have X days left ;-/
*/

//

class DayDifferenceCalculator
{
	public $startDate;
    public $startTime;

	public function calcNumberOfDays($endDate)
	{
		if (empty($this->startDate))
		{
			throw new LogicException("Cannot calculate days with no start date set.");
		}

		$startDateObject = new DateTime($this->startDate);
		$endDateObject = new DateTime($endDate);

		$dateInterval = $startDateObject->diff($endDateObject);

		$numberOfDays = $dateInterval->format("%r%a");

		return $numberOfDays;
	}

    public function getYearsBetweenDates($endDate)
    {
        $startDateObject = new DateTime($this->startDate);
        $endDateObject = new DateTime($endDate);
        $dateDiff = $endDateObject->diff($startDateObject);

        // 4.3 Return the number of years.
        return $dateDiff->y;
    }

	// Step 1: Create an action to add X number of days to a date.
	public function getDateAfterXDays($numberOfDays)
	{
		// 1.0 Make sure $numberOfDays is a number.
		if (!is_numeric($numberOfDays))
		{
			throw new LogicException("Number of Days must be a number.");
		}

		// 1.1 Create the appropriate DateInterval.
		// (This is pretty messy; analyze http://www.php.net/manual/en/dateinterval.construct.php)
		$numberOfDaysInterval = new DateInterval("P" . $numberOfDays . "D");

		// 1.2 Add the desired interval to the start date.
		$startDateObject = new DateTime($this->startDate);
		$startDateObject->add($numberOfDaysInterval);

		// 1.3 Return the date.
		return $startDateObject->format('Y-m-d'); // Equiv. of YYYY-mm-dd.
	}

	// Step 4: Create action for determining the number of years after X days.
	public function getYearsAfterXDays($numberOfDays)
	{
		// 4.0 Make sure $numberOfDays is a number.
		if (!is_numeric($numberOfDays))
		{
			throw new LogicException("Number of Days must be a number.");
		}

		// 4.1 Determine the end date.
		$endDate = $this->getDateAfterXDays($numberOfDays);

		// 4.2 Calculate the date difference.
		$startDateObject = new DateTime($this->startDate);
		$endDateObject = new DateTime($endDate);

		$dateDiff = $endDateObject->diff($startDateObject);

		// 4.3 Return the number of years.
		return $dateDiff->y;
	}

	// Step 5: Calculate Expected Days Left
	public function calculateExpectedDaysLeft($lifeExpectancy)
	{
		// 5.0 Make sure $numberOfDays is a number.
		if (!is_numeric($lifeExpectancy))
		{
			throw new LogicException("Life expectancy must be a number.");
		}

		// 5.1 Calculate expected death date. Let's not show to the user, tho. ;-/
		$startDateObject = new DateTime($this->startDate);
		$yearsOfLifeInterval = new DateInterval("P" . $lifeExpectancy . "Y");
		$expectedDeathDate = $startDateObject->add($yearsOfLifeInterval);

		// 5.2 Figure out time left.
		$todaysDateObject = new DateTime(date('Y-m-d'));
		//$dateDiff = $expectedDeathDate->diff($todaysDateObject);
		$dateDiff = $todaysDateObject->diff($expectedDeathDate);

		// 5.3 Return the number of days left ;-/
		return $dateDiff->format("%r%a");;
	}

    public function calculateNumberOfSeconds($endDate)
    {
        if (empty($this->startDate))
        {
            throw new LogicException("Cannot calculate days with no start date set.");
        }

        $this->startDate .= ' ' . $this->startTime;
        $startDateObject = new DateTime($this->startDate);
        $endDateObject = new DateTime($endDate);

        $startEpoch = $startDateObject->format('U');
        $endEpoch = $endDateObject->format('U');

        return ($endEpoch - $startEpoch);
    }

    public function calculateDateAfterXSeconds($seconds)
    {
        if (!is_numeric($seconds))
        {
            throw new LogicException("Number of seconds must be a number.");
        }

        $startDateObject = new DateTime($this->startDate);
        $startEpoch = $startDateObject->format('U');
        $endEpoch = $startEpoch + $seconds;

        $endDateObject = new DateTime("@$endEpoch");
        return $endDateObject->format('Y-m-d');
    }
}

if (!empty($_GET['birthdate']))
{
	$birthDate = $_GET['birthdate'];
    $birthTime = $_GET['birthtime'];

	$dateDiffCalc = new DayDifferenceCalculator();
	$dateDiffCalc->startDate = $birthDate;
    $dateDiffCalc->startTime = $birthTime;
	$todaysDate = date('Y-m-d'); // Returns the equiv. of 'YYYY-mm-dd'.

	$numberOfDays = $dateDiffCalc->calcNumberOfDays($todaysDate);

	// Pretty format number of days:
	$numberOfDays_formatted = number_format($numberOfDays);
    $numberOfSecondsOld = $dateDiffCalc->calculateNumberOfSeconds(date('c'));
    $numberOfSecondsOld_formatted = number_format($numberOfSecondsOld);

	$lifeExpectancy_s = filter_input(INPUT_GET, 'life_expectancy', FILTER_SANITIZE_NUMBER_INT);
	$numberOfDaysLeft = number_format($dateDiffCalc->calculateExpectedDaysLeft($lifeExpectancy_s));

    $billionsSecondsDate[0] = $dateDiffCalc->calculateDateAfterXSeconds(1000000000);
    $billionsSecondsDate[1] = $dateDiffCalc->calculateDateAfterXSeconds(2000000000);
    $billionsSecondsDate[2] = $dateDiffCalc->calculateDateAfterXSeconds(3000000000);
}

include_once '/var/www/phpu.cc/htdocs/lib/meta.php';

$meta = new Meta([
			'title' => 'Days of My Life v4 - The Birthdate Calculator',
			'description' => 'Find out exactly how many days old you are, and when you\'ll finally be
			                  50,000 days old! Find out how many days you have left until you\'re x years old.',

		]);


$header['title'] = 'Days of My Life v4 - The Birthdate Calculator';

require '/var/www/phpu.cc/htdocs/views/_header.tpl.php';

?>
		<style type="text/css">
			#important_days td, th { text-align: center !important }
			input[type=text] { text-align: left; }
		</style>
<?php
	if (isset($numberOfDays_formatted))
	{
?>
		<h2>You are <?php echo $numberOfDays_formatted; ?> days old!</h2>
        <h2>That means you are (at least) <?php echo $numberOfSecondsOld_formatted; ?> seconds old!</h2>
<?php
		// Step 3: Output important dates table.
?>
		<table id="important_days">
			<tr>
				<th>No. of Days</th>
				<th>Date</th>
				<th>Age</th>
			</tr>
			<tr>
				<td>0</td>
				<td><?php echo $dateDiffCalc->getDateAfterXDays(0); ?></td>
				<td>0</td>
			</tr>
			<tr>
				<td>1,000</td>
				<td><?php echo $dateDiffCalc->getDateAfterXDays(1000); ?></td>
				<td><?php echo $dateDiffCalc->getYearsAfterXDays(1000); ?></td>
			</tr>
			<tr>
				<td>5,000</td>
				<td><?php echo $dateDiffCalc->getDateAfterXDays(5000); ?></td>
				<td><?php echo $dateDiffCalc->getYearsAfterXDays(5000); ?></td>
			</tr>
			<tr>
				<td>10,000</td>
				<td><?php echo $dateDiffCalc->getDateAfterXDays(10000); ?></td>
				<td><?php echo $dateDiffCalc->getYearsAfterXDays(10000); ?></td>
			</tr>
			<tr>
				<td>25,000</td>
				<td><?php echo $dateDiffCalc->getDateAfterXDays(25000); ?></td>
				<td><?php echo $dateDiffCalc->getYearsAfterXDays(25000); ?></td>
			</tr>
			<tr>
				<td>50,000</td>
				<td><?php echo $dateDiffCalc->getDateAfterXDays(50000); ?></td>
				<td><?php echo $dateDiffCalc->getYearsAfterXDays(50000); ?></td>
			</tr>
		</table>

		<p>
			With a life expectancy of <strong><?php echo $lifeExpectancy_s; ?></strong>, you currently have an estimated
			<strong><?php echo $numberOfDaysLeft; ?> days</strong> left to live.  Live them well!
		</p>

<?php
        if ($numberOfSecondsOld >= 2000000000) {
?>
            <h3>You were 1 *BILLION* seconds old on <?php echo $billionsSecondsDate[0]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[0])); ?>.<br/>
                You were 2 *BILLION* seconds old on <?php echo $billionsSecondsDate[1]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[1])); ?>.<br/>
                You will be 3 *BILLION* seconds old on <?php echo $billionsSecondsDate[2]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[2])); ?>.</h3>
<?php
        } else if ($numberOfSecondsOld >= 1000000000) {
?>
            <h3>You were 1 *BILLION* seconds old on <?php echo $billionsSecondsDate[0]; ?> at age  <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[0])); ?>.<br/>
                You will be 2 *BILLION* seconds old on <?php echo $billionsSecondsDate[1]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[1])); ?>.<br/>
                You will be 3 *BILLION* seconds old on <?php echo $billionsSecondsDate[2]; ?> at age  <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[2])); ?>.</h3>
        <?php
        } else if ($numberOfSeconds < 1000000000) {
?>
            <h3>You will be 1 *BILLION* seconds old on <?php echo $billionsSecondsDate[0]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[0])); ?>.<br/>
                You will be 2 *BILLION* seconds old on <?php echo $billionsSecondsDate[1]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[1])); ?>.<br/>
                You will be 3 *BILLION* seconds old on <?php echo $billionsSecondsDate[2]; ?> at age <?php echo ($dateDiffCalc->getYearsBetweenDates($billionsSecondsDate[2])); ?>.</h3>
<?php
        }
?>
<?php
	}

?>
		<div id="birthdate_form">
			<form method="get">
				<table style="width: 25em">
					<tr>
						<th>Birthdate: </th>
						<td><input type="text" name="birthdate" id="birthdate"/></td>
					</tr>
                    <tr>
                        <th>Birth Time: </th>
                        <td><input type="text" name="birthtime" id="birthtime" placeholder="24-hour HH:mm"/></td>
                    </tr>
					<tr>
						<th>Life expectancy (in years): </th>
						<td><input type="text" name="life_expectancy"/></td>
					</tr>
				</table>
				<div><input type="submit" value="Calculate Days"/></div>
			</form>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/ui-lightness/jquery-ui.css"/>
		<script type="text/javascript">
$(function() {
	$( "#birthdate" ).datepicker();
});
		</script>
<?php
require '/var/www/phpu.cc/htdocs/views/_footer.tpl.php';
