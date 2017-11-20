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
        'nama'       => 'required',
        'username'   => 'required',
        'roles_id' => 'required',
    );

    $cek = validate($data, $validasi, $custom);
    return $cek;
}

/**
 * get user detail for update profile
 */
$app->get('/appweb_user/view', function ($request, $response) {
     $db = new Cahkampung\Landadb(Db());

    $data = $db->select("*")->from("web_pengguna")
            ->where("id", "=", $_SESSION['user']['id'])
            ->find();
    $data->password = '';

    return successResponse($response, $data);
})->add($_auth);

/**
 * get user list
 */
$app->get('/appweb_user/index', function ($request, $response) {
    $params = $request->getParams();

    $sort   = "id DESC";
    $offset = isset($params['offset']) ? $params['offset'] : 0;
    $limit  = isset($params['limit']) ? $params['limit'] : 10;

    $db = $this->db;

    $db->select("web_pengguna.*, web_roles.nama as hakakses")
        ->from('web_pengguna')
        ->join('left join', 'web_roles', 'web_pengguna.roles_id = web_roles.id');

    /** set parameter */
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

    /** set m_roles_id to string */
    foreach ($models as $key => $val) {
        $val->roles_id = (string) $val->roles_id;
    }

    return successResponse($response, ['list' => $models, 'totalItems' => $totalItem]);
})->add($_auth);

/**
 * create user
 */
$app->post('/appweb_user/create', function ($request, $response) {
    $data = $request->getParams();
    $db   = $this->db;

    $validasi = validasi($data, ['password' => 'required']);
    if ($validasi === true) {
        $data['password'] = sha1($data['password']);
        $data['is_deleted'] = 0;
        try {
            $model = $db->insert("web_pengguna", $data);
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['data gagal disimpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);

/**
 * update user profile
 */
$app->post('/appweb_user/updateprofil', function ($request, $response) {
    $data = $request->getParams();
    $id   = $_SESSION['user']['id'];

    $db = $this->db;

    if (!empty($data['password'])) {
        $data['password'] = sha1($data['password']);
    } else {
        unset($data['password']);
    }

    $validasi = validasi($data);
    if ($validasi === true) {
        try {
            $model = $db->update("web_pengguna", $data, array('id' => $id));
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['data gagal disimpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);

/**
 * update user
 */
$app->post('/appweb_user/update', function ($request, $response) {
    $data = $request->getParams();
    $db   = $this->db;

    if (!empty($params['password'])) {
        $data['password'] = sha1($data['password']);
    } else {
        unset($data['password']);
    }

    $validasi = validasi($data);
    if ($validasi === true) {
        try {
            $model = $db->update("web_pengguna", $data, array('id' => $data['id']));
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['data gagal disimpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);

/**
 * delete user
 */
$app->delete('/appweb_user/delete/{id}', function ($request, $response) {
    $db = $this->db;
    try {
        $delete = $db->delete('web_pengguna', array('id' => $request->getAttribute('id')));
        return successResponse($response, ['data berhasil dihapus']);
    } catch (Exception $e) {
        return unprocessResponse($response, ['data gagal dihapus']);
    }
})->add($_auth);
