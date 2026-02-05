@extends('layouts.backend.app')

@section('meta')
    <title>Leads | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Breadcrumb -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Assigned Leads</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Leads</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card border">
                        <div class="card-body">

                            <table id="assignLeads" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-1">Sr.No.</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Interest</th>
                                        <th>Meeting</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($leads as $key=>$lead)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $lead->name }}</td>
                                            <td>{{ $lead->mobile }}</td>
                                            <td>{{ $lead->interest }}</td>
                                            <td><strong>{{ $lead->meeting_datetime ?? 'N/A' }}</strong> </td>
                                            <td>
                                                <form method="POST" action="{{ route('leads.updateStatus', $lead->id) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <select name="deal_status" onchange="this.form.submit()"
                                                        class="form-select
                                                            {{ $lead->deal_status == 'pending' ? 'border border-danger text-danger' : '' }}
                                                            {{ $lead->deal_status == 'follow up' ? 'border border-warning text-warning' : '' }}
                                                            {{ $lead->deal_status == 'deal closed' ? 'border border-success text-success' : '' }}
                                                        ">

                                                        <option value="pending" class="text-danger"
                                                            {{ $lead->deal_status == 'pending' ? 'selected' : '' }}>
                                                            Pending
                                                        </option>

                                                        <option value="follow up" class="text-warning"
                                                            {{ $lead->deal_status == 'follow up' ? 'selected' : '' }}>
                                                            Follow Up
                                                        </option>

                                                        <option value="deal closed" class="text-success"
                                                            {{ $lead->deal_status == 'deal closed' ? 'selected' : '' }}>
                                                            Deal Closed
                                                        </option>

                                                    </select>
                                                    @if ($lead->deal_status === 'follow up')
                                                        <input type="date" name="follow_up_date"
                                                            value="{{ $lead->follow_up_date }}" class="form-control mt-2"
                                                            onchange="this.form.submit()">
                                                    @endif
                                                </form>
                                            </td>

                                            <td>
                                                @if ($lead->deal_status === 'deal closed')
                                                    <a href="{{ route('entry.fromLead', $lead->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        Create Entry
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                No leads assigned
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#assignLeads').DataTable({
                ordering: false,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
            });
        });
    </script>
@endsection
