<?php


namespace App\Controller;


use App\Service\ApiService;
use App\Service\WebScrappingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Controller du template d'accueil de l'application
     * @Route("/", name="home")
     * @param ApiService $apiService
     * @return Response
     */
    public function home(ApiService $apiService)
    {
        $lstArt = $apiService->fetchTopHeadLines();
        return $this->render("home/home.html.twig", ['articles' => $lstArt]);
    }

    /**
     * Controller du template d'affichage des sources
     * @Route("/sources", name="sources")
     * @param ApiService $apiService
     * @return Response
     */
    public function sources(ApiService $apiService)
    {
        $lstSources = $apiService->fetchSources();
        return $this->render("sources/sources.html.twig", ['sources' => $lstSources]);
    }

    /**
     * Controller du template d'affichage des articles pour une source donnée
     * @param ApiService $apiService
     * @param $id
     * @Route("/sources/{id}", name="articles_source")
     * @return Response
     */
    public function articlesSource(ApiService $apiService, $id)
    {
        $lstArt = $apiService->fetchArticleSources($id);
        return $this->render("sources/source_articles.html.twig", ['articles' => $lstArt]);
    }

    /**
     * Controller du template d'affichage d'un article d'une source donnée
     * @Route("/article/{titre}", name="article", requirements={"titre"=".+"})
     * @param ApiService $apiService
     * @param WebScrappingService $scrappingService
     * @param $titre
     * @return Response
     */
    public function detailArticlesSources(ApiService $apiService, WebScrappingService $scrappingService, $titre)
    {
        $article = $apiService->fetchArticleTitle($titre);
        return $this->render("sources/article.html.twig",['article' => $article]);
    }
}
