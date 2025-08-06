<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
    <div class="modal-content">
        <form id="editContactForm" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $contact->id }}">
            <div class="modal-header">
                <h5 class="modal-title">Edit Contact</h5>                
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $contact->name }}">
                    <span class="text-danger error-text name_error"></span>
                </div>
                <div class="mb-2">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="form-control" value="{{ $contact->email }}">
                    <span class="text-danger error-text email_error"></span>
                </div>
                <div class="mb-2">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}">
                    <span class="text-danger error-text phone_error"></span>
                </div>
                <div class="mb-2">
                    <label for="gender">Gender:</label></br>
                    <label><input type="radio" name="gender" value="male" {{ $contact->gender === 'Male' ? 'checked' : '' }}> Male </label>
                    <label><input type="radio" name="gender" value="female" {{ $contact->gender === 'Female' ? 'checked' : '' }}> Female </label>
                    <span class="text-danger error-text gender_error"></span>
                </div>
                <div class="mb-2">
                    <label>Profile Image:</label><br>
                    @if($contact->profile_image)
                        <img src="{{asset('uploads/profile_images/' . $contact->profile_image)}}" width="80" height="80" class="rounded mb-1" />
                    @endif
                    <input type="file" name="profile_image" class="form-control">
                    <span class="text-danger error-text profile_image_error"></span>
                </div>
                <div class="mb-2">
                    <label>Document:</label><br>
                    @if($contact->document)
                        <a href="{{ asset('uploads/documents/' . $contact->document) }}" target="_blank">View Doc.</a><br>
                    @endif
                    <input type="file" name="document" class="form-control">
                    <span class="text-danger error-text document_error"></span>
                </div>
            </div>
            @if(isset($customFields))  
            <hr>
            <h5>Custom Fields</h5>  
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-6">
                        <!-- @dump($contact->custom_fields); -->
                        @foreach($customFields as $field)
                            <label>{{ $field->name }}</label>
                            <input 
                                name="custom[{{ $field->id }}]" 
                                type="{{ $field->type }}" 
                                class="form-control"
                                value="{{ $contact->custom_fields[$field->id] ?? '' }}"
                            >
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <div class="modal-footer">
                <button class="btn btn-success" id="editContactForm">Update</button>
            </div>
        </form>
    </div>
</div>
</div>