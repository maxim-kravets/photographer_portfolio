<?php

namespace App\Service\Storage;


use Aws\S3\S3Client;
use App\Repository\UserRepository;
use App\Repository\DocumentRepository;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class S3FileStorage implements StorageInterface
{
    private $userRepository;

    private $documentRepository;

    /**
     * @var S3Client $s3
     */
    private $s3;

    private $bucket;

    public function __construct(
        UserRepository $userRepository,
        DocumentRepository $documentRepository,
        S3StoreConfiguration $s3StoreConfiguration
    ) {
        $this->userRepository = $userRepository;
        $this->documentRepository = $documentRepository;
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

    public function upload(int $user_id, UploadedFile $file)
    {
        $user = $this->userRepository->find($user_id);

        if ($user === null) {
            throw new LogicException(\sprintf('User with ID %d not found', $user_id));
        }

        $name = \md5(\uniqid()).'.'.$file->guessExtension();
        $destination_path = $user->getId().'/'.$name;
        $extension = $file->getClientOriginalExtension();
        $mime_type = $file->getMimeType();
        $path = $file->getPathname();
        $size = $file->getSize();

        $result = $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key' => $destination_path,
            'SourceFile' => $path
        ]);

        $this->documentRepository->create($name, $size, $mime_type, $extension, $user);

        return $result;
    }

    public function remove(int $user_id, int $document_id)
    {
        $user = $this->userRepository->find($user_id);

        if ($user === null) {
            throw new LogicException(\sprintf('User with ID %d not found', $user_id));
        }

        $document = $this->documentRepository->find($document_id);

        if ($document === null) {
            throw new LogicException(\sprintf('Document with ID %d not found', $document_id));
        }

        $document_path = $user->getId().'/'.$document->getName();

        $result = $this->s3->deleteObject([
            'Bucket' => $this->bucket,
            'Key' => $document_path
        ]);

        $this->documentRepository->delete($document);

        return $result;
    }

    public function getDocumentUrl(int $user_id, int $document_id): string
    {
        $user = $this->userRepository->find($user_id);

        if ($user === null) {
            throw new LogicException(\sprintf('User with ID %d not found', $user_id));
        }

        $document = $this->documentRepository->find($document_id);

        if ($document === null) {
            throw new LogicException(\sprintf('Document with ID %d not found', $document_id));
        }

        $cmd = $this->s3->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $user_id.'/'.$document->getName()
        ]);

        $request = $this->s3->createPresignedRequest($cmd, '+20 minutes');

        return (string) $request->getUri();
    }

}
