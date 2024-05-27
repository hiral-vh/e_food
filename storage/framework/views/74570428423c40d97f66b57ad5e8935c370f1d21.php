<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Admin Dashboard" name="description" />
  <meta content="ThemeDesign" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
  <title>Restuarant Admin | <?php echo $__env->yieldContent('title'); ?></title>

  <link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>">

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/morris/morris.css')); ?>">
  <!--Full calendar Css -->
  <link href="<?php echo e(asset('admin/plugins/fullcalendar/css/fullcalendar.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo e(asset('admin/css/icons.css')); ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo e(asset('admin/css/style.css')); ?>" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/sweetalert2/sweetalert2.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/select2/css/select2.min.css')); ?>">
  <link href="<?php echo e(asset('admin/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css">

  <?php echo $__env->yieldContent('css'); ?>
  <style>
    body {
      scroll-behavior: smooth;
    }

    .user-details img {
      width: 52px;
    }
  </style>
</head>

<body class="fixed-left">

  <!-- Begin page -->
  <div id="wrapper"><?php /**PATH C:\xampp\htdocs\e_food\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>