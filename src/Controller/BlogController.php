<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\PhotoRepository;
use App\Service\Storage\S3FileStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @var S3FileStorage $s3FileStorage
     */
    private $s3FileStorage;

    /**
     * @var PhotoRepository $photoRepository
     */
    private $photoRepository;

    /**
     * @var ArticleRepository $articleRepository
     */
    private $articleRepository;

    public function __construct(
        S3FileStorage $s3FileStorage,
        PhotoRepository $photoRepository,
        ArticleRepository $articleRepository
    ) {
        $this->s3FileStorage = $s3FileStorage;
        $this->photoRepository = $photoRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $photos = $this->photoRepository->getList(1, 7);
        $articles = $this->articleRepository->getList(1, 3);

        return $this->render('blog/index.html.twig', [
            'photos' => $photos,
            'articles' => $articles
        ]);
    }
}
