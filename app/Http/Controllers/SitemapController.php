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
        SitemapGenerator::create('https://www.tanastyle.ir')
            ->getSitemap()
            ->add(Url::create('/Customer-Product-Female-List'))
            ->add(Url::create('/Customer-Product-Male-List'))
            ->add(Url::create('/Customer-Product-Boy-List'))
            ->add(Url::create('/Customer-Product-Girl-List'))
            ->writeToFile(public_path('Mapping/sitemap.xml'));
        echo 'site map created :)';

//        SitemapGenerator::create('https://example.com')
//            ->getSitemap()
//            ->add(Url::create('/Customer-Product-Female-List'))
//            ->add(Url::create('/Customer-Product-Male-List'))
//            ->add(Url::create('/Customer-Product-Boy-List'))
//            ->add(Url::create('/Customer-Product-Girl-List'))
//            ->add(Url::create('/Product'))
//            ->writeToFile(public_path('SiteMap/sitemap.xml'));
//        echo 'site map created :)';
    }
}
