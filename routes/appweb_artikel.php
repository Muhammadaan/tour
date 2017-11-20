<?php
/**
 * Validasi
 * @param  array $data
 * @param  array $custom
 * @return array
 */
function validasi($data, $custom = array())
{
    $validasi = array(
        'judul'         => 'required',
        'konten'        => 'required',
        'kategori_id' => 'required',
    );

    $cek = validate($data, $validasi, $custom);
    return $cek;
}

/**
 * get list artikel
 */
$app->get('/appweb_artikel/index', function ($request, $response) {
    $params = $_REQUEST;

    $sort   = "id DESC";
    $offset = isset($params['offset']) ? $params['offset'] : 0;
    $limit  = isset($params['limit']) ? $params['limit'] : 10;

    $db = $this->db;

    $db->select("web_artikel.*, web_kategori.nama as kategori, web_pengguna.nama as creator")
        ->from('web_artikel')
        ->leftJoin('web_kategori', 'web_kategori.id = web_artikel.kategori_id')
        ->leftJoin('web_pengguna', 'web_pengguna.id = web_artikel.created_by');

    /** set parameter */
    if (isset($params['filter'])) {

        $filter = (array) json_decode($params['filter']);

        if (isset($filter['nama'])) {
            /** Get field */
            $sql  = $this->db;
            $list = $sql->get_field('web_artikel');

            foreach ($list as $key => $val) {
                $db->orWhere('web_artikel.' . $val, 'LIKE', $filter['nama']);
            }
        } else if (isset($filter['kategori_id'])) {
            $db->andWhere('web_artikel.kategori_id', '=', $filter['kategori_id']);
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
    $db->orderBy($sort);

    $models    = $db->findAll();
    $totalItem = $db->count();

    return successResponse($response, ['list' => $models, 'totalItems' => $totalItem]);
})->setName('appweb_artikel_index')->add($_auth);

/**
 * get kategori
 */
$app->get('/appweb_artikel/getkategori', function ($request, $response) {
    $db       = $this->db;
    $kategori = $db->findAll('select * from web_kategori order by nama ASC');

    return successResponse($response, $kategori);
});

/**
 * save artikel
 */
$app->post('/appweb_artikel/save', function ($request, $response) {
    $data = $request->getParams();
    $db   = $this->db;

    $data['kategori_id'] = isset($data['kategori_id']) ? $data['kategori_id'] : '';
    $data['judul']         = isset($data['judul']) ? $data['judul'] : '';
    $data['konten']        = isset($data['konten']) ? $data['konten'] : '';

    $validasi = validasi($data);

    if ($validasi === true) {
        $data['alias'] = urlParsing($data['judul']) . ".html";

        if (isset($data['id'])) {
            $model = $db->update("web_artikel", $data, ['id' => $data['id']]);
        } else {
            $data['user_id'] = $_SESSION['user']['id'];
            $data['tanggal'] = strtotime(date("Y-m-d H:i:s"));

            $model = $db->insert("web_artikel", $data);
        }
        return successResponse($response, $model);
    }
    return unprocessResponse($response, $validasi);
})->setName('master_artikel_save')->add($_auth);

/**
 * delete artikel
 */
$app->delete('/appweb_artikel/delete/{id}', function ($request, $response) {
    $db = $this->db;

    try {
        $delete = $db->delete('web_artikel', array('id' => $request->getAttribute('id')));
        return successResponse($response, ['data berhasil dihapus']);
    } catch (Exception $e) {
        return unprocessResponse($response, ['data gagal dihapus']);
    }
})->setName('master_artikel_delete')->add($_auth);
