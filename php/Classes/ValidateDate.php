<?php
namespace TaylorSmith\objectOrientedProject;
/**
 * Trait that will validate a mySQL date
 *
 * This trait will accept mySql style dates, convert string representations to DateTime object, or throw an exception
 *
 *@author Taylor Smith <taylorleesmith92@gmail.com>
 **/
trait ValidateDate {
	/**
	 * filter for mySQL date
	 *
	 * converts string date into a DateTime object; should be used within a mutator method
	 *
	 * @param \DateTime|string $newDate date that will be validated
	 * @return \DateTime DateTime object containing the validated date
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError if type hints have failed
	 **/
	private static function validateDate($newDate) : \DateTime {
		//if date is already an object the return $newDate
		if(is_object($newDate) === true && get_class($newDate) === "DateTime") {
			return ($newDate);
		}
		//treat the date as a mySQL date string: Y-m-d
		$newDate = trim($newDate);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $newDate, $matches)) !== 1) {
			throw(new \InvalidArgumentException("date is not valid"));
		}
		//verify that the date is a real calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false) {
			throw(new \RangeException("date is not a Gregorian date"));
		}
		// at this point date is clean and ready to format and save
		$newDate = \DateTime::createFromFormat("Y-m-d H:i:s", $newDate . "00:00:00");
		return($newDate);
	}
	/**
	 * filter for mySQL style dates
	 *
	 * converts a string into a DateTime object; meant to be used in a mutator
	 *
	 * @param mixed $newDateTime date to validate
	 * @return \DateTime DateTime object containing the validated date
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError if type hints fail
	 * @throws \Exception is some other erros occurs
	 **/
	private static function validateDateTime($newDateTime) : \DateTime {
		//if date is a DateTime object return that object
		if(is_object($newDateTime) === true && get_class($newDateTime) === "DateTime") {
			return ($newDateTime);
		}
		try{
			list($date, $time) = explode(" ", $newDateTime);
			$date = self::validateDate($date);
			$time = self::validateTime($time);
			list($hour, $minute, $second) = explode(":", $time);
			list($second, $microseconds) = explode(".", $second);
			$date->setTime($hour, $minute, $second, $microseconds);
			return ($date);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * filter for mySQL times
	 *
	 * validates a time string; meant to be used in a mutator
	 *
	 * @param string $newTime time to validate
	 * @return string validated time as a sting H:i:s[.u]
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 **/
	private static function validateTime(string $newTime) : string {
		// treat the date as a mySQL date string H:i:s[.u]
		$newTime = trim($newTime);
		if((preg_match("/^(\d{2}):(\d{2}):(\d{2})(?(?=\.)\.(\d{1,6}))$/", $newTime, $matches)) !== 1) {
			throw(new \InvalidArgumentException("time is not a vlid time"));
		}
		//verify the date is a real calendar date
		$hour = intval($matches[1]);
		$minute = intval($matches[2]);
		$second = intval($matches[3]);
		//verify that the time is a real clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0 || $second >= 60) {
			throw(new \RangeException("date is not a valid wall clock time"));
		}
		// put a placeholder for microseconds if they dont exist
		$microseconds = $matches[4] ?? "0";
		$newTime = "$hour:$minute:$second.$microseconds";
		//here the date is clean
		return ($newTime);
	}
}