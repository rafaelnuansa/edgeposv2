@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add New Printer</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('printers.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Printer Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1">
                                <label class="form-check-label" for="is_active">Is Active</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Printer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
