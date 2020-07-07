<?php


namespace App\Service;


class WebScrappingService
{
public function letScrapp($url){
   $client = \Symfony\Component\Panther\Client::createChromeClient();
   $crawler = $client->request('GET', $url);
   $fullPageHtml = $crawler->html();
   return $crawler->html();

}
}
