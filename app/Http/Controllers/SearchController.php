<?php

namespace App\Http\Controllers;

use App\Models\Pen;
use App\Models\User;
use Illuminate\Http\Request;
use MeiliSearch\Endpoints\Indexes;

class SearchController extends Controller
{
    /**
     * Get the Pen and User search results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    public function index(Request $request)
    {
        $results = [
            'allPens' => $this->getAllPens($request),
            'users' => $this->getUsers($request),
        ];

        if ($request->user()) {
            $results['ownedPens'] = $this->getOwnedPens($request);
        }

        return $results;
    }

    protected function getAllPens(Request $request)
    {
        return
            collect(
                Pen::search($request->search, function (Indexes $meilisearch, $query, $options) use ($request) {
                    $options['filters'] = 'visibility="public" AND NOT user_id=' . optional($request->user())->id;
                    $options['attributesToHighlight'] = ['title', 'description'];

                    return $meilisearch->search($query, $options);
                })->take(3)->raw()['hits'],
            )->map(fn ($pen) => ['slug' => $pen['slug'], 'description' => $pen['_formatted']['description'], 'title' => $pen['_formatted']['title']]);
    }

    protected function getOwnedPens(Request $request)
    {
        return
            collect(
                Pen::search($request->search, function (Indexes $meilisearch, $query, $options) use ($request) {
                    $options['filters'] = 'user_id=' . $request->user()->id;
                    $options['attributesToHighlight'] = ['title', 'description'];

                    return $meilisearch->search($query, $options);
                })->take(3)->raw()['hits']
            )->map(fn ($pen) => ['slug' => $pen['slug'], 'description' => $pen['_formatted']['description'], 'title' => $pen['_formatted']['title']]);
    }

    protected function getUsers(Request $request)
    {
        return
            collect(
                User::search($request->search, function (Indexes $meilisearch, $query, $options) {
                    $options['attributesToHighlight'] = ['name', 'username'];

                    return $meilisearch->search($query, $options);
                })->take(3)->raw()['hits'],
            )->map(fn ($user) => ['slug' => $user['username'], 'name' => $user['_formatted']['name'], 'username' => $user['_formatted']['username']]);
    }
}
