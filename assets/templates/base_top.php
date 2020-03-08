<?php
defined('BASEPATH') or exit('No direct script access allowed');

$loggedIn = true;
$userType = '';
$user_name = "";
if($this->session->has_userdata('User_ID')){
    $userType = 'user';
}elseif($this->session->has_userdata('Admin_ID')){
    $userType = 'admin';
}else{
    $loggedIn = false;
}

if($userType != ''){
    $user_name = $this->session->first_name;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title><?= (isset($title)) ? $title .' - Foodie': 'Foodie';?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Kuhle Hanisi's Foodie" />
    <meta name="keywords" content="Kuhle Hanisi's Foodie" />
    <meta name="developer" content="Kuhle Hanisi">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- FAV AND ICONS   -->
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.ico')?>">

    <!-- Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url('assets/icons/font-awesome-4.7.0/css/font-awesome.min.css')?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/css/bootstrap.min.css')?>">
    <!-- Animate CSS-->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/css/animate.css')?>">
    <!-- Owl Carousel CSS-->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/css/owl.css')?>">
    <!-- Fancybox-->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/css/jquery.fancybox.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/plugins/pushnotification/pushNotification.css')?>">

    <!-- Custom CSS-->
    <link rel="stylesheet" href="<?=base_url('assets/css/styles.css')?>">

    <?= (isset($other_style)) ? $other_style: ''?>

    <script src="<?=base_url('assets/js/modernizr.js')?>"></script>

</head>

<body class="">

    <?php include 'nav.php';?>
    <div class="nav-placeholder"></div>