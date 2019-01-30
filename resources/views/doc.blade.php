<head>
    <link href="css/app.css" rel="stylesheet">
    <link href="css/markdown.css" rel="stylesheet">
</head>

<div class="container-fluid row bg-light">
    <nav class="navbar navbar-light bg-light col-md-2 d-none d-md-block ">
        <div id="accordion">
            <div class="">
                <h5 class="mb-0">
                    <a href="/document" class="btn btn-link">
                        模板
                    </a>
                </h5>
            </div>
            @foreach($config as $key => $value)
                <div class="">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse_{{ $key }}"
                                aria-expanded="" aria-controls="collapseOne">
                            {{ $value['title'] }}
                        </button>
                    </h5>

                    <div id="collapse_{{ $key }}" class="collapse" aria-labelledby="heading_{{ $key }}"
                         data-parent="#accordion">
                        @foreach($value['docs'] as $tag => $name)
                            <button class="btn btn-link btn-block get_doc" tag="{{ $tag }}"
                                    type="{{ $key }}">{{ $name }}</button>
                        @endforeach
                    </div>
                </div>
        @endforeach
    </nav>
    <div class="markdown-body col-md-9 ml-sm-auto col-lg-10 pt-4 px-4 pl-4 doc_content">
        {!! $content !!}
    </div>
</div>
<script src="../js/app.js"></script>
<script>
    $('.get_doc').on('click', function () {
        var type = this.getAttribute('type');
        var tag = this.getAttribute('tag');
        $.ajax({
            url: "/document/" + type + "/" + tag,
            complete: function ($res) {
                $('.doc_content').html($res.responseJSON.result);
                console.log($res);
            },
            method: "get"
        })
    });
</script>


