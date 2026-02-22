<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $repo): Response
    {
        $articles=$repo->findAll();

        return $this->render('blog/index.html.twig', ['controller_name' => 'BlogController','articles'=>$articles,]);
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    #[Route('/blog/new' , name: 'new_blog')]
    public function new(Request $request, EntityManagerInterface $entityManager):Response
        {
        // 1. Créer une nouvelle instance d'Article
        $article = new Article();
        // 2. Créer le formulaire avec l'entité vide
        $form = $this->createForm(ArticleType::class, $article);
        // 3. Lier les données POST au formulaire
        $form->handleRequest($request);
        // 4. Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // 5. Définir la date de création
            $article->setCreatedAt(new \DateTimeImmutable());
            // 6. Persister l'entité en BDD
            $entityManager->persist($article);
            $entityManager->flush();
            // 7. Message flash de succès
            $this->addFlash('success', 'Article créé avec succès !');
            // 8. Rediriger vers la page de l'article
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        // 9. Afficher le formulaire (GET ou erreurs de validation)
        return $this->render('blog/new.html.twig', ['form' => $form->createView(),]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(Article $article): Response
    {
        return $this->render('blog/show.html.twig', ['article' => $article]);
    }  

    #[Route('blog/delete/{id}', name: 'blog_delete')]
    public function delete(Request $request,Article $article, EntityManagerInterface $entityManager ): Response
    {
        // 1. Vérifier le token CSRF (sécurité)
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            // 2. Supprimer l'entité

            $entityManager->remove($article);
            $entityManager->flush();
            // 3. Message flash de succès
            $this->addFlash('success', 'Article supprimé avec succès !');
        }
        // 4. Rediriger vers la liste des articles
        return $this->redirectToRoute('app_blog');
    }

    #[Route('blog/{id}/edit', name: 'blog_edit')]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Article mis à jour avec succès !');
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        return $this->render('blog/edit.html.twig', ['form' => $form->createView()]);
    }
}
