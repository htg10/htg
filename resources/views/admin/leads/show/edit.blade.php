@extends('layouts.backend.app')

@section('meta')
    <title>Edit Lead | Telecaller</title>
@endsection

@section('content')
    <!-- [ Page Content ] start -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- [ breadcrumb ] start -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Lead</h4>

                        <div class="page-title-right">
                            {{-- <a href="{{ url('user/index') }}" class="btn btn-primary waves-effect waves-light"><i
                                    class="fas fa-reply-all"></i> Back to list</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="row g-1">
                <div class="card col-lg-5 mt-2">
                    <div class="form-section mx-3 my-2">
                        <!-- Modify the form to use PUT or PATCH method for update -->
                        <form action="{{ route('admin.lead.update', $telecallers->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation row g-3" novalidate>
                            @method('PATCH')
                            @csrf

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="col-12 mt-3">
                                <label for="address">Customer Name :</label>
                                <input type="text" class="form-control" name="name" placeholder="Customer Name" value="{{ $telecallers->name }}">
                            </div>
                            <div class="col-12 mt-3">
                                <label for="address">Address :</label>
                                <input type="text" class="form-control" name="address" placeholder="Address"
                                    value="{{ $telecallers->address }}">
                            </div>

                            <div class="col-md-6">
                                <label for="mobile">Mobile Number :</label>
                                <input type="text" class="form-control" name="mobile" placeholder="Mobile Number"
                                    value="{{ $telecallers->mobile }}">
                            </div>

                            <div class="col-md-5">
                                <label for="user_id">BDM :</label>
                                <select class="form-select form-control form-control-sm" name="user_id" id="user_id"
                                    required>
                                    <option value="">Select BDM</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $telecallers->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">This field is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="meeting_datetime">Meeting Date and Time :</label>
                                <input type="datetime-local" class="form-control" name="meeting_datetime"
                                    id="meeting_datetime" placeholder="Select Date and Time" value="{{ $telecallers->meeting_datetime }}">
                            </div>

                            <div class="col-md-6">
                                <label for="interest">Interest Level :</label>
                                <select class="form-select form-control form-control-sm" name="interest" id="interest"
                                    required>
                                    <option value="">Select</option>
                                    <option value="High" {{ $telecallers->interest == 'High' ? 'selected' : '' }}>High
                                    </option>
                                    <option value="Moderate" {{ $telecallers->interest == 'Moderate' ? 'selected' : '' }}>
                                        Moderate</option>
                                    <option value="Low" {{ $telecallers->interest == 'Low' ? 'selected' : '' }}>Low
                                    </option>
                                </select>
                                <div class="invalid-feedback">This field is required.</div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="card action-btn text-center">
                                    <div class="card-body p-2">
                                        <button type="submit" class="btn btn-success m-0">Update Lead</button>
                                        <button type="reset" class="btn btn-warning waves-effect waves-light">Clear
                                            Form</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Page Content ] end -->
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
