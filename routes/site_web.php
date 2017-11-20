<?php

$app->get('/site_web/coba', function ($request, $responsep) {

    $data = date("d F Y", strtotime("now"));

    echo $data;
});

$app->get('/site_web/session', function ($request, $response) {
    if (isset($_SESSION['user']['m_roles_id'])) {
        return successResponse($response, $_SESSION);
    }
    return unprocessResponse($response, ['undefined']);
})->setName('session');

$app->post('/site_web/login', function ($request, $response) {
    $params = $request->getParams();
    $sql = $this->db;

    $username = isset($params['username']) ? $params['username'] : '';
    $password = isset($params['password']) ? $params['password'] : '';

    $model = $sql->select("web_pengguna.*, web_roles.akses")
            ->from("web_pengguna")
            ->leftJoin("web_roles", "web_roles.id = web_pengguna.roles_id")
            ->where("username", "=", $username)
            ->andWhere("password", "=", sha1($password))
            ->find();

    if (!empty($model)) {
        $_SESSION['user']['id'] = $model->id;
        $_SESSION['user']['username'] = $model->username;
        $_SESSION['user']['nama'] = $model->nama;
        $_SESSION['user']['m_roles_id'] = $model->roles_id;
        $_SESSION['user']['title'] = 'Admin Web BPPTL';
        $_SESSION['user']['akses'] = json_decode($model->akses);
        return successResponse($response, $_SESSION);
    } else {
        return unprocessResponse($response, ['Authentication Systems gagal, username atau password Anda salah.']);
    }
})->setName('session');

$app->post('/site_web/pesertalogin', function ($request, $response) {
    $params = $request->getParams();
    $sql = $this->db;

    $email = isset($params['email']) ? $params['email'] : '';
    $password = isset($params['password']) ? $params['password'] : '';


    $peserta_model = $sql->select("*")
            ->from("m_user")
            ->where("is_deleted", "=", 0)
            ->andWhere("email", "=", $email)
            ->andWhere("password", "=", sha1($password))
            ->find();

    if (!empty($peserta_model)) {
        $_SESSION['user']['is_peserta'] = true;
        $_SESSION['user']['id'] = $peserta_model->id;
        $_SESSION['user']['username'] = $peserta_model->email;
        $_SESSION['user']['nama'] = $peserta_model->nama;
        $_SESSION['user']['foto'] = (file_exists('img/peserta/' . $peserta_model->foto)) ? getenv('SITE_IMG') . 'peserta/' . $peserta_model->foto : 'img/default.png';
        $_SESSION['user']['m_roles_id'] = 0;
        $_SESSION['user']['title'] = ucwords($peserta_model->nama);
        $_SESSION['user']['akses'] = [
            "verivikasi_konfirmasi" => true,
            "verivikasi_daftarulang" => true,
        ];
        return successResponse($response, $_SESSION);
    } else {
        return unprocessResponse($response, ['Authentication Systems gagal, email atau password Anda salah.']);
    }
})->setName('session');

$app->get('/site_web/logout', function () {
    session_destroy();
})->setName('logout');

/** UPLOAD GAMBAR CKEDITOR */
$app->post('/site_web/upload', function ($request, $response) {
    $files = $request->getUploadedFiles();
    $newfile = $files['upload'];

    if (file_exists("file/" . $newfile->getClientFilename())) {
        echo $newfile->getClientFilename() . " already exists please choose another image.";
    } else {

        $path = 'appweb/img/artikel/' . date("m-Y") . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }

        $uploadFileName = urlParsing($newfile->getClientFilename());
        $upload = $newfile->moveTo($path . $uploadFileName);

        $crtImg = createImg($path . '/', $uploadFileName, date("dYh"), true);

        $url = getenv("SITE_URL") . $path . $crtImg['big'];

        // Required: anonymous function reference number as explained above.
        $funcNum = $_GET['CKEditorFuncNum'];
        // Optional: instance name (might be used to load a specific configuration file or anything else).
        $CKEditor = $_GET['CKEditor'];
        // Optional: might be used to provide localized messages.
        $langCode = $_GET['langCode'];

        echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '');</script>";
    }
});

/** END UPLOAD */