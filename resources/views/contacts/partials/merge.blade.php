<div class="modal fade" id="mergeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <form id="mergeForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Merge Contacts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
                        <div class="p-3 border rounded-3 bg-light" style="width: 200px;">
                            <div class="fw-bold">{{ $contact1->name }}</div>
                            <div class="text-muted small">{{ $contact1->email }}</div>
                        </div>
                        <div class="fs-3 text-muted"><i class="bi bi-arrow-left-right"></i></div>
                        <div class="p-3 border rounded-3 bg-light" style="width: 200px;">
                            <div class="fw-bold">{{ $contact2->name }}</div>
                            <div class="text-muted small">{{ $contact2->email }}</div>
                        </div>
                    </div>

                    <div class="row g-3 text-start">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Primary (Main) Contact</label>
                            <select name="primary_id" id="primary_id" class="form-select" required>
                                <option value="{{ $contact1->id }}" selected>{{ $contact1->name }}</option>
                                <option value="{{ $contact2->id }}">{{ $contact2->name }}</option>
                            </select>
                            <div class="form-text small">This contact will keep its original identity.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Secondary (Merged) Contact</label>
                            <select name="secondary_id" id="secondary_id" class="form-select" required>
                                <option value="{{ $contact1->id }}">{{ $contact1->name }}</option>
                                <option value="{{ $contact2->id }}" selected>{{ $contact2->name }}</option>
                            </select>
                            <div class="form-text small">This contact will be marked as merged and linked to primary.</div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4 mb-0 text-start">
                        <i class="bi bi-info-circle me-2"></i>
                        Emails and Phone numbers from the secondary contact will be appended to the primary contact if they are different. Custom fields will also be synchronized.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning px-4">Confirm & Merge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple logic to ensure primary and secondary are not the same
    $('#primary_id').on('change', function() {
        let val = $(this).val();
        let otherVal = (val == "{{ $contact1->id }}") ? "{{ $contact2->id }}" : "{{ $contact1->id }}";
        $('#secondary_id').val(otherVal);
    });
    $('#secondary_id').on('change', function() {
        let val = $(this).val();
        let otherVal = (val == "{{ $contact1->id }}") ? "{{ $contact2->id }}" : "{{ $contact1->id }}";
        $('#primary_id').val(otherVal);
    });
</script>
