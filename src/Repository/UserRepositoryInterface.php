<?php
/**
 * @author Maxim Kravets kravets.development@gmail.com.
 * Date: 12/27/18
 * Time: 00:17
 */

namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $entity): void;
}
