<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        SitemapGenerator::create('https://www.instagram-panel.ir')
            ->getSitemap()
            ->add(Url::create('/Feed'))
            ->add(Url::create('/Customer-SellerMajor-Search/all'))
            ->writeToFile(public_path('Mapping/sitemap.xml'));
        echo 'site map created :)';
    }
}
