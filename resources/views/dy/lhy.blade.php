<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>乖徒儿</title>
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <style>
        body {
            background: #06081B;
            perspective: 5000px;
        }

        .show {
            perspective: 5000px;
            -webkit-transform: rotateX(-45deg);
            -moz-transform: rotateX(-45deg);
            transform: rotateX(-45deg);
            transform-style: preserve-3d;
        }

        .box {
            position: relative;
            width: 170px;
            height: 300px;
            border: 1px solid red;
            margin: 300px auto;
            transform-style: preserve-3d;
            -webkit-animation: rotate1 10s linear infinite;
            -moz-animation: rotate1 10s linear infinite;
            animation: rotate1 10s linear infinite;
            background: url("/img/WechatIMG6.jpeg");
            background-size: 100% 100%;
        }

        .box img {
            width: 168px;
            height: 300px;
            border: 1px solid #ccc;
            position: absolute;
            left: 0;
            top: 0;
            -webkit-box-reflect: below 20px -webkit-linear-gradient(top, rgba(250, 250, 250, 0), rgba(250, 250, 250, 0) 30%, rgba(250, 250, 250, 0.5));
        }

        .img1 {
            -webkit-transform: translateZ(400px);
            -moz-transform: translateZ(400px);
            transform: translateZ(400px);
        }

        .img2 {
            -webkit-transform: rotateY(36deg) translateZ(400px);
            -moz-transform: rotateY(36deg) translateZ(400px);
            transform: rotateY(36deg) translateZ(400px);
        }

        .img3 {
            -webkit-transform: rotateY(72deg) translateZ(400px);
            -moz-transform: rotateY(72deg) translateZ(400px);
            transform: rotateY(72deg) translateZ(400px);
        }

        .img4 {
            -webkit-transform: rotateY(108deg) translateZ(400px);
            -moz-transform: rotateY(108deg) translateZ(400px);
            transform: rotateY(108deg) translateZ(400px);
        }

        .img5 {
            -webkit-transform: rotateY(144deg) translateZ(400px);
            -moz-transform: rotateY(144deg) translateZ(400px);
            transform: rotateY(144deg) translateZ(400px);
        }

        .img6 {
            -webkit-transform: rotateY(180deg) translateZ(400px);
            -moz-transform: rotateY(180deg) translateZ(400px);
            transform: rotateY(180deg) translateZ(400px);
        }

        .img7 {
            -webkit-transform: rotateY(216deg) translateZ(400px);
            -moz-transform: rotateY(216deg) translateZ(400px);
            transform: rotateY(216deg) translateZ(400px);
        }

        .img8 {
            -webkit-transform: rotateY(252deg) translateZ(400px);
            -moz-transform: rotateY(252deg) translateZ(400px);
            transform: rotateY(252deg) translateZ(400px);
        }

        .img9 {
            -webkit-transform: rotateY(288deg) translateZ(400px);
            -moz-transform: rotateY(288deg) translateZ(400px);
            transform: rotateY(288deg) translateZ(400px);
        }

        .img10 {
            -webkit-transform: rotateY(324deg) translateZ(400px);
            -moz-transform: rotateY(324deg) translateZ(400px);
            transform: rotateY(324deg) translateZ(400px);
        }

        @-moz-keyframes rotate1 {
            0% {
                -webkit-transform: rotateY(0deg);
                -moz-transform: rotateY(0deg);
                transform: rotateY(0deg);
            }
            100% {
                -webkit-transform: rotateY(360deg);
                -moz-transform: rotateY(360deg);
                transform: rotateY(360deg);
            }
        }

        @-webkit-keyframes rotate1 {
            0% {
                -webkit-transform: rotateY(0deg);
                -moz-transform: rotateY(0deg);
                transform: rotateY(0deg);
            }
            100% {
                -webkit-transform: rotateY(360deg);
                -moz-transform: rotateY(360deg);
                transform: rotateY(360deg);
            }
        }</style>
</head>
<body>
<div class="show">
    <div class="box">
        <img src="/img/WechatIMG1.jpeg" class="img1">
        <img src="/img/WechatIMG2.jpeg" class="img2">
        <img src="/img/WechatIMG3.jpeg" class="img3">
        <img src="/img/WechatIMG4.jpeg" class="img4">
        <img src="/img/WechatIMG5.jpeg" class="img5">
        <img src="/img/WechatIMG6.jpeg" class="img6">
        <img src="/img/WechatIMG7.jpeg" class="img7">
        <img src="/img/WechatIMG8.jpeg" class="img8">
        <img src="/img/WechatIMG9.jpeg" class="img9">
        <img src="/img/WechatIMG10.jpeg" class="img10">
    </div>
</div>

<script>

</script>

</body>
</html>
