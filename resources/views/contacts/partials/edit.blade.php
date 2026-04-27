<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <form id="editContactForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $contact->id }}">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $contact->name }}" required>
                            <span class="text-danger small error-text name_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Email Address</label>
                            <input type="text" name="email" class="form-control" value="{{ $contact->email }}" required placeholder="Separate multiple emails with commas">
                            <span class="text-danger small error-text email_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}" required placeholder="Separate multiple phones with commas">
                            <span class="text-danger small error-text phone_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium d-block">Gender</label>
                            <div class="d-flex gap-3 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="male" id="editGenderMale" {{ strtolower($contact->gender) === 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editGenderMale">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="female" id="editGenderFemale" {{ strtolower($contact->gender) === 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editGenderFemale">Female</label>
                                </div>
                            </div>
                            <span class="text-danger small error-text gender_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Profile Image</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($contact->profile_image)
                                    <img src="{{ asset('uploads/profile_images/' . $contact->profile_image) }}" width="50" height="50" class="rounded border">
                                @endif
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                            <span class="text-danger small error-text profile_image_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Additional Document</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($contact->document)
                                    <a href="{{ asset('uploads/documents/' . $contact->document) }}" target="_blank" class="btn btn-sm btn-light"><i class="bi bi-file-earmark-text me-1"></i>View Current</a>
                                @endif
                                <input type="file" name="document" class="form-control">
                            </div>
                            <span class="text-danger small error-text document_error"></span>
                        </div>
                    </div>

                    @if(isset($customFields) && count($customFields) > 0)
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3 text-primary">Custom Fields</h6>
                        <div class="row g-3">
                            @foreach($customFields as $field)
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ $field->name }}</label>
                                    @if($field->type == 'textarea')
                                        <textarea name="custom[{{ $field->id }}]" class="form-control" rows="2">{{ $contact->custom_fields[$field->id] ?? '' }}</textarea>
                                    @else
                                        <input name="custom[{{ $field->id }}]" type="{{ $field->type }}" class="form-control" value="{{ $contact->custom_fields[$field->id] ?? '' }}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>