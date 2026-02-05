@extends('layouts.backend.app')

@section('meta')
    <title>Dashboard | Admin</title>
@endsection


@section('content')
    <!--[ Page Content ] start -->
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
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium"> Total Services</p>
                                            <h4 class="mb-0">{{ $services->count() }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bxs-book-content font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium"> Total Contracts</p>
                                            <h4 class="mb-0">{{ $entry->count() }}</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mb-3 font-size-18">All Payment</h4>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-end">

                        <div class="col-3">
                            <label class="form-label">Payment Mode</label>
                            <select id="payment_mode" class="form-control">
                                <option value="">All</option>
                                @foreach ($banks as $b)
                                    <option value="{{ $b->bank }}">{{ $b->bank }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-3">
                            <label class="form-label">From Date</label>
                            <input type="date" id="from_date" class="form-control">
                        </div>

                        <div class="col-3">
                            <label class="form-label">To Date</label>
                            <input type="date" id="to_date" class="form-control">
                        </div>

                        <div class="col-3">
                            <button class="btn btn-primary mb-1" id="filterBtn">
                                Apply Filter
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Reset</a><br>
                            <button class="btn btn-success" id="exportExcel">Export Excel</button>
                            <button class="btn btn-danger" id="exportPdf">Export PDF</button>
                        </div>

                    </div>
                    <div id="filterResult" class="mt-2">
                        @include('admin.dashboard-data')
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div id="bdmName" style="height:350px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="productName" style="height:350px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="paymentChart" style="height:350px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="dateChart" style="height:350px;"></div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('script')
    <script>
        google.charts.load('current', {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawAllCharts);

        function drawAllCharts() {
            drawBDMChart();
            drawProductChart();
            drawPaymentChart();
            drawDateChart();
        }


        function drawBDMChart() {
            var data = google.visualization.arrayToDataTable([
                ['BDM', 'Count'],
                {!! $bdmDataString !!}
            ]);
            new google.visualization.PieChart(document.getElementById('bdmName'))
                .draw(data, {
                    title: 'BDM Wise'
                });
        }

        function drawProductChart() {
            var data = google.visualization.arrayToDataTable([
                ['Service', 'Count'],
                {!! $productDataString !!}
            ]);
            new google.visualization.PieChart(document.getElementById('productName'))
                .draw(data, {
                    title: 'Service Wise',
                    is3D: true
                });
        }

        function drawPaymentChart() {
            var data = google.visualization.arrayToDataTable([
                ['Payment Mode', 'Amount'],
                {!! $paymentChartData !!}
            ]);
            console.log([
                ['Payment Mode', 'Amount'],
                {!! $paymentChartData !!}
            ]);
            new google.visualization.PieChart(document.getElementById('paymentChart'))
                .draw(data, {
                    title: 'Payment Mode Wise Collection'
                });
        }

        function drawDateChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Amount'],
                {!! $dateChartData !!}
            ]);
            new google.visualization.ColumnChart(document.getElementById('dateChart'))
                .draw(data, {
                    title: 'Date Wise Collection'
                });
        }
    </script>

    <script>
        document.getElementById('filterBtn').addEventListener('click', function() {

            let payment = document.getElementById('payment_mode').value;
            let fromDate = document.getElementById('from_date').value;
            let toDate = document.getElementById('to_date').value;

            fetch("{{ route('dashboard.payment.filter') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        payment_mode: payment,
                        from_date: fromDate,
                        to_date: toDate
                    })
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('filterResult').innerHTML = html;
                });
        });

        function getFilters() {
            return {
                payment_mode: document.getElementById('payment_mode').value,
                from_date: document.getElementById('from_date').value,
                to_date: document.getElementById('to_date').value
            };
        }

        document.getElementById('exportExcel').onclick = () => {
            let f = getFilters();
            window.location =
                `{{ route('dashboard.export.excel') }}?payment_mode=${f.payment_mode}&from_date=${f.from_date}&to_date=${f.to_date}`;
        };

        document.getElementById('exportPdf').onclick = () => {
            let f = getFilters();
            window.location =
                `{{ route('dashboard.export.pdf') }}?payment_mode=${f.payment_mode}&from_date=${f.from_date}&to_date=${f.to_date}`;
        };
    </script>
@endsection
