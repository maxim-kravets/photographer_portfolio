<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Repository\PhotoRepository;
use App\Service\Storage\S3FileStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @var S3FileStorage $s3FileStorage
     */
    private $s3FileStorage;

    /**
     * @var PhotoRepository $photoRepository
     */
    private $photoRepository;

    public function __construct(
        S3FileStorage $s3FileStorage,
        PhotoRepository $photoRepository
    ) {
        $this->s3FileStorage = $s3FileStorage;
        $this->photoRepository = $photoRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $photos = $this->photoRepository->getList(1, 13);

        return $this->render('index/index.html.twig', [
            'photos' => $photos
        ]);
    }
}
