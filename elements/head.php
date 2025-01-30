<?php use App\Utility\Functions; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet/less" type="text/css" href="websrc/styles.less" />
    <script src="https://cdn.jsdelivr.net/npm/less" ></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/79684dd2cf.js" crossorigin="anonymous"></script>

    <title><?= Functions::convertToTitle($_GET['page']).' | ' ?? '' ?>Examen Realisatie</title>

</head>
<body>