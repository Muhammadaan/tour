<head>
    <link rel="shortcut icon" href="img/pp.ico">
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>
    <meta content="Landa Systems" name="author"/>

    <link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="./app/js/library/moment/moment.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script src="http://formvalidation.io/vendor/formvalidation/js/formValidation.min.js"></script>
    <script src="http://formvalidation.io/vendor/formvalidation/js/framework/bootstrap.min.js"></script>
    <style>
        .required {
            font-weight: bold;
        }

        .required::after {
            content: ' *';
            color: red;
        }
    </style>
    <!-- End Application CSS !--> 
</head>


<div class="container">
    <div class="row">

        <?php
        if (isset($pesan)) {
            if ($pesan['status'] == "ada") {
                ?>
                <div class="alert alert-<?= $pesan['class'] ?>">
                    <?= $pesan['pesan'] ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="row"> 

        <form id="formRegister" class="form-horizontal" action="SaveRegister.html" method="post"> 
            <div class="panel panel-default panel-floating panel-floating-inline">
                <div class="panel-heading">
                    Register
                </div>
                <div class="panel-body">
                    <div class="col-md-12"> 
                        <div class="col-md-6"> 
                            <!--                            <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-3 control-label">NIP</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"  name="nip" placeholder="NIP">
                                                            </div>
                                                        </div>-->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label required">No KTP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  id="noktp" name="no_ktp" placeholder="No KTP">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label required">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="nama" placeholder="Nama">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tempat Lahir</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="tempat_lahir" placeholder="Tempat Lahir">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Lahir</label>
                                <div class="col-sm-9">
                                    <input type="text" id="date-picker" class="form-control"  name="tanggal_lahir" placeholder="Tanggal Lahir">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label required">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group" id="password">
                                <label for="inputEmail3" class="col-sm-3 control-label required">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group" id="repassword">
                                <label for="inputEmail3" class="col-sm-3 control-label required">Konfirmasi Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="repassword" placeholder="Konfirmasi Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat" rows="2" ></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kode POS</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="kode_pos" placeholder="Kode POS">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Agama</label>
                                <div class="col-sm-9">
                                    <div class="btn-group" data-toggle="buttons"> 
                                        <label class="btn btn-primary">
                                            <input type="radio" name="agama"  autocomplete="off" value="islam" id="islam"> Islam
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="agama"  autocomplete="off"value="kristen" id="kristen"> Kristen
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="agama"  autocomplete="off"value="katolik" id="katolik"> Katolik
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="agama"  autocomplete="off"value="hindu" id="hindu"> Hindu
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="agama"  autocomplete="off"value="budha" id="budha"> Budha
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <div class="btn-group" data-toggle="buttons"> 
                                        <label class="btn btn-primary">
                                            <input type="radio" name="jenis_kelamin" id="Laki-laki" autocomplete="off" value="Laki-laki"> Laki - Laki
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="jenis_kelamin" id="perempuan" autocomplete="off" value="perempuan"> Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-3 control-label required">Jenis Diklat</label>
                                                            <div class="col-sm-9">
                                                                <div class="btn-group" data-toggle="buttons" id="buttonDiklat"> 
                                                                    <label class="btn btn-primary">
                                                                        <input type="radio" name="jenis_diklat"   autocomplete="off" value="umum" > Umum
                                                                    </label>
                                                                    <label class="btn btn-primary">
                                                                        <input type="radio" name="jenis_diklat"   autocomplete="off" value="aparature"> Aparature
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div> -->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label required">Diklat</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="diklat_id" id="diklat"> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">  

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">No HP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="no_hp" placeholder="No Hp">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Seaferer Kode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"    name="seaferer_code" placeholder="Seaferer Kode">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Ibu Kandung</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="ibu_kandung" placeholder="Ibu Kandung">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenjang</label>
                                <div class="col-sm-9"> 
                                    <select class="form-control" name="jenjang"> 
                                        <option value="s3">S3</option>
                                        <option value="s2">S2</option>
                                        <option value="s1">S1</option>
                                        <option value="d4">D4</option>
                                        <option value="d3">D3</option>
                                        <option value="d2">D2</option>
                                        <option value="d1">D1</option>
                                        <option value="smu">SMU</option>
                                        <option value="smk">SMK</option>
                                        <option value="smp">SMP</option>
                                        <option value="sd">SD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Asal Sekolah</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="sekolah" placeholder="Sekolah">
                                </div>
                            </div>
                            <!--                            <div class="form-group">
                                                            <label class="col-sm-3 control-label">Jurusan</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="jurusan" placeholder="Jurusan">
                                                            </div>
                                                        </div> -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tahun Lulus</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tahun_lulus" placeholder="Tahun Lulus">
                                </div>
                            </div> 
                            <div class="form-group" id="foto_user_group">
                                <label  class="col-sm-3 control-label required">Foto</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control"  name="foto_file" id="foto" onchange="getBaseUrl('foto', 'foto_form')" accept="image/*">
                                    <input type="hidden" name="foto_user" id="foto_form" />
                                </div>
                            </div> 
                            <div class="form-group" id="ktp_group">
                                <label  class="col-sm-3 control-label required">KTP</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control"  name="ktp_file" id="ktp" onchange="getBaseUrl('ktp', 'ktp_form')" accept="image/*">
                                    <input type="hidden" name="ktp" id="ktp_form" />
                                </div>
                            </div> 
                            <div class="form-group" id="ijazah_form_group">
                                <label  class="col-sm-3 control-label required">Ijazah Terakhir</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control"  name="ijazah_file" id="ijazah" onchange="getBaseUrl('ijazah', 'ijazah_form')" accept="image/*">
                                    <input type="hidden" name="ijazah" id="ijazah_form" />
                                </div>
                            </div> 
                            <div class="form-group" id="keterangan_sehat_group">
                                <label  class="col-sm-3 control-label required">Keterangan Sehat</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control"  name="keterangan_sehat_file" id="ks" onchange="getBaseUrl('ks', 'ks_form')" accept="image/*">
                                    <input type="hidden" name="keterangan_sehat" id="ks_form" />
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-12" id="termcodinition">
                            <div class="form-group">
                                <label class="col-xs-2 control-label">Ketentuan dan Syarat</label>
                                <div class="col-xs-9">
                                    <div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;" id="isiterm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-5 col-xs-offset-3">
                                    <div class="form-group">
                                        <!--<label>-->
                                        <input type="checkbox" name="agree" value="agree" /> <label class="control-label required">Saya menyetujui ketentuan dan syarat yang berlaku</label>
                                        <!--</label>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success">Daftar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </form>
    </div> 
</div>

<script>
    $('#date-picker').datetimepicker({format: 'DD-MM-YYYY'});
    $("#termcodinition").hide();
    $.ajax({
        type: "GET",
        url: "reqdiklat/umum",
        data: {},
        success: function (result) {
            var makes = result.data;
            var options = '<option value="">Pilih Salah Satu</option>';
            for (var i = 0; i < makes.length; i++) {
                options += '<option value="' + makes[i]['id'] + '">' + makes[i]['title'] + '</option>';
            }
            $("select#diklat").html(options);

        }
    });

    var get_diklat = <?= (isset($_GET['diklat_id'])) ? $_GET['diklat_id'] : '' ?>
    $('select[name="diklat"]').val(get_diklat);
//    console.log("ksks:"+get_diklat);
    //convert gambar

    function getBaseUrl(id, idfile) {
        var file = document.querySelector('input[type=file]#' + id)['files'][0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (readerEvt) {
                var binaryString = readerEvt.target.result;
                document.getElementById(idfile).value = btoa(binaryString);
                console.log(btoa(binaryString));
            };
            reader.readAsBinaryString(file);
        }

    }

//    var tes = function(){
//        fields: {
//            agree: {
//                validators: {
//                    notEmpty: {
//                        message: 'Ketentuan dan Syarat Tidak Boleh Kosong'
//                    }
//                }
//            }
//        }
//        console.log(fields);
//    }
//
//    tes();

    $('#formRegister')
            .formValidation({
                framework: 'bootstrap',
                excluded: 'disabled',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    agree: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Ketentuan dan Syarat Tidak Boleh Kosong'
                            }
                        }
                    },
                    nama: {
                        validators: {
                            notEmpty: {
                                message: 'Nama Tidak Boleh Kosong'
                            }
                        }
                    },
                    no_ktp: {
                        validators: {
                            notEmpty: {
                                message: 'No Ktp Tidak Boleh Kosong'
                            },
                            numeric: {
                                message: 'No KTP harus berisikan angka'
                            }
                        }
                    },
                    password: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Password Tidak Boleh Kosong'
                            },
                            identical: {
                                field: 'repassword',
                                message: 'Password Tidak sama'
                            }
                        }
                    },
                    repassword: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Confirm Password Tidak Sama'
                            },
                            identical: {
                                field: 'password',
                                message: 'Password Tidak sama'
                            }
                        }
                    },
                    diklat_id: {
                        validators: {
                            notEmpty: {
                                message: 'Diklat tidak boleh kosong'
                            }
                        }
                    },
                    foto_file: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Foto tidak boleh kosong'
                            }
                        }
                    },
                    ktp_file: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Foto KTP tidak boleh kosong'
                            }
                        }
                    },
                    ijazah_file: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Foto Ijazah tidak boleh kosong'
                            }
                        }
                    },
                    keterangan_sehat_file: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Foto Surat Keterngan Sehat tidak boleh kosong'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email Tidak Boleh Kosong'
                            },
                            emailAddress: {
                                message: 'Email Tidak Valid'
                            }
                        }
                    }
                }
            });


    $('#diklat').change(function () {
        var id_diklat = $(this).val();
        $.ajax({
            type: "GET",
            url: "cekdiklat/" + id_diklat,
            data: {},
            success: function (result) {
                var data = result.data;
                if (data.is_term == "ya") {
                    $("#termcodinition").show();
                    $("#isiterm").append(data.term_content);
                    $('#formRegister').formValidation('enableFieldValidators', 'agree', true)
                } else {
                    $("#termcodinition").hide();
                    $("#isiterm").append("");
                    $('#formRegister').formValidation('enableFieldValidators', 'agree', true)
                }
            }
        });

    });
//             
    $("#noktp").keyup(function () {
        var value = $(this).val();
        var val = value.length;
        if (val === 11) {
            $.ajax({
                type: "GET",
                url: "cekuser/" + value,
                data: {},
                success: function (result) {
                    var makes = result.data;

                    if (makes.id != undefined) {
                        $("#foto_user_group").hide();
                        $("#ktp_group").hide();
                        $("#ijazah_form_group").hide();
                        $("#keterangan_sehat_group").hide();
                        $("#password").hide();
                        $("#repassword").hide();
                        $('input[name="is_hidden"]').val("ya");
                        var isEmpty = "";
                    } else {
                        $("#foto_user_group").show();
                        $("#ktp_group").show();
                        $("#ijazah_form_group").show();
                        $("#keterangan_sehat_group").show();
                        $("#password").show();
                        $("#repassword").show();
                        $('input[name="is_hidden"]').val("tidak");
                        var isEmpty = "ya";
                    }
                    $('input[name="nama"]').val(makes.nama);
                    $('input[name="id"]').val(makes.id);
                    $('input[name="no_ktp"]').val(makes.no_ktp);
                    $('input[name="tempat_lahir"]').val(makes.tempat_lahir);
                    $('input[name="email"]').val(makes.email);
                    $('input[name="kode_pos"]').val(makes.kode_pos);
                    $('input[name="agama"]').val(makes.agama);
                    $('input[name="no_ktp"]').val(value);
                    $('textarea[name="alamat"]').val(makes.alamat);
                    $('input:radio[name="agama"][value="' + makes.agama + '"]').attr('active', true);
                    if (makes.tanggal_lahir != undefined) {
                        $('#date-picker').data("DateTimePicker").date(new Date(makes.tanggal_lahir));
                    } else {
                        $('#date-picker').data("DateTimePicker").date(new Date());
                    }
                    $('#' + makes.jenis_kelamin).parent('.btn').addClass('active');
                    $('#' + makes.agama).parent('.btn').addClass('active');
                    $('input[name="no_hp"]').val(makes.no_hp);
                    $('input[name="ibu_kandung"]').val(makes.ibu_kandung);
                    $('input[name="jenjang"]').val(makes.jenjang);
                    $('input[name="sekolah"]').val(makes.sekolah);
                    $('input[name="tahun_lulus"]').val(makes.tahun_lulus);
                    $('input[name="jenis_kelamin"]').val(makes.jenis_kelamin);

                    $('#formRegister')
                            .formValidation('enableFieldValidators', 'password', !isEmpty)
                            .formValidation('enableFieldValidators', 'repassword', !isEmpty)
                            .formValidation('enableFieldValidators', 'foto_file', !isEmpty)
                            .formValidation('enableFieldValidators', 'ktp_file', !isEmpty)
                            .formValidation('enableFieldValidators', 'keterangan_sehat_file', !isEmpty);

                }
            });
        }

    });

</script>
