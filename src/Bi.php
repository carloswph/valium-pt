<?php 

namespace Valium\PT;

/**
 * Validates an array of BI numbers for the Portuguese market.
 *
 * @since  1.1.0
 * @author  WP Helpers | Carlos Matos
 */
class Bi
{
	public function check(array $codes)
	{
		$results = [];

		foreach($codes as $code) {
			$results[$code] = $this->validate($code);
		}

		return $results;
	}
	
	public function validate(mixed $bi)
	{
		$control = substr($bi, -1);
		$bi = substr($bi, 0, -1);

		if(is_integer($bi)) {
			$bi = (string) $bi;
		}

		if(strlen($bi) < 5 || strlen($bi) > 8) {
			return false;
		}

		if(strlen($bi) == 6) {
			$bi = '00' . $bi;
		}

		if(strlen($bi) == 7) {
			$bi = '0' . $bi;
		}

		$digits = str_split($bi);
		$sum = [];

		$i = 0;
		$j = 9;

		for ($i = 0; $i < count($digits); $i++) { 
			$sum[$i] = $digits[$i] * $j;
			$j--;
		}

		$total = array_sum($sum);
		$module = $total % 11;

		if(in_array($module, [0, 1, '0', '1'])) {
			$module = 0;
		} else {
			$module = 11 - $module;
		}

		if($module == $control) {
			return true;
		} else {
			return false;
		}
	}
}