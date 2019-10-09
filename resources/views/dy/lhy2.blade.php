<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>乖徒儿</title>
    <style type="text/css">
        * {
            margin: 0 auto;
            padding: 0;
        }

        @keyframes rotate {
            0% {
                transform: rotateX(0deg) rotateY(0deg);
            }
            100% {
                transform: rotateX(360deg) rotateY(360deg);
            }
        }

        html {
            background: linear-gradient(pink 0%, #000 100%);
            height: 100%;
        }

        .wrap {
            margin-top: 200px;
            perspective: 1000px; /* 视图距元素的距离 相当于摄像机 */
        }

        .cube {
            width: 300px;
            height: 300px;
            position: relative;
            color: #fff;
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            line-height: 300px;
            transform-style: preserve-3d; /* 默认flat 2D */
            transform: rotateX(-30deg) rotateY(-70deg);
            animation: rotate 20s infinite linear; /*播放时间 播放次数为循环 缓动效果为匀速 */
        }

        .cube > div {
            width: 100%;
            height: 100%;
            border: 1px solid #fff;
            position: absolute;
            opacity: .7;
            transition: transform 0.4s ease-in;
        }

        .cube .out-front {
            background: url("/img/WechatIMG6.jpeg");
            background-size: 100% 100%;
            transform: translateZ(150px);
        }

        .cube .out-back {
            background: url("/img/WechatIMG7.jpeg");
            background-size: 100% 100%;
            transform: translateZ(-150px) rotateY(180deg);
        }

        .cube .out-left {
            background: url("/img/WechatIMG8.jpeg");
            background-size: 100% 100%;
            transform: translateX(-150px) rotateY(-90deg);
        }

        .cube .out-right {
            background: url("/img/WechatIMG9.jpeg");
            background-size: 100% 100%;
            transform: translateX(150px) rotateY(90deg);
        }

        .cube .out-top {
            background: url("/img/WechatIMG10.jpeg");
            background-size: 100% 100%;
            transform: translateY(-150px) rotateX(90deg);
        }

        .cube .out-bottom {
            background: url("/img/WechatIMG6.jpeg");
            background-size: 100% 100%;
            transform: translateY(150px) rotateX(-90deg);
        }

        .cube > span {
            display: block;
            width: 150px;
            height: 150px;
            border: 1px solid #fff;
            position: absolute;
            /*opacity: .7;*/
            top: 50px;
            left: 50px;
        }

        .cube .in-front {
            background: url("/img/WechatIMG1.jpeg");
            background-size: 100% 100%;
            transform: translateZ(75px);
        }

        .cube .in-back {
            background: url("/img/WechatIMG2.jpeg");
            background-size: 100% 100%;
            transform: translateZ(-75px) rotateY(180deg);
        }

        .cube .in-left {
            background: url("/img/WechatIMG3.jpeg");
            background-size: 100% 100%;
            transform: translateX(-75px) rotateY(-90deg);
        }

        .cube .in-right {
            background: url("/img/WechatIMG4.jpeg");
            background-size: 100% 100%;
            transform: translateX(75px) rotateY(90deg);
        }

        .cube .in-top {
            background: url("/img/WechatIMG5.jpeg");
            background-size: 100% 100%;
            transform: translateY(-75px) rotateX(90deg);
        }

        .cube .in-bottom {
            background: url("/img/WechatIMG1.jpeg");
            background-size: 100% 100%;
            transform: translateY(75px) rotateX(-90deg);
        }

        .wrap:hover .out-front {
            transform: translateZ(250px);
        }

        .wrap:hover .out-back {
            transform: translateZ(-250px) rotateY(180deg);
        }

        .wrap:hover .out-left {
            transform: translateX(-250px) rotateY(-90deg);
        }

        .wrap:hover .out-right {
            transform: translateX(250px) rotateY(90deg);
        }

        .wrap:hover .out-top {
            transform: translateY(-250px) rotateX(90deg);
        }

        .wrap:hover .out-bottom {
            transform: translateY(250px) rotateX(-90deg);
        }

    </style>
</head>
<body>
<div class="wrap">
    <div class="cube">
        <!--外部盒子-->
        <div class="out-front"></div>
        <div class="out-back"></div>
        <div class="out-left"></div>
        <div class="out-right"></div>
        <div class="out-top"></div>
        <div class="out-bottom"></div>

        <!--内部盒子-->
        <span class="in-front"></span>
        <span class="in-back"></span>
        <span class="in-left"></span>
        <span class="in-right"></span>
        <span class="in-top"></span>
        <span class="in-bottom"></span>
    </div>
</div>
</body>
</html>
