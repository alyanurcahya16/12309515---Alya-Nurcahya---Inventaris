@extends('layouts.dashboard')

@section('page-title', 'Edit Operator')

@section('dashboard-content')
<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-semibold">Edit Account</h5>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('operator.users.update') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- NAME --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $user->name }}"
                               required>
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $user->email }}"
                               required>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            New Password <small class="text-muted">(optional)</small>
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Leave blank if not changing">
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary px-4">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
