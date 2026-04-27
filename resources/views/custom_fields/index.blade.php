@extends('layouts.app')

@section('title', 'Custom Fields')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Custom Fields</h3>
        <p class="text-muted small">Define additional data points for your contacts.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Add New Field</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('custom-fields.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Field Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Birthday, Company" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Field Type</label>
                        <select name="type" class="form-select" required>
                            <option value="text">Text Input</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                            <option value="textarea">Large Text (Textarea)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i> Add Field
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Existing Fields</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Field Name</th>
                                <th>Type</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($custom_fields as $field)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $field->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark rounded-pill px-3">
                                        {{ ucfirst($field->type) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-light btn-sm rounded-circle text-danger" title="Delete Field (Not Implemented)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @if(count($custom_fields) == 0)
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No custom fields defined yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    @section('scripts')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Created!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endsection
@endif

@endsection