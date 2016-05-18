<?php
/**
 * A class to play with prime numbers.
 *
 * @author Tamás Szabó <szabto@gmail.com>
 **/
class PrimeMachine {
	/**
	 * This variable will hold the temporaly generated prime numbers.
	 *
	 * @var Array primes
	 **/
	static $primes = [];

	/**
	 * The last number what was checked while generating prime number list
	 *
	 * @var Integer lastRange
	 **/
	static $lastRange = 0;

	/**
	 * Generates and fills the primes variable, with prime numbers
	 *
	 * @return PrimeMachine class
	 * @param Array of the generated range.
	 * @author Tamás Szabó <szabto@gmail.com>
	 **/
	public static function generate( $range ) {
		if( $range[1] < self::$lastRange ) return;
		if( $range[1] < $range[0] ) throw new Exception("Invalid value passed.");

		for( $i=$range[0]; $i<$range[1];$i++) {
			if( self::isPrime($i) )
				self::$primes[] =  $i;
		}
		self::$lastRange = $range[1];
	}

	/**
	 * Check if the entered number is prime, or not.
	 *
	 * @return true if prime, false if not.
	 * @param Integer, the number what has to be checked
	 * @author Tamás Szabó <szabto@gmail.com>
	 **/
	public static function isPrime( $num ) {
		if( $num < 2 || $num % 2 == 0 ) return $num == 2;
		if( $num < self::$lastRange ) return in_array($num, self::$primes);

		for($i=3;$i<=ceil(sqrt($num));$i+=2) {
			if( $num % $i == 0 ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * This function can split a number into prime numbers' multiplication
	 *
	 * @return Array of the prime numbers.
	 * @param Integer - the number what have to be split
	 * @author Tamás Szabó <szabto@gmail.com>
	 **/
	public static function split($num) {
		if( $num+100 > self::$lastRange ) { self::generate([self::$lastRange, $num+100]); }

		$items = [];
		while( $num != 1 ) {
			foreach(self::$primes as $prime) {
				if( $num % $prime == 0 ) {
					$items[] = $prime;
					$num /= $prime;
				}
			}
		}
		return $items;
	}

	/**
	 * Can return the biggest prime number of a number list.
	 *
	 * @return Integer, the biggest prime number
	 * @param Array of numbers
	 * @author Tamás Szabó <szabto@gmail.com>
	 **/
	public static function getLastPrime( $arr ) {
		rsort($arr);
		$max = $arr[0];
		if( $max+100 > self::$lastRange ) { self::generate([self::$lastRange, $max+100]); }

		foreach( $arr as $num ) {
			if( in_array($num, self::$primes) ) {
				return $num;
			}
		}
		return false;
	}

	/**
	 * Returns the next prime number, what bigger than the number entered as argument
	 *
	 * @return Integer - the bigger prime number if possible, when fails, returns null.
	 * @param Integer - number 
	 * @author Tamás Szabó <szabto@gmail.com>
	 **/
	public static function getNextPrime( $num ) {
		if( $num+100 > self::$lastRange ) { self::generate([self::$lastRange, $num+100]); }

		foreach( self::$primes as $prime ) {
			if( $prime > $num ) {
				return $prime;
			}
		}
		return null;
	}
}
?>