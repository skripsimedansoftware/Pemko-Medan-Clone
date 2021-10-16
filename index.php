<?php

$currentURL = define('CURRENT_URL', (!empty($_SERVER['SERVER_PORT'])?$_SERVER['SERVER_PORT']==443?'https':'http':FALSE)."://".(!empty($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:FALSE).str_replace('//', '/', $_SERVER['REQUEST_URI']));

$BaseURL = 'https://medandenai.pemkomedan.go.id/web/';
$FakeURL = 'https://pemkomedan.my.id/web/';

$HTML = file_get_contents($BaseURL);

$HTML = str_replace('src="/web/', 'src="'.$BaseURL, $HTML);

preg_match_all('/medandenai\.pemkomedan\.go\.id.*/', $HTML, $matches);

$list = array();

foreach ($matches[0] as $key => $link)
{
	if (!in_array(explode('/', $link)[2], $list))
	{
		array_push($list, array(
			'key' => $key,
			'full' => $link,
			'fndd' => explode('/', $link)[2]
		));
	}
}

// echo "<pre>";
// print_r ($list);
// echo "</pre>";


echo "<pre>";
print_r (explode('/', CURRENT_URL));
echo "</pre>";

// echo $HTML;