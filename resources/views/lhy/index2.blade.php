<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>乖徒儿</title>
    <link rel="stylesheet" href="/css/lhy/index2.css">
    <link rel="stylesheet" href="/css/lhy/snowfall.css">
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

<script type="text/javascript" src="/js/jquery3.1.1.min.js"></script>
<script type="text/javascript" src="/js/lhy/snowfall.jquery.min.js"></script>
<script type="text/javascript">
    $(document).snowfall({flakeCount: 30, maxSpeed: 6});
</script>
</body>
</html>
