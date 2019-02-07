<?php

/**
 * @param $months
 *
 * @return array
 */
function generateReportArray($months)
{
	$array = ['header' => 'datum,activiteit,uren'];

	foreach ($months as $day) {
		$fullDate = strtotime($day);
		$monthYear = date('M-y', $fullDate);
		$totalDays = daysInMonth($day);

		for ($i = 1; $i <= $totalDays; $i++) {
			$date = $i . '-' . $monthYear;
			$lastWeekday = date('d-M-y', strtotime("last friday of $date"));
			$dayOfTheWeek = date('l', strtotime($date));

			if ($dayOfTheWeek == 'Tuesday' || $dayOfTheWeek == 'Thursday') {
				$array[] = $date. ',stofzuigen,21';
			} elseif ($date == $lastWeekday) {
				$array[] = $date. ',ramen,35';
			} elseif ($i == 01) {
				$array[] = $date. ',koelkast,50';
			} else {
				$array[] = $date;
			}
		}
	}
	return $array;
}

/**
 * @param $fileName
 * @param $array
 */
function writeToCsv($array, $fileName)
{
	if (!isset($fileName)) {
		$fileName = 'file.csv';
	}

	$handle = fopen($fileName, "a");
	fputcsv($handle, $array, PHP_EOL);
	fclose($handle);
}

/**
 * @param $date
 *
 * @return int
 */
function daysInMonth($date)
{
	$array = explode('-', $date);

	return cal_days_in_month(CAL_GREGORIAN, $array[1], $array[2]);
}