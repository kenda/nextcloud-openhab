<?php
return [
	'resources' => [
		'sitemap' => ['url' => '/sitemaps'],
		'persistence' => ['url' => '/persistence']
    ],
    'routes' => [
	   ['name' => 'page#index', 'url' => '/', 'verb' => 'GET']
    ]
];
