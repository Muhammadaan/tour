<?php

/**
 * Validasi
 * @param  array $data
 * @param  array $custom
 * @return array
 */
function validasi($data, $custom = array()) {
    $validasi = array(
        'deskripsi' => 'required',
        'nama' => 'required',
        'gambar' => 'required',
    );


    $cek = validate($data, $validasi, $custom);
    return $cek;
}

/**
 * get Gudang list
 */
$app->get('/appweb_slider/index', function ($request, $response) {
    $params = $request->getParams();

    $sort = "id DESC";
    $offset = isset($params['offset']) ? $params['offset'] : 0;
    $limit = isset($params['limit']) ? $params['limit'] : 10;

    $db = new Cahkampung\Landadb(Db());

    /** Select Gudang from database */
    $db->select("web_slider.*,web_pengguna.nama as dibuat")
            ->from("web_slider")
            ->join("left join", "web_pengguna", "web_pengguna.id = web_slider.created_by");
    /** Add filter */
    if (isset($params['filter'])) {
        $filter = (array) json_decode($params['filter']);
        foreach ($filter as $key => $val) {
            $db->where($key, 'LIKE', $val);
        }
    }

    /** Set limit */
    if (!empty($limit)) {
        $db->limit($limit);
    }

    /** Set offset */
    if (!empty($offset)) {
        $db->offset($offset);
    }

    /** Set sorting */
    if (!empty($params['sort'])) {
        $db->sort($sort);
    }

    $models = $db->findAll();
    $totalItem = $db->count();

    return successResponse($response, ['list' => $models, 'totalItems' => $totalItem]);
})->add($_auth);

/**
 * create 
 */
$app->post('/appweb_slider/create', function ($request, $response) {
    $data = $request->getParams();
    $db = new Cahkampung\Landadb(Db());
    $validasi = validasi($data);

    if ($validasi === true) {
        try {
            if (isset($data['gambar']['base64'])) {
                $f = explode(".", $data['gambar']['filename']);
                $filename = urlParsing($f[0]);
                $file = base64ToFile($data['gambar'], "./file/slider/", $filename);
                $data['gambar'] = $file['fileName'];
            }

            $model = $db->insert("web_slider", $data);
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['Data Gagal Di Simpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);


/**
 * update cabang
 */
$app->post('/appweb_slider/update', function ($request, $response) {
    $data = $request->getParams();
    $db = $this->db;
    $validasi = validasi($data);

    if ($validasi === true) {
        try {
            if (isset($data['gambar']['base64'])) {
                $f = explode(".", $data['gambar']['filename']);
                $filename = urlParsing($f[0]);
                $file = base64ToFile($data['gambar'], "./file/slider/", $filename);
                $data['gambar'] = $file['fileName'];
            }
            $model = $db->update("web_slider", $data, array('id' => $data['id']));
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['Data Gagal Di Simpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);

/**
 * delete user
 */
$app->delete('/appweb_slider/delete/{id}', function ($request, $response) {
    $db = new Cahkampung\Landadb(Db());
    $getData = $db->select("*")->from("web_slider")->where("id", "=", $request->getAttribute('id'))->find();

    try {
        unlink('file/slider/' . $getData->gambar);
        $delete = $db->delete('web_slider', array('id' => $request->getAttribute('id')));
        return successResponse($response, ['Data Berhasil Dihapus']);
    } catch (Exception $e) {
        return unprocessResponse($response, ['Data Gagal Dihapus']);
    }
});

$app->post('/appweb_slider/trash', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;

    try {
        $model = $db->update("web_slider", $data, array('id' => $data['id']));
        return successResponse($response, $model);
    } catch (Exception $e) {
        return unprocessResponse($response, ['Data Gagal Di Simpan']);
    }
})->add($_auth);
