<?php
return [
    'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'page#getSitemaps', 'url' => '/sitemaps', 'verb' => 'GET'],
		['name' => 'page#getSitemap', 'url' => '/sitemaps/{id}', 'verb' => 'GET'],
		['name' => 'page#getItem', 'url' => '/items/{item}', 'verb' => 'GET'],
		['name' => 'page#getItemPersistence', 'url' => '/persistence/{item}', 'verb' => 'GET'],

		['name' => 'settings#index', 'url' => '/settings', 'verb' => 'GET'],
		['name' => 'settings#update', 'url' => '/settings', 'verb' => 'PUT'],
    ]
];
