<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZIJOL_API</title>
    <!-- Fonts -->
    <link href="/css/app.css" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <table class="table table-striped table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">抖音号</th>
                <th scope="col">昵称</th>
                <th scope="col">性别</th>
                <th scope="col">详情</th>
            </tr>
            </thead>
            <tbody class="">
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->unique_id }}</td>
                    <td>{{ $user->nickname }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>
                        <a href="/dy/{{ $user->id }}/detail">详情</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                @if($pagination->page > 1)
                    <li class="page-item">
                        <a class="page-link"
                           href="{{ url()->current() . '?page='.($pagination->page - 1) }}">Previous</a>
                    </li>
                @endif

                @if($pagination->page < $pagination->total_page)
                    <li class="page-item">
                        <a class="page-link" href="{{ url()->current() . '?page='.($pagination->page + 1) }}">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
</body>
</html>
