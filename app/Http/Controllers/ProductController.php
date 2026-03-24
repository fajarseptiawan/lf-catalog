<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('is_featured', true)->take(6)->get();
        return view('page.home', compact('featuredProducts'));
    }

    public function category($category)
    {
        $iphoneCategories = ['iphone13', 'iphone14', 'iphone15', 'iphone16', 'iphone17'];
        if ($category === 'temperedglass') {
            // Tempered Glass page shows all products flagged as temperedglass from any category
            $products = Product::where('is_temperedglass', true)->get();
        }
        elseif (in_array($category, $iphoneCategories)) {
            $products = Product::whereIn('category', [$category, 'aksesoris', 'charger'])->get();
        }
        else {
            $products = Product::where('category', $category)->get();
        }

        $viewMap = [
            'iphone13' => 'page.pageip13',
            'iphone14' => 'page.pageip14',
            'iphone15' => 'page.pageip15',
            'iphone16' => 'page.pageip16',
            'iphone17' => 'page.pageip17',
            'g2g' => 'page.pageg2g',
            'softlens' => 'page.pagesoftlens',
            'charger' => 'page.pagecharger',
            'temperedglass' => 'page.pagetemperedglass',
        ];

        $view = $viewMap[$category] ?? 'page.category';

        return view($view, compact('products', 'category'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('page.detail', compact('product'));
    }
}
