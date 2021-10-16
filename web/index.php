<?php

$currentURL = define('CURRENT_URL', (!empty($_SERVER['SERVER_PORT'])?$_SERVER['SERVER_PORT']==443?'https':'http':FALSE)."://".(!empty($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:FALSE).str_replace('//', '/', $_SERVER['REQUEST_URI']));

$BaseURL = 'https://medandenai.pemkomedan.go.id/web/';


$FakeURL = 'pemkomedan.my.id/web/index.php/';
// $FakeURL = 'localhost/medandenai.pemkomedan.my.id/web/index.php/';

$on_fake = explode('/', CURRENT_URL);

if (isset($on_fake[5]) && count($on_fake) > 5)
{
	$new_array = array_splice($on_fake, 5, 5); // on hosting
	// $new_array = array_splice($on_fake, 6, 6); // on local
	$BaseURL = $BaseURL.implode('/', $new_array);
}

$HTML = file_get_contents($BaseURL);

$HTML = str_replace('src="/web/', 'src="'.$BaseURL, $HTML);

preg_match_all('/medandenai\.pemkomedan\.go\.id.*/', $HTML, $matches);

$list = array();

foreach ($matches[0] as $key => $link)
{
	if (!in_array(explode('/', $link)[2], ['assets', 'uploads', 'uploads_gallery']))
	{
		if (!in_array(explode('/', $link)[2], $list))
		{
			array_push($list, array(
				'key' => $key,
				'full' => $link,
				'found' => explode('/', $link)[2]
			));

			$HTML = str_replace($link, str_replace('medandenai.pemkomedan.go.id/web/', $FakeURL, $link), $HTML);
		}
	}
}

$lurah_medan_tenggara = 'Alamat Kantor Lurah : Jl. Medan Tenggara Gg. Rahmat I Medan';

$HTML = str_replace($lurah_medan_tenggara, $lurah_medan_tenggara.'<br> Website : <a href="https://kelurahan-medan-tenggara.pemkomedan.my.id">Website Kelurahan Medan Tenggara</a>', $HTML);

echo $HTML;