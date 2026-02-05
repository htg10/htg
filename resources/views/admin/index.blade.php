@extends('layouts.backend.app')

@section('meta')
    <title>Dashboard | Admin</title>
@endsection
@section('style')
    <style>
        .dataTables_wrapper {
            position: relative;
            clear: both;
            margin-top: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- [ breadcrumb ] start -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card border">
                        <div class="card-body">
                            <form action="{{ route('index') }}" method="GET">
                                <div class="row mb-2">
                                    <div class="form-group col-lg-3">
                                        <input type="text" name="company" id="company" placeholder="Company Name"
                                            class="form-control" value="{{ request('company') }}">
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <select name="year" class="form-select">
                                            <option value="" selected>Select Year</option>
                                            @for ($i = now()->year; $i >= 2000; $i--)
                                                <option value="{{ $i }}"
                                                    {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <select name="month" class="form-select">
                                            <option value="" selected>Select Month</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ request('month') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <select name="inputState" class="form-select">
                                            <option value="">Expired/Pending</option>
                                            <option value="Expired"
                                                {{ request('inputState') == 'Expired' ? 'selected' : '' }}>
                                                Expired</option>
                                            <option value="Pending"
                                                {{ request('inputState') == 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('index') }}" class="btn btn-danger">Reset</a>

                                {{-- <a href="{{ route('export.contracts', ['inputState' => request('inputState')]) }}"
                                    class="btn btn-success ">Export {{ request('inputState') ?? 'All' }}
                                    Contracts</a>&emsp;&emsp; --}}
                                <a href="{{ route('export.contracts', request()->all()) }}" class="btn btn-success">
                                    Export {{ request('inputState') ?? 'All' }} Contracts
                                </a>&emsp;&emsp;

                                Total Amount: <strong>{{ number_format($totalAmount, 2) }}</strong>
                                &emsp;
                                Total Balance Payment:
                                <strong>{{ number_format($totalBalance, 2) }}</strong>

                            </form>

                            <table id="contractsTable" class="table table-bordered dt-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="col-1">Sr.No.</th>
                                        <th>Company Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>Total Amount</th>
                                        <th>Balance Payment</th>
                                        <th>Images</th>
                                        {{-- <th>Download</th> --}}
                                        <th>BDM Name</th>
                                        <th>GST No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entries as $key => $entry)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $entry->company }}</td>
                                            <td>{{ $entry->type }}</td>
                                            <td>{{ $entry->date }}</td>
                                            <td>{{ $entry->contact }}</td>
                                            <td>{{ $entry->contactno }}</td>
                                            <td>{{ $entry->totalAmount }}</td>
                                            <td>{{ $entry->balancePayment }}</td>
                                            {{-- <td>
                                                @if (!empty($entry->image) && is_array(json_decode($entry->image)))
                                                    @foreach (json_decode($entry->image) as $imagePath)
                                                        <img src="{{ url($imagePath) }}" alt="Image" height="80"
                                                            width="80">
                                                    @endforeach
                                                @else
                                                    <p>No images</p>
                                                @endif

                                            </td> --}}
                                            <td><a href="{{ route('download', $entry->id) }}"
                                                    class="btn btn-primary">Download</a></td>
                                            <td>{{ $entry->user->name ?? 'null' }}</td>
                                            <td>{{ $entry->gst }}</td>
                                            <td class="text-center">
                                                <a href="{{ 'entry/' . $entry->id . '/edit' }}"
                                                    class="btn btn-soft-info btn-sm waves-effect waves-light"><img
                                                        src="{{ asset('assets/icons/edit.svg') }}" alt=""></a>
                                                {{-- <a href="{{ 'entry/delete/' . $entry->id }}"
                                                    class="btn btn-soft-danger btn-sm waves-effect waves-light"
                                                    title="Delete Brand"><img src="{{ asset('assets/icons/delete.svg') }}"
                                                        alt=""></a> --}}
                                                <a href="javascript:void(0);"
                                                    class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete"
                                                    title="Delete Brand" data-id="{{ $entry->id }}"
                                                    data-link="/entry/delete/"> <img
                                                        src="{{ asset('assets/icons/delete.svg') }}" alt=""></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div> <!-- end col -->

            </div> <!-- end row -->
            <div class="row">
                <div id="piechart" style="width: 400px; height: 300px;"></div>
                <div id="bdmName" style="width: 400px; height: 300px;"></div>
                <div id="productName" style="width: 800px; height: 300px;"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#contractsTable').DataTable({
                ordering: false,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
            });
        });
    </script>

    {{-- New/Renew --}}
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Type', 'Count'],
                {!! $chartData !!}
            ]);

            var options = {
                title: 'New/Renew',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

    {{-- BDM Name --}}
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['BDM Name', 'Count'],
                {!! $bdmDataString !!}
            ]);

            var options = {
                title: 'BDM Name',
            };

            var chart = new google.visualization.PieChart(document.getElementById('bdmName'));

            chart.draw(data, options);
        }
    </script>

    {{-- Product Name --}}
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Service Name', 'Count'],
                {!! $productDataString !!}
            ]);

            var options = {
                title: 'Service Name',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('productName'));

            chart.draw(data, options);
        }
    </script>
@endsection
