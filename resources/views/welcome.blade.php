<!DOCTYPE html>
<html>

<head>
    <title>e-food</title>

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="https://php8.appworkdemo.com/e_food/public/favicon.png">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="https://php8.appworkdemo.com/e_food/public/favicon.png">

</head>
<style>
    .text-container {
        background-image: linear-gradient(88deg, #808080, #de0c0c);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    /*.text-container .d {
	filter: brightness(999);
}*/

    .text-container .btndiv {
        margin-top: 50px;
        text-align: center;
    }

    .text-container .btndiv a {
        display: inline-block;
        padding: 10px 25px;
        background: #fff;
        font-size: 18px;
        margin: 0 10px;
        border-radius: 30px;
        min-width: 280px;
        text-align: center;
        box-shadow: 0 0 0 5px #ffffff6b;
        color: #f0555e;
        transition: 0.2s;
    }

    .text-container .btndiv a:hover {
        box-shadow: 0 0 0 10px #ffffff6b;
        transition: 0.2s;
    }

    @media (max-width: 767px) {
        .text-container .btndiv a {
            margin: 15px 0;
        }

        .text-container .btndiv {
            max-width: 500px;
        }

    }
</style>

<body>
    <div class="text-container">
        <img class="d" width="200px" src="https://php8.appworkdemo.com/e_food/public/logo.png" style="background: #ffffff6b;
    border-radius: 6px;
    padding: 5px;" alt="logo">
        <div class="btndiv">
           
            <a href="{{$geturldata->android_url}}">Download Android APK</a>
            <a href="{{$geturldata->ios_url}}">Download Apple Application</a>

            
        </div>
    </div>

</body>

</html>