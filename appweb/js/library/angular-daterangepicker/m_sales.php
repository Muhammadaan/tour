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
            'kode'                 => 'required',
            'nama'                 => 'required',
            'email'                => 'valid_email',
            'no_tlp'               => 'numeric',
            
        );

   
        GUMP::set_field_name("no_tlp", "No Telepon");
        $cek = validate($data, $validasi, $custom);
        return $cek;
}


$app->get('/m_sales/kode', function ($request, $response) {
    $params = $request->getParams();
    $db = $this->db;
    /** Select Gudang from database */
   $get = $db->select("kode")
        ->from("m_sales")
        ->orderBy('kode DESC')
        ->limit(1)
        ->find();

    

    if ($get) {
        $kode_cust = (substr($get->kode, -3) + 1);
        $kodeCust = substr('000' . $kode_cust, strlen($kode_cust));
        $kodeCust = "SL" . $kodeCust;
    } else {
        $kodeCust = "SL001";
    }
    

    return successResponse($response, ['kode' => $kodeCust]);

});


/**
 * get Gudang list
 */
$app->get('/m_sales/index', function ($request, $response) {
    $params = $request->getParams();

    $sort   = "id DESC";
    $offset = isset($params['offset']) ? $params['offset'] : 0;
    $limit  = isset($params['limit']) ? $params['limit'] : 10;

    $db = $this->db;

    /** Select Gudang from database */
    $db->select("*")
        ->from("m_sales");
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

    $models    = $db->findAll();
    $totalItem = $db->count();

 
    return successResponse($response, ['list' => $models, 'totalItems' => $totalItem]);
});

/**
 * create 
 */
$app->post('/m_sales/create', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;

    $validasi = validasi($data);

    if ($validasi === true) {
        try {
           
            $model = $db->insert("m_sales", $data);
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['Data Gagal Di Simpan']);
        }
    }
    return unprocessResponse($response, $validasi);
});


/**
 * update cabang
 */
$app->post('/m_sales/update', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;

  

    $validasi = validasi($data);

    if ($validasi === true) {
        try {
            $model = $db->update("m_sales", $data, array('id' => $data['id']));
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['Data Gagal Di Simpan']);
        }
    }
    return unprocessResponse($response, $validasi);
});

/**
 * delete user
 */
$app->delete('/m_sales/delete/{id}', function ($request, $response) {
    $db = $this->db;

    try {
        $delete = $db->delete('m_sales', array('id' => $request->getAttribute('id')));
        return successResponse($response, ['Data Berhasil Dihapus']);
    } catch (Exception $e) {
        return unprocessResponse($response, ['Data Gagal Dihapus']);
    }
});

$app->post('/m_sales/trash', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;

        try {
            $model = $db->update("m_sales", $data, array('id' => $data['id']));
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['Data Gagal Di Simpan']);
        }

    
});
