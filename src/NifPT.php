<?php 

namespace Valium;

/**
 * Validates an array of NIF numbers for the Portuguese market.
 *
 * @since  1.0.0
 * @author  WP Helpers | Carlos Matos
 */
class NifPT
{
	protected $allowedInit = [1, 2, 3, 5, 6, 8, 9];
	
	public function check(array $codes, string $type, bool $getType = false)
	{
		$results = [];

		switch ($type) {
			case 'nif':
				foreach ($codes as $code) {
					$bool = $this->validate($code);
					if($getType === true && $bool === true) {
						$results[$code] = $this->nifTypes($code);
					} else {
						$results[$code] = $bool;
					}
				}
				break;

			case 'nipc':
				foreach ($codes as $code) {
					$bool = $this->validate($code);
					$results[$code] = $bool;
				}
				break;
			
			default:
				# code...
				break;
		}

		return $results;
	}

	public function validate(mixed $contribuinte)
	{
		if(is_string($contribuinte)) {
			$contribuinte = (int) $contribuinte;
		}

		$contribuinte = trim($contribuinte);

		if(!is_numeric($contribuinte) || strlen($contribuinte) != 9) {
			return false;
		}

		$contribuinteDigits = str_split($contribuinte);

		if(!in_array($contribuinteDigits[0], $this->allowedInit)) {
			return false;
		}

		$module = $i = 0;

		while ($i < 8) {
			
			$module = $module + $contribuinteDigits[$i] * (10 - $i - 1);
			$i++;
		}

		$module = 11 - ($module % 11);

		if($module >= 10) {
			$module = 0;
		}

		if($module == $contribuinteDigits[8]) {
			return true;
		} else {
			return false;
		}
	}

	public function nifTypes($contribuinte) {

		if(is_string($contribuinte)) {
			$contribuinte = (int) $contribuinte;
		}

		$contribuinte = trim($contribuinte);

		$contribuinteDigits = str_split($contribuinte);

		if(in_array($contribuinteDigits[0], [1, 2, 3])) {
			return 'Pessoa singular, a gama 3 começou a ser atribuída em junho de 2019.';
		}

		if($contribuinteDigits[0] == 5) {
			return 'Pessoa colectiva obrigada a registo no Registo Nacional de Pessoas Colectivas.';
		}

		if($contribuinteDigits[0] == 6) {
			return 'Organismo da Administração Pública Central, Regional ou Local.';
		}

		if($contribuinteDigits[0] == 8) {
			return '"Empresário em nome individual" (actualmente obsoleto, já não é utilizado nem é válido).';
		}

		if($contribuinteDigits[0] == 4 && $contribuinteDigits[1] == 5) {
			return 'Pessoa singular. Os algarismos iniciais "45" correspondem aos cidadãos não residentes que apenas obtenham em território português rendimentos sujeitos a retenção na fonte a título definitivo.';
		}

		if($contribuinteDigits[0] == 7) {
			switch ($contribuinteDigits[1]) {
				case 0:
					return 'Herança Indivisa, em que o autor da sucessão não era empresário individual, ou Herança Indivisa em que o cônjuge sobrevivo tem rendimentos comerciais.';
					break;

				case 1:
					return 'Não residentes colectivos sujeitos a retenção na fonte a título definitivo.';
					break;

				case 2:
					return 'Fundos de investimento.';
					break;

				case 4:
					return 'Herança Indivisa, em que o autor da sucessão não era empresário individual, ou Herança Indivisa em que o cônjuge sobrevivo tem rendimentos comerciais.';
					break;

				case 5:
					return 'Herança Indivisa, em que o autor da sucessão não era empresário individual, ou Herança Indivisa em que o cônjuge sobrevivo tem rendimentos comerciais.';
					break;

				case 7:
					return 'Atribuição Oficiosa de NIF de sujeito passivo (entidades que não requerem NIF junto do RNPC).';
					break;

				case 8:
					return 'Atribuição oficiosa a não residentes abrangidos pelo processo VAT REFUND.';
					break;

				case 9:
					return 'Regime excepcional - Expo 98.';
					break;
				
				default:
					# code...
					break;
			}
		}

		if($contribuinteDigits[0] == 9) {
			switch ($contribuinteDigits[1]) {
				case 0:
					return 'Condomínios, Sociedade Irregulares, Heranças Indivisas cujo autor da sucessão era empresário individual.';
					break;
				
				case 1:
					return 'Condomínios, Sociedade Irregulares, Heranças Indivisas cujo autor da sucessão era empresário individual.';
					break;

				case 8:
					return 'Não residentes sem estabelecimento estável.';
					break;

				case 9:
					return 'Sociedades civis sem personalidade jurídica.';
					break;

				default:
					# code...
					break;
			}
		}

	}
}