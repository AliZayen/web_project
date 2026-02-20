<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    #[Route('/blog/12', name: 'anonymous_show')]
    public function show()
    {
        return $this->render('blog/show.html.twig');
    }

    #[Route('/blog/{id}',name: 'blog_show')]
    public function blog_show(int $id):Response{
        return $this->render('blog/show.html.twig', parameters: ['id' => $id]);
    }
}
