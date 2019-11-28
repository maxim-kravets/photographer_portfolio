<?php
/**
 * @author Maxim Kravets kravets.development@gmail.com.
 * Date: 12/27/18
 * Time: 00:33
 */

namespace App\Service\Helper;


use App\Repository\UserRepository;

abstract class ValidatorAbstract
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

}
