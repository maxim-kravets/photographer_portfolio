<?php
/**
 * @author Maxim Kravets kravets.development@gmail.com.
 * Date: 12/27/18
 * Time: 00:14
 */

namespace App\Repository;


use App\Entity\Photo;

interface PhotoRepositoryInterface
{
    public function getList(int $page = 1, int $limit = 10);
}
