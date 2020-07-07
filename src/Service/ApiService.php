<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
//Service permettant d'effecuer des requêtes HTTP sur News API
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    // Récupération des articles à la une
    public function fetchTopHeadLines(): array
    {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/top-headlines?country=fr&apiKey=9fdc57cc3d02416ca81941ec16c6e5bb'
        );
        $content = $response->toArray();
        $articles = array();
        // Seuls les articles sont récupérés dans le JSON pour rendre le tableau plus facilement manipulable
        foreach ($content['articles'] as $article) {
            $articles[] = $article;
        }
        return $articles;
    }

    // Récupération des sources francophones
    public function fetchSources(): array
    {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/sources?country=fr&apiKey=9fdc57cc3d02416ca81941ec16c6e5bb');
        $content = $response->toArray();
        $sources = array();
        //On écrème le tableau pour le rendre plus facilement manipulable
        foreach ($content['sources'] as $source) {
            $sources[] = $source;
        }
        return $sources;
    }

    //Récupération des articles d'une source donnée en paramètres
    public function fetchArticleSources($source): array
    {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/everything?sources=' . $source . '&language=fr&apiKey=9fdc57cc3d02416ca81941ec16c6e5bb'
        );
        $content = $response->toArray();
        $articles = array();
        // Seuls les articles sont récupérés dans le JSON pour rendre le tableau plus facilement manipulable
        foreach ($content['articles'] as $article) {
            $articles[] = $article;
        }
        return $articles;
    }

    //Récupération d'un article via le titre donné en paramètre
    public function fetchArticleTitle($titre): array
    {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/everything?qInTitle="' . $titre . '"&apiKey=9fdc57cc3d02416ca81941ec16c6e5bb'
        );
        $content = $response->toArray();
        $article = array();
        //Ecrémage de l'Array, répétition de code sur tout le service, besoin de réfléchir à une solution pour
        // factoriser tout ça
        foreach ($content['articles'] as $art) {
            $article[] = $art;
        }
        return $article[0];
    }
}
