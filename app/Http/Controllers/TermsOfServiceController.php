<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Jetstream\Jetstream;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Normalizer\SlugNormalizer;

class TermsOfServiceController extends Controller
{
    /**
     * Show the terms of service for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new HeadingPermalinkExtension());

        $config = [
            'heading_permalink' => [
                'html_class' => 'pytho-heading-permalink',
                'id_prefix' => '',
                'insert' => 'before',
                'title' => '',
                'symbol' => '#',
                'slug_normalizer' => new SlugNormalizer(),
            ],
        ];

        $termsFile = Jetstream::localizedMarkdownPath('terms.md');

        return inertia('TermsOfService', [
            'terms' => (new CommonMarkConverter($config, $environment))->convertToHtml(file_get_contents($termsFile)),
        ]);
    }
}
