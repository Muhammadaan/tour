<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validasi($data, $custom = array()) {
    $validasi = array(
        'nama_website' => 'required',
        'email' => 'required',
        'no_telpon' => 'required',
        'alamat' => 'required',
    );

    $cek = validate($data, $validasi, $custom);
    return $cek;
}

$app->get('/appweb_setting/view', function ($request, $response) {
    $db = new Cahkampung\Landadb(Db());

    $data = $db->select("*")->from("web_setting")
            ->where("id", "=", 1)
            ->find();
    $data->password = '';

    return successResponse($response, $data);
})->add($_auth);

$app->post('/appweb_setting/update', function ($request, $response) {
    $data = $request->getParams();

    $db = $this->db;
    $validasi = validasi($data);
    if ($validasi === true) {
        try {
            $model = $db->update("web_setting", $data, array('id' => $data['id']));
            return successResponse($response, $model);
        } catch (Exception $e) {
            return unprocessResponse($response, ['data gagal disimpan']);
        }
    }
    return unprocessResponse($response, $validasi);
})->add($_auth);
