<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-hidden="true" aria-labelledby="addContactModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="contactForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addContactModalLabel">Create New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required aria-required="true">
                            <span class="text-danger small error-text name_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com" required aria-required="true">
                            <span class="text-danger small error-text email_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" maxlength="10" class="form-control" placeholder="10-digit mobile number" required aria-required="true">
                            <span class="text-danger small error-text phone_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">Gender Selection</label>
                            <div class="btn-group w-100" role="group" aria-label="Gender selection toggle">
                                <input type="radio" class="btn-check" name="gender" id="genderMale" value="male" checked autocomplete="off">
                                <label class="btn btn-outline-light text-dark border py-2" for="genderMale"><i class="bi bi-gender-male me-2"></i>Male</label>

                                <input type="radio" class="btn-check" name="gender" id="genderFemale" value="female" autocomplete="off">
                                <label class="btn btn-outline-light text-dark border py-2" for="genderFemale"><i class="bi bi-gender-female me-2"></i>Female</label>
                            </div>
                            <span class="text-danger small error-text gender_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Profile Picture</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                            <span class="text-danger small error-text profile_image_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Additional Document</label>
                            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
                            <span class="text-danger small error-text additional_file_error"></span>
                        </div>
                    </div>

                    @if(isset($customFields) && count($customFields) > 0)
                    <div class="mt-5 pt-4 border-top">
                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-plus-circle-fill me-2"></i>Custom attributes</h6>
                        <div class="row g-4">
                            @foreach($customFields as $field)
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ $field->name }}</label>
                                    @if($field->type == 'textarea')
                                        <textarea name="custom[{{ $field->id }}]" class="form-control" rows="2" placeholder="Enter {{ strtolower($field->name) }}..."></textarea>
                                    @else
                                        <input name="custom[{{ $field->id }}]" type="{{ $field->type }}" class="form-control" placeholder="Enter {{ strtolower($field->name) }}...">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary px-5">Save Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>
