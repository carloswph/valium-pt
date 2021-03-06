# Valium Portugal

Valium is an initiative that envisions to offer validation classes in PHP for checking public and official numbers and codes for different countries. This particular library focuses in the Portuguese market. This package already manages to validade the following numbers:

* NIF/NIPC
* NISS
* IBAN
* BI

# Usage

Each type of number has its own class, and can be used by instantiating the respective class and using the method check() with the array of numbers/codes to be validated. The method returns an array with the codes as keys and a boolean check as value. For the NIF, the method also admits a second parameter (false as default). If TRUE, the second parameter not only validates the NIF number, but also returns the description of the type of tax payer, instead of a boolean result.

```php
use Valium\PT\Nif;
use Valium\PT\Niss;
use Valium\PT\Iban;
use Valium\PT\Bi;

require __DIR__ . '/vendor/autoload.php';

$nif = new Nif();
// Returns a bool for each number in the array
$q = $nif->check([720014360, '291653170', 980547490, 281234500, 510837620]);
// Returns the type of tax payer for each valid number
$r = $nif->check([292679411, '720014360', 980547490, 281234500, 510837620], true);

var_dump($q);
var_dump($r);

$niss = new Niss();
// Returns a bool for each number in the array
$s = $niss->check([12060903799, 12073833086, 12060904475]);

var_dump($s);

$iban = new Iban();
// Returns a bool for each account in the array
$t = $iban->check(['PT50003300004549519501405', 'PT50001200004549519501405']);

var_dump($t);

$bi = new Bi();
// As an input, an array of the BI numbers together with the control digit (the first number before the two letters, XX, XY, i.e)
$x = $bi->check(['108015750', '34521320']);

var_dump($x);
```
