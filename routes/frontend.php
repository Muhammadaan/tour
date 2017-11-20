<?php

/**
 * get list artikel
 */
function validasi_frontend($data, $custom = array()) {
    $validasi = array(
        'nama' => 'required',
        'email' => 'required',
        'no_ktp' => 'required',
        'diklat_id' => 'required',
    );

    $cek = validate($data, $validasi, $custom);
    return $cek;
}

$app->get('/', function ($request, $response) {
 
    return $this->view->render($response, 'views/home.html', [ ]);
});


$app->get('/tours', function ($request, $response) {
 
    return $this->view->render($response, 'views/tours.html', [ ]);
})->setName('tours');

$app->get('/destinations', function ($request, $response) {
 
    return $this->view->render($response, 'views/destinations.html', [ ]);
})->setName('destinations');


$app->get('/blog', function ($request, $response) {
 
    return $this->view->render($response, 'views/blog.html', [ ]);
})->setName('blog');


$app->get('/about', function ($request, $response) {
 
    return $this->view->render($response, 'views/about.html', [ ]);
})->setName('about');


$app->get('/contact', function ($request, $response) {
 
    return $this->view->render($response, 'views/contact.html', [ ]);
})->setName('contact');


