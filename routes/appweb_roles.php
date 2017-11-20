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
        'nama' => 'required',
    );

    $cek = validate($data, $validasi, $custom);
    return $cek;
}

/**
 * Get list user roles
 */
$app->get('/appweb_roles/index', function ($request, $response) {
    $params = $request->getParams();

    $sort   = "id DESC";
    $offset = isset($params['offset']) ? $params['offset'] : 0;
    $limit  = isset($params['limit']) ? $params['limit'] : 10;

    $db = $this->db;

    /** Select roles from database */
    $db->select("*")
        ->from("web_roles");

    /** Add filter */
    if (isset($params['filter'])) {
        $filter = (array) json_decode($params['filter']);
        foreach ($filter as $key => $val) {
            $db->where($key, 'LIKE', $val);
        }
    }

    /** Set limit */
    if (isset($params['limit']) && !empty($params['limit'])) {
        $db->limit($limit);
    }

    /** Set offset */
    if (isset($params['offset']) && !empty($params['offset'])) {
        $db->offset($offset);
    }

    /** Set sorting */
    if (isset($params['sort']) && !empty($params['sort'])) {
        $db->sort($sort);
    }

    $models    = $db->findAll();
    $totalItem = $db->count();

    foreach ($models as $val) {
        $val->akses = json_decode($val->akses);
    }

    return successResponse($response, ['list' => $models, 'totalItems' => $totalItem]);
})->add($_auth);

/**
 * Save roles
 */
$app->post('/appweb_roles/save', function ($request, $response) {
    $data = $request->getParams();
    $db   = $this->db;

    $validasi = validasi($data);
    if ($validasi === true) {
        try {
            $data['akses'] = json_encode($data['akses']);
            if (isset($data['id'])) {
                $model = $db->update('web_roles', $data, ['id' => $data['id']]);
            } else {
                $model = $db->insert('web_roles', $data);
            }
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['data gagal disimpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);

/**
 * Delete roles
 */
$app->delete('/appweb_roles/delete/{id}', function ($request, $response) {
    $db = $this->db;
    try {
        $delete = $db->delete('web_roles', array('id' => $request->getAttribute('id')));
        return successResponse($response, ['data berhasil dihapus']);
    } catch (Exception $e) {
        return unprocessResponse($response, ['data gagal dihapus']);
    }
})->add($_auth);
