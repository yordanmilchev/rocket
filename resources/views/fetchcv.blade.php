<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show CVs</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-3.1.1-dist/css/bootstrap.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<table style="display: none">
    <tbody>
    <tr id="cv-template">
        <td class="name"></td>
        <td class="dob"></td>
        <td class="uni"></td>
        <td class="skills"></td>
    </tr>
    </tbody>
</table>

<div class="col-md-4 col-md-offset-4">
    <div class="buttondiv">
        <button type="button" class="btn btn-success" onclick="window.location='{{ Route("createcv")}}'">Create CV
        </button>
    </div>
    <div class="content" style="display: flex;">
        <div class="form-group">
            <input type="text" class="form-control"
                   placeholder="From"
                   id="dateinputfrom">
        </div>

        <div class="form-group">
            <input type="text" class="form-control"
                   placeholder="To"
                   id="dateinputto">
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Име</th>
            <th scope="col">Дата на раждане</th>
            <th scope="col">Университет</th>
            <th scope="col">Умения</th>
        </tr>
        </thead>
        <tbody class="table-body">
        </tbody>
    </table>
</div>
<script>

    loadData();
    $('#dateinputfrom').datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });

    $('#dateinputto').datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });

    $('#dateinputfrom').on('change', function () {
        loadData(true);
    });

    $('#dateinputto').on('change', function () {
        loadData(true);
    });

    function loadData(filter = false) {
        var $template = $("#cv-template");
        console.log($template);

        $('.table-body').empty();
        $.each($('.table-body'), function (i, item) {
            var $tbody = $(this);
            from = null;
            to = null;
            if (filter) {
                from = $('#dateinputfrom').val();
                to = $('#dateinputto').val();
            }

            $.ajax({
                type: "GET",
                url: "{{route("fetchcv")}}",
                data: {
                    from: from,
                    to: to
                },
                success: function (response) {
                    $.each(response.cvs, function (i, item) {
                        var $cloned = $template.clone();
                        $cloned.find('.name').text(item.ime + " " + item.prezime +" "+ item.familiq);
                        $cloned.find('.dob').text(item.dob);
                        $cloned.find('.uni').text(item.uni);
                        $cloned.find('.skills').text(item.skills);
                        $tbody.append($cloned);
                    });
                },
                error: function (response) {
                },
                completed: function () {
                },
                dataType: "json"
            });
        });

    };
</script>
</body>
</html>
