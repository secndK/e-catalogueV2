<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="shortcut icon" href="img/icons/v.png" />

    <title>@yield('title', 'CATALOGUE')</title>

    <link href="css/app.css" rel="stylesheet">

</head>

<body>
    <div class="wrapper">
        @include('layouts.partials.sidebar')

        <div class="main">
            @include('layouts.partials.navbar')



            <main class="content">
                <div class="container-fluid p-0">
                    @include('layouts.partials.banner')
                    @yield('content')
                </div>
            </main>
            @include('layouts.partials.footer')


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>


    <script src="js/app.js"></script>

</body>

</html>
