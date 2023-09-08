<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Search;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index()
    {
         return Inertia::render('SearchForm', []);
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'searchWord' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'website' => 'required|string|max:255'
      ]);

      $newSearch = DB::table('searches')
        ->join('products', 'searches.id', '=', 'products.search_id')
        ->where('searches.searchWord', '=', $validated['searchWord'])
        ->where('searches.category', '=', $validated['category'])
        ->where('searches.website', '=', $validated['website'])
        ->get();

      if(!empty($newSearch->toArray())){
        return Inertia::render('SearchForm', [
          'products' => $newSearch,
        ]);
      }

      $search = new Search;
      $search->category = $validated['category'];
      $search->website = $validated['website'];
      $search->searchWord = $validated['searchWord'];
      $search->save();

      $scrap = new ScraperController;

      switch ($validated['website']) {
        case 'MercadoLivre':
          $data = $scrap->meli($validated['category'], $validated['searchWord']);
          break;
        case 'Buscape':
          $data = $scrap->buscape($validated['category'], $validated['searchWord']);
          break;
        default:
          $meli = $scrap->meli($validated['category'], $validated['searchWord']);
          $buscape = $scrap->buscape($validated['category'], $validated['searchWord']);
          $data = array_merge($meli, $buscape);
      }

      foreach($data as $product){
        $search->products()->create([
          'photo' => $product['photo'],
          'description' => $product['description'],
          'category' => $validated['category'],
          'price' => $product['price'],
          'link' => $product['link'],
          'website' => $product['website'],
        ]);
      }

      $getProducts = DB::table('searches')
        ->join('products', 'searches.id', '=', 'products.search_id')
        ->where('searches.searchWord', '=', $validated['searchWord'])
        ->where('searches.category', '=', $validated['category'])
        ->where('searches.website', '=', $validated['website'])
        ->get();
      return Inertia::render('SearchForm', [
        'products' => $getProducts,
      ]);
    }
}
