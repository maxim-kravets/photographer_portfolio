<?php

namespace App\Service\Storage;

interface StorageInterface
{
    public function getPhotoUrl(int $photo_id);
}
