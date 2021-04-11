<?php 

namespace Valium\PT;

/**
 * Validates an array of NISS numbers for the Portuguese market.
 *
 * @since  1.0.0
 * @author  WP Helpers | Carlos Matos
 */
class Niss
{
	protected $allowed = [29, 23, 19, 17, 13, 11, 7, 5, 3, 2];

	public function check(array $codes)
	{
		$results = [];

		foreach($codes as $code) {
			$results[$code] = $this->validate($code);
		}

		return $results;
	}

	public function validate(mixed $niss)
	{
		if(is_string($niss)) {
			$niss = (int) $niss;
		}

		$niss = trim($niss);

		if(!is_numeric($niss) || strlen($niss) != 11) {
			return false;
		}

		$nissDigits = str_split($niss);

		if(!($nissDigits[0] == 1 && $nissDigits[1] == 2)) {
			return false;
		}

		$sum = 0;

		for ($i = 0; $i < count($this->allowed); $i++) {

			$sum += $nissDigits[$i] * $this->allowed[$i];
		}

		if($nissDigits[count($nissDigits) - 1] == (9 - ($sum % 10))) {
			return true;
		} else {
			return false;
		}
	}
}