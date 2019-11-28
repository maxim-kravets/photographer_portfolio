<?php

namespace App\Service\Storage;


use Aws\S3\S3Client;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use Symfony\Component\Console\Exception\LogicException;

class S3FileStorage implements StorageInterface
{
    private $userRepository;

    private $photoRepository;

    /**
     * @var S3Client $s3
     */
    private $s3;

    private $bucket;

    public function __construct(
        UserRepository $userRepository,
        PhotoRepository $photoRepository,
        S3StoreConfiguration $s3StoreConfiguration
    ) {
        $this->userRepository = $userRepository;
        $this->photoRepository = $photoRepository;
        $this->s3 = new S3Client([
            'version' => $s3StoreConfiguration->getVersion(),
            'region'  => $s3StoreConfiguration->getRegion(),
            'credentials' => [
                'key' => $s3StoreConfiguration->getAccessKey(),
                'secret'  => $s3StoreConfiguration->getSecretKey()
            ]
        ]);
        $this->bucket = $s3StoreConfiguration->getBucket();
    }

    public function getPhotoUrl(int $photo_id): string
    {

        $photo = $this->photoRepository->find($photo_id);

        if ($photo === null) {
            throw new LogicException(\sprintf('Photo with ID %d not found', $photo_id));
        }

        $cmd = $this->s3->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => 'photos/'.$photo_id.'.jpg'
        ]);

        $request = $this->s3->createPresignedRequest($cmd, '+20 minutes');

        return (string) $request->getUri();
    }

}
