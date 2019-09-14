<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZIJOL_API</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">

    <form class="form-inline">
        <div class="form-group mb-2">
            {{--<label for="staticEmail2" class="sr-only">Email</label>--}}
            <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">Password</label>
            <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Confirm identity</button>
    </form>

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

            <li class="page-item">
                <a class="page-link" href="{{ url()->current() . '?page=1' }}">First</a>
            </li>

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


            <li class="page-item">
                <a class="page-link" href="{{ url()->current() . '?page='.($pagination->total_page) }}">End</a>
            </li>
        </ul>
    </nav>
</div>
</body>
</html>
