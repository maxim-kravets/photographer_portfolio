<?php
/**
 * @author Maxim Kravets kravets.development@gmail.com.
 * Date: 12/26/18
 * Time: 23:57
 */

namespace App\Service\Helper;


use Throwable;

class ValidatorException extends \RuntimeException
{
    public function __construct(string $message, int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
