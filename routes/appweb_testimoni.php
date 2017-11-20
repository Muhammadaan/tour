<?php

/**
 * Validasi
 * @param  array $data
 * @param  array $custom
 * @return array
 */
function validasi($data, $custom = array()) {
    $validasi = array(
        'nama' => 'required',
        'email' => 'required',
        'content' => 'required',
    );


    $cek = validate($data, $validasi, $custom);
    return $cek;
}

/**
 * get Gudang list
 */
$app->get('/appweb_testimoni/index', function ($request, $response) {
    $params = $request->getParams();

    $sort = "id DESC";
    $offset = isset($params['offset']) ? $params['offset'] : 0;
    $limit = isset($params['limit']) ? $params['limit'] : 10;

    $db = new Cahkampung\Landadb(Db());

    /** Select Gudang from database */
    $db->select("web_testimoni.*,web_pengguna.nama as dibuat")
            ->from("web_testimoni")
            ->join("left join", "web_pengguna", "web_pengguna.id = web_testimoni.created_by");
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

    foreach ($models as $key => $val) {
        $val->dibuat = ($val->dibuat != null) ? $val->dibuat : $val->nama;
    }

    return successResponse($response, ['list' => $models, 'totalItems' => $totalItem]);
})->add($_auth);

/**
 * create 
 */
$app->post('/appweb_testimoni/create', function ($request, $response) {
    $data = $request->getParams();
    $db = new Cahkampung\Landadb(Db());
    $validasi = validasi($data);

    if ($validasi === true) {
        try {
            $model = $db->insert("web_testimoni", $data);
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
$app->post('/appweb_testimoni/update', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;



    $validasi = validasi($data);

    if ($validasi === true) {
        try {
            $model = $db->update("web_testimoni", $data, array('id' => $data['id']));
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
$app->delete('/appweb_testimoni/delete/{id}', function ($request, $response) {
    $db = $this->db;

    try {
        $delete = $db->delete('web_testimoni', array('id' => $request->getAttribute('id')));
        return successResponse($response, ['Data Berhasil Dihapus']);
    } catch (Exception $e) {
        return unprocessResponse($response, ['Data Gagal Dihapus']);
    }
});

$app->post('/appweb_testimoni/trash', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;

    try {
        $model = $db->update("web_testimoni", $data, array('id' => $data['id']));
        return successResponse($response, $model);
    } catch (Exception $e) {
        return unprocessResponse($response, ['Data Gagal Di Simpan']);
    }
})->add($_auth);
