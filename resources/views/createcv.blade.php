<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create CV</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-3.1.1-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
</head>
<body>
<div class="col-md-4 col-md-offset-4">
    <div class="buttondiv">
        <button type="button" id="firstbtn" class="btn btn-success"
                onclick="window.location='{{ Route("showrecords")}}'">Show records
        </button>
    </div>

    <h1 style="text-align: center;">Създаване на CV</h1>
    <form action="{{ route('createdbrecord') }}" method="post">
        @csrf
        @if(Session::get('success'))
            <div id="status" class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::get('fail'))
            <div id="status" class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif

        <div class="addunimodal" id="newinput" style="display: none;">
            <h4>Въвеждане на нов университет</h4>
            <div class="form-group">
                <input type="text" class="form-control" id="nameuni" placeholder="Име на университет">
                <span class="text-danger">@error('nameuni'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="ocenka" placeholder="Акредитация">
                <span class="text-danger">@error('ocenka'){{ $message }} @enderror</span>
            </div>
            <button type="button" id="close"><img src="x-lg.svg"></button>
            <button type="button" id="addunibtn" class="btn btn-primary" style="float: right;">Запис</button>
        </div>

        <div class="addskillmodal" id="newinput" style="display: none;">
            <h4>Въвеждане на нова технология</h4>
            <div class="form-group">
                <input type="text" class="form-control" id="nameskill" placeholder="Име на технологията"
                       value="{{ old('nameskill') }}">
                <span class="text-danger">@error('nameskill'){{ $message }} @enderror</span>
            </div>
            <button type="button" id="close"><img src="x-lg.svg"></button>
            <button type="button" id="addskillbtn" class="btn btn-primary" style="float: right;">Запис</button>
        </div>


        <div class="form-group">
            <input type="text" class="form-control" name="ime" placeholder="Име..." value="{{ old('ime') }}">
            <span class="text-danger">@error('ime'){{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="prezime" placeholder="Презиме..."
                   value="{{ old('prezime') }}">
            <span class="text-danger">@error('prezime'){{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="familiq" placeholder="Фамилия..."
                   value="{{ old('familiq') }}">
            <span class="text-danger">@error('familiq'){{ $message }} @enderror</span>
        </div>


        <div class="form-group" style="text-align: center;">
            Дата на раждане :<input type="text" class="form-control" name="dateofbirth"
                                    placeholder="Click to select date..."
                                    value="{{old('dateofbirth')}}"
                                    id="dateinput"><br>
            <span class="text-danger">@error('dateofbirth'){{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <select name="uni" id="uni">
                <option selected disabled>
                    Изберете университет
                </option>
                @foreach($Unis as $uni)
                <option value="{{$uni->name}}">
                    {{$uni->name}}
                </option>
                @endforeach
            </select>
            <button type="button" id="adduni"><img src="pencil.svg"></button><br>
            <span class="text-danger">@error('uni'){{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <select name="skills[]" id="skills" multiple>
                <option selected disabled>
                    Умения в технологии:
                </option>
                @foreach($Skills as $skill)
                    <option value="{{$skill->name}}">
                        {{$skill->name}}
                    </option>
                @endforeach
            </select>
            <button type="button" id="addskill"><img src="pencil.svg"></button><br>
            <span class="text-danger">@error('skills'){{ $message }} @enderror</span>
        </div>
        <button type="submit" class="btn btn-block btn-primary">Запис на CV</button>
    </form>

</div>
<script>
    $(function () {
        $('#dateinput').datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
        });
    });

    $('body').on('click', '#adduni', function () {
        $('.addunimodal').css("display", "block");
        $('.addskillmodal').css("display", "none");
    })

    $('body').on('click', '#addskill', function () {
        $('.addskillmodal').css("display", "block");
        $('.addunimodal').css("display", "none");
    })

    $('body').on('click', '#close', function () {
        $('.addskillmodal').css("display", "none");
        $('.addunimodal').css("display", "none");
    })

    $('#addunibtn').on('click', function () {
        let nameuni = $('#nameuni').val();
        let ocenka = $('#ocenka').val();
        $.ajax({
            method: "GET",
            url: "{{ route('adduni') }}",
            data: {
                nameuni: nameuni,
                ocenka: ocenka
            },
            success: function (response) {

                $('#uni').append(new Option(response.name, response.name));
                $('.addunimodal').css("display", "none");

            }
        });
    })

    $('#addskillbtn').on('click', function () {
        let nameskill = $('#nameskill').val();

        $.ajax({
            method: "GET",
            url: "{{ route('addskill') }}",
            data: {
                nameskill:nameskill
            },
            success: function (response) {

                $('#skills').append(new Option(response.name, response.name));
                $('.addskillmodal').css("display", "none");
            }
        });
    })

    setTimeout(function () {
        $('#status').fadeOut();
    },3000);
</script>
</body>
</html>
