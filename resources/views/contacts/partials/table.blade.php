@if(count($contacts) > 0)
    @foreach($contacts as $contact)
        <tr id="row-{{ $contact->id }}">
            <td class="ps-4 text-center">
                <input type="checkbox" class="form-check-input merge-check" value="{{ $contact->id }}" aria-label="Select {{ $contact->name }}">
            </td>
            <td>
                <div class="d-flex align-items-center gap-3">
                    @if($contact->profile_image)
                        <img src="{{ asset('uploads/profile_images/' . $contact->profile_image) }}" class="avatar shadow-sm border" alt="{{ $contact->name }}">
                    @else
                        <div class="avatar d-flex align-items-center justify-content-center bg-primary-light text-primary fw-bold shadow-sm border">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="fw-bold text-dark">{{ $contact->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Added {{ $contact->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </td>
            <td>
                <div class="text-truncate" style="max-width: 180px;" title="{{ $contact->email }}">
                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none text-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-at small"></i>
                        {{ $contact->email }}
                    </a>
                </div>
            </td>
            <td>
                <span class="text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-phone small"></i>
                    {{ $contact->phone }}
                </span>
            </td>
            <td>
                <span class="badge {{ $contact->gender == 'male' ? 'bg-primary-light text-primary' : 'bg-danger-subtle text-danger' }} badge-pill">
                    {{ ucfirst($contact->gender) }}
                </span>
            </td>
            <td>
                @if($contact->is_merged && $contact->mergedInto)
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">
                        <i class="bi bi-link-45deg me-1"></i>Merged
                    </span>
                @else
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                        <i class="bi bi-dot fs-4 align-middle"></i>Active
                    </span>
                @endif
            </td>
            <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" data-id="{{ $contact->id }}" class="btn btn-light btn-sm editBtn border shadow-sm" title="Edit Contact" aria-label="Edit {{ $contact->name }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" onclick="deleteContact({{ $contact->id }})" class="btn btn-light btn-sm text-danger border shadow-sm" title="Delete Contact" aria-label="Delete {{ $contact->name }}">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center py-5">
            <div class="py-4">
                <i class="bi bi-person-slash fs-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">No contacts found</h5>
                <p class="text-muted small">Try adjusting your search filters or add a new contact.</p>
            </div>
        </td>
    </tr>
@endif