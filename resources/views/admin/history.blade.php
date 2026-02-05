<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>DashBoard</title>
</head>

<body>
    <!--[ Main Header ] start -->
    <header id="page-topbar">
        <nav class="navbar" style="background: #5f7af1">
            <div class="container-fluid">
                <a class="navbar-brand ms-3">
                    <h4 style="color: white">HELP TOGETHER GROUP</h4>
                </a>
            </div>
        </nav>
    </header>

    <div class="add m-3">
        <a href="/index" class="btn btn-success">Back</a>
    </div>
    <div class="container-fluid">
        <h1>Entry History</h1>
        <div class="list">
            <table class="table table-bordered dt-responsive nowrap w-100 mt-3">
                            <thead>
                                <tr>
                                    <th class="col-1">Sr.No.</th>
                                    <th>Entry Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entryHistories as $key => $history)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $history->company}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
