@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h2 class="fw-bold mb-1">Manager Dashboard</h2>
        <p class="text-muted mb-0">Unified interface for contacts and custom field management.</p>
    </div>
    <div class="d-none d-md-block">
        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill">
            <i class="bi bi-clock me-2 text-primary"></i> {{ date('D, M d Y') }}
        </span>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-tabs-custom mb-4" id="dashboardTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">
            <i class="bi bi-people fs-5"></i>
            <span>Contacts</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="fields-tab" data-bs-toggle="tab" data-bs-target="#fields" type="button" role="tab">
            <i class="bi bi-ui-checks fs-5"></i>
            <span>Custom Fields</span>
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="dashboardTabContent">
    <!-- Contacts Tab -->
    <div class="tab-pane fade show active" id="contacts" role="tabpanel">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div class="input-group search-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="globalSearch" class="form-control border-start-0 ps-0" placeholder="Quick search contacts...">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary d-flex align-items-center gap-2 mergeBtn">
                    <i class="bi bi-shuffle"></i>
                    <span>Merge Selected</span>
                </button>
                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addContactModal">
                    <i class="bi bi-plus-lg"></i>
                    <span>New Contact</span>
                </button>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="ps-4 text-center">
                                <input type="checkbox" class="form-check-input" id="selectAll" aria-label="Select all contacts">
                            </th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="contactTableBody">
                        @include('contacts.partials.table')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Custom Fields Tab -->
    <div class="tab-pane fade" id="fields" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Add Custom Field</h5>
                        <p class="text-muted small mb-4">Create new dynamic data points for your contacts.</p>
                        
                        <form action="{{ route('custom-fields.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-medium">Field Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Birthday, Company" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-medium">Input Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="text">Single Line Text</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date Picker</option>
                                    <option value="textarea">Large Text Area</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-plus-circle me-2"></i> Register Field
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Field Name</th>
                                        <th>Data Type</th>
                                        <th class="text-end pe-4">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allCustomFields as $field)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $field->name }}</div>
                                            <div class="text-muted small">Created on {{ $field->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark rounded-pill px-3">{{ ucfirst($field->type) }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light text-danger border-0" title="Delete Not Implemented">
                                                <i class="bi bi-trash3 fs-6"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if(count($allCustomFields) == 0)
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="bi bi-layers fs-1 d-block mb-2 opacity-25"></i>
                                            <span class="text-muted">No custom fields defined yet.</span>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('contacts.partials.add_modal')

<!-- Container for Dynamic Modals -->
<div id="editModalContainer"></div>
<div id="mergeModalContainer"></div>

@include('contacts.indexjs')

@push('scripts')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Action Successful',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush


@endsection
