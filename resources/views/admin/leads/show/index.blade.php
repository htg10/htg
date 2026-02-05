@extends('layouts.backend.app')

@section('meta')
    <title>Dashboard | Admin</title>
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
                            <table id="telecallerTable" class="table table-bordered dt-responsive nowrap w-100 mt-3">
                                <thead>
                                    <tr>
                                        <th class="col-1">Sr.No.</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Meeting Date and Time</th>
                                        <th>Mobile Number</th>
                                        <th>BDM Name</th>
                                        <th>Interest</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($telecallers as $key => $telecaller)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $telecaller->name }}</td>
                                            <td>{{ $telecaller->address }}</td>
                                            <td>{{ \Carbon\Carbon::parse($telecaller->meeting_datetime)->format('d M Y h:i A') }}
                                            </td>
                                            <td>{{ $telecaller->mobile }}</td>
                                            <td>{{ $telecaller->user->name }}</td>
                                            <td>{{ $telecaller->interest }}</td>
                                            <td
                                                class="
                                                @if ($telecaller->deal_status == 'pending') text-danger
                                                @elseif($telecaller->deal_status == 'follow up')
                                                    text-warning
                                                @elseif($telecaller->deal_status == 'deal closed')
                                                    text-success @endif
                                            ">
                                                {{ ucwords($telecaller->deal_status) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.lead.edit', $telecaller->id) }}"
                                                    class="btn btn-soft-info btn-sm waves-effect waves-light"><img
                                                        src="{{ asset('assets/icons/edit.svg') }}" alt=""></a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete"
                                                    title="Delete Brand" data-id="{{ $telecaller->id }}"
                                                    data-link="/admin/lead/delete/"><img
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

        </div>
    </div>
    </div>
@endsection
@section('script')
     <script>
        $(document).ready(function() {
            $('#telecallerTable').DataTable({
                ordering: false,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
            });
        });
    </script>
@endsection
