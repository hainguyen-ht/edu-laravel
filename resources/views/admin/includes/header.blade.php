<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow"/>
    <base href="{{ asset('backend') }}/">
    <title>Page Title</title>
    <!--CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/reset-css.css">
</head>
<body>
<div class="app">
    <div class="header">
        <div class="breadcrumb-b">
            <a href="{{ route('admin') }}">Trang chủ</a>
        </div>
        <div class="mMenu__header">
            <i class="fas fa-bars"></i>
        </div>
        <div class="header__setting">
            <div class="header__setting-item">
                <img src="icons/messenger.png">
                <span class="header__setting-num">1</span>
            </div>
            <div class="header__setting-item">
                <img src="icons/help.png">
                <span class="header__setting-num">1</span>
            </div>
            <div class="header__setting-item">
                <img src="icons/notice.png">
                <span class="header__setting-num">1</span>
            </div>
            <div class="header__setting-item">
                <img src="icons/setter.png">
            </div>
        </div>
    </div>
