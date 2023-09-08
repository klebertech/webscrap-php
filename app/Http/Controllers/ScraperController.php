<?php

namespace App\Http\Controllers;

use Goutte\Client;

class ScraperController extends Controller
{
  public function meli($category, $searchWord)
    {
      $client = new Client();

      $website = $client
        ->request(
          'GET',
          "https://lista.mercadolivre.com.br/{$category}-{$searchWord}"
        );

      $data = $website
        ->filter('.ui-search-layout__item')
        ->each(
          function ($node) {
            $photo = $node->filter('.ui-search-result-image__element')->attr('data-src');
            $description = $node->filter('.ui-search-item__title')->text();
            $getPrice = $node->filter('.andes-money-amount__fraction')->text();
            $price = str_replace('.', ',', $getPrice);
            $link = $node->filter('a.ui-search-link')->attr('href');
            $website = 'MercadoLivre';
            return compact(
              'photo',
              'description',
              'price',
              'link',
              'website'
            );
      });

      return $data;
    }

    public function buscape($category, $searchWord) {

      $client = new Client();

      $website = $client
        ->request(
          'GET',
          "https://www.buscape.com.br/{$category}/{$searchWord}"
        );
      $data = $website
        ->filter('[data-testid="product-card"]')
        ->each(
          function ($node) {

            $description = $node->filter('[data-testid="product-card::name"]')->text();
            $getPrice = $node->filter('[data-testid="product-card::price"]')->text();
            $price = substr($getPrice, 3);

            $photo = $node->filter('[data-testid="product-card::image"]')
                ->children()->first()->children()->first()->attr('src');

            if(str_starts_with($photo, 'data')){
              $photo = $node->filter('[data-testid="product-card::image"]')
                ->children()->first()->filter('noscript')->html();

              $getLink = explode(' ', $photo);
              $link = array_filter($getLink, function($value) {
                return str_starts_with($value, 'src');
              });
              $photo = reset($link);
              $photo = substr($photo, 5);
              $photo = substr($photo, 0, -1);
            }

            $link = $node->filter('[data-testid="product-card::card"]')->attr('href');
            if(str_starts_with($link, '/')){
              $link = "https://www.buscape.com.br{$link}";
            }

            $website = 'Buscape';
            return compact(
              'photo',
              'description',
              'price',
              'link',
              'website'
            );
          }
        );
      return $data;
    }
}
