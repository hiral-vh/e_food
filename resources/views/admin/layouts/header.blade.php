<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Admin Dashboard" name="description" />
  <meta content="ThemeDesign" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Restuarant Admin | @yield('title')</title>

  <link rel="shortcut icon" href="{{asset('favicon.png')}}">

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="{{asset('admin/plugins/morris/morris.css')}}">
  <!--Full calendar Css -->
  <link href="{{asset('admin/plugins/fullcalendar/css/fullcalendar.min.css')}}" rel="stylesheet" />
  <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="{{asset('admin/plugins/sweetalert2/sweetalert2.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
  <link href="{{asset('admin/css/daterangepicker.css')}}" rel="stylesheet" type="text/css">

  @yield('css')
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
  <div id="wrapper">