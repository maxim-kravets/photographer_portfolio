<?php
/**
 * @author Maxim Kravets kravets.development@gmail.com.
 * Date: 12/26/18
 * Time: 23:22
 */

namespace App\Service\Helper;


use App\Dto\User;

interface ValidatorInterface
{
    public function validate(User $dto);
}
