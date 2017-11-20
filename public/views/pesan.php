<head>
    <link rel="shortcut icon" href="img/pp.ico">
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>
    <meta content="Landa Systems" name="author"/>

    <link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="./app/js/library/moment/moment.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    
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
                
                header('Refresh: 2; url='.$pesan['link']);
            }
        }
        ?>
    </div>
    
    