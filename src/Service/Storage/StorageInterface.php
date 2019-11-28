<?php

namespace App\Service\Storage;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface StorageInterface
{
    public function upload(int $user_id, UploadedFile $file);

    public function remove(int $user_id, int $document_id);

    public function getDocumentUrl(int $user_id, int $document_id);
}
