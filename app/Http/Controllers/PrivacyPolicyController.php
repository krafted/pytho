<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Jetstream\Jetstream;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Normalizer\SlugNormalizer;

class PrivacyPolicyController extends Controller
{
    /**
     * Show the privacy policy for the application.
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
                'html_class' => 'py-heading-permalink',
                'id_prefix' => '',
                'insert' => 'before',
                'title' => '',
                'symbol' => '#',
                'slug_normalizer' => new SlugNormalizer(),
            ],
        ];

        $policyFile = Jetstream::localizedMarkdownPath('privacy.md');

        return inertia('PrivacyPolicy', [
            'policy' => (new CommonMarkConverter($config, $environment))->convertToHtml(file_get_contents($policyFile)),
        ]);
    }
}
