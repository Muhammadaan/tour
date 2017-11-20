<?php

function validate($data, $validasi, $custom = []) {
    if (!empty($custom)) {
        $validasiData = array_merge($validasi, $custom);
    } else {
        $validasiData = $validasi;
    }

    $validate = GUMP::is_valid($data, $validasiData);

    if ($validate === true) {
        return true;
    } else {
        return $validate;
    }
}

function sendMail($subjek, $nama_penerima, $email_penerima, $template) {

    $body = $template;
    $db = new Cahkampung\Landadb(Db());
    $getEmail = $db->select("*")->from("web_setting")->where("id", "=", 1)->find();
    if (!empty($getEmail->email_smtp) && !empty($getEmail->password_smtp)) {

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;

        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
//        $mail->Username   = getenv('email_smtp');
//        $mail->Password   = getenv('password_smtp');
        $mail->Username = $getEmail->email_smtp;
        $mail->Password = $getEmail->password_smtp;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('erliomedia@gmail.com', 'Erlio Media');
        $mail->addAddress($email_penerima, "$nama_penerima");
        $mail->isHTML(true);

        $mail->Subject = $subjek;
        $mail->Body = $body;

        if (!$mail->send()) {
            return [
                'status' => false,
//                'error'  => $mail->ErrorInfo,
            ];
        } else {
            return [
                'status' => true,
            ];
        }
    } else {
        return [
            'status' => false,
            'error' => 'Email SMTP Belum di setting',
        ];
    }
}

function tanggal_indo($tanggal) {
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}

function tanggal_indo_tgl_bln($tanggal) {
    $bulan = array(1 => 'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agu',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]];
}

function is_url($uri) {
    if (filter_var($uri, FILTER_VALIDATE_URL) === FALSE) {
        return false;
    } else {
        return true;
    }
}

function getImage($base64, $filename, $customename, $path = null) {
    if (isset($base64) and is_url($base64) == false) {
        $file = [
            'base64' => $base64,
            'filename' => $filename
        ];
        if (isset($path)) {
            $path_foto = $path;
        } else {
            $path_foto = './img/peserta';
        }
        $upload = base64ToFile($file, $path_foto, $customename);
        if ($upload['status'] == 1) {
            $return = $upload['fileName'];
        } else {
            $return = "";
        }
    } else {
        $return = "";
    }
    return $return;
}

function getImageDosen($base64, $filename, $customename) {
    if (isset($base64) and is_url($base64) == false) {
        $file = [
            'base64' => $base64,
            'filename' => $filename
        ];
        $upload = base64ToFile($file, 'app/img/dosen', $customename);
        if ($upload['status'] == 1) {
            $return = $upload['fileName'];
        } else {
            $return = "";
        }
    } else {
        $return = "";
    }
    return $return;
}

function random_password($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345678";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}

function pagination($item_count, $limit, $cur_page, $link) {
    if ($limit > 0 && $item_count > 0) {
        $page_count = ceil($item_count / $limit);
        $paginate = '<div class="st-pagination" style="text-align:center"><ul class="pagination">';
        if ($page_count != 1) {
            if ($cur_page == 1) {
                $paginate .= '<li><a>First</a></li>';
            } else {
                $url = $link . addOrUpdateUrlParam('page', 1);
                $paginate .= '<li><a href="' . urldecode($url) . '">First</a></li>';
            }

            if ($cur_page > 1) {
                $url = $link . addOrUpdateUrlParam('page', $cur_page - 1);
                $paginate .= '<li><a href="' . urldecode($url) . '">Prev</a></li>';
            }

            if ($cur_page > 3) {
                $start = $cur_page - 2;
                $end = ($cur_page == $page_count) ? $page_count : (($page_count - $cur_page) + $cur_page);
            } else {
                $start = 1;
                $end = (($cur_page + 4) <= $page_count) ? ($cur_page + 4) : $page_count;
            }

            for ($i = $start; $i <= $end; $i++) {
                if ($i == $cur_page) {
                    $active = 'class="active"';
                } else {
                    $active = '';
                }

                $url = $link . addOrUpdateUrlParam('page', $i);

                $paginate .= '<li ' . $active . '><a href="' . urldecode($url) . '">' . $i . '</a></li>';
            }

            $url = $link . addOrUpdateUrlParam('page', $cur_page + 1);
            if ($cur_page != $page_count) {
                $paginate .= '<li><a href="' . urldecode($url) . '">Next</a></li>';
            }

            if ($cur_page == $page_count) {
                $paginate .= '<li><a>Last</a></li>';
            } else {
                $url = $link . addOrUpdateUrlParam('page', $page_count);
                $paginate .= '<li><a href="' . urldecode($url) . '">Last</a></li>';
            }

            $paginate .= '</ul></div>';
        } else {
            $paginate = '';
        }
        return $paginate;
    }
}

function cuplikan($str, $panjang) {
    return preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', substr(strip_tags($str), 0, $panjang)) . '...';
}

function get_first_image($html, $size = "big") {
    if (empty($class)) {
        $class = 'img img-responsive';
    } else {
        $class = $class;
    }

    $post_html = str_get_html($html);

    $first_img = $post_html->find('img', 0);

    if ($first_img !== null) {

        $first_img->src = $first_img->src;

        if ($size == "small") {
            $first_img->src = str_replace('-700x700-', '-150x150-', $first_img->src);
        }

        if ($size == "medium") {
            $first_img->src = str_replace('-700x700-', '-350x350-', $first_img->src);
        }

        return $first_img->src;
    } else {
        return site_url() . "public/images/systems/no-image.png";
    }
}

function addOrUpdateUrlParam($name, $value) {
    $params = $_GET;
    unset($params[$name]);
    $params[$name] = $value;
    return '?' . http_build_query($params);
}

function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
    if (trim($timestamp) == '') {
        $timestamp = time();
    } elseif (!ctype_digit($timestamp)) {
        $timestamp = strtotime($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace("/S/", "", $date_format);
    $pattern = array(
        '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
        '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
        '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
        '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
        '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
        '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
        '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
        '/November/', '/December/',
    );
    $replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
        'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember',
    );
    $date = date($date_format, $timestamp);
    $date = preg_replace($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    $date = "{$date}";
    return $date;
}
