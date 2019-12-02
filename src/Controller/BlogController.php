<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\PhotoRepository;
use App\Service\Storage\S3FileStorage;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    private $paginator;

    public function __construct(
        S3FileStorage $s3FileStorage,
        PhotoRepository $photoRepository,
        ArticleRepository $articleRepository,
        PaginatorInterface $paginator
    ) {
        $this->s3FileStorage = $s3FileStorage;
        $this->photoRepository = $photoRepository;
        $this->articleRepository = $articleRepository;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/blog/{page}", name="blog")
     *
     * @param ArticleRepository $articleRepository
     * @param int $page
     *
     * @return Response
     */
    public function index(ArticleRepository $articleRepository, int $page = 1)
    {
        $queryBuilder = $articleRepository->getQueryBuilder();
        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $page,
            3
        );

        $photos = $this->photoRepository->getList(1, 7);

        return $this->render('blog/index.html.twig', [
            'photos' => $photos,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/blog/article/{id}", name="article")
     *
     * @param int $id
     *
     * @return Response
     */
    public function article(int $id)
    {
        $article = $this->articleRepository->find($id);
        $photos = $this->photoRepository->getList(1, 7);

        return $this->render('blog/article.html.twig', [
            'article' => $article,
            'photos' => $photos
        ]);
    }
}
