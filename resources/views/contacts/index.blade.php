@extends('layouts.app')
@section('content')
    <h2> Contacts </h2>
    <hr>
    <div class="container">
        <form id="contactForm" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    <span class="text-danger error-text name_error"></span>
                </div>
                <div class="col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    <span class="text-danger error-text email_error"></span>
                </div>
                <div class="col-md-6">
                    <label for="phone">Phone</label>
                    <input type="number" name="phone" maxlength="10" class="form-control" id="phone" placeholder="Enter mobile number" required>
                    <span class="text-danger error-text phone_error"></span>
                </div>
                <div class="col-md-6">
                    <label for="gender">Gender</label></br>
                    <label><input type="radio" name="gender" value="male"> Male</label>
                    <label><input type="radio" name="gender" value="female"> Female</label>   
                    <span class="text-danger error-text gender_error"></span> 
                </div>
                <div class="col-md-6">
                    <label for="profile_image">Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" id="profile_image">   
                    <span class="text-danger error-text profile_image_error"></span>
                </div>
                <div class="col-md-6">
                    <label for="document">Additional File</label>
                    <input type="file" name="document" class="form-control" id="additional_file">
                    <span class="text-danger error-text additional_file_error"></span>
                </div>
            </div>

            @if(isset($customFields))
            <hr>
            <h5>Custom Fields</h5>
            <div class="row form-group">
                <div class="col-md-6">
                @foreach($customFields as $field)
                    <label>{{ $field->name }}</label>
                    <input 
                        name="custom[{{ $field->id }}]" 
                        type="{{ $field->type }}" 
                        class="form-control"
                    >
                    <!-- <br> -->
                @endforeach
                </div>
            </div>
            <hr>
            @endif
            <button type="submit" class="btn btn-success">Save</button>   
        </form>
        <!-- contact list -->
        <div id="contactList">
            <div class="table-responsive">
            <input type="text" id="globalSearch" placeholder="Search contacts by Name, Email & Gender.." class="form-control mb-3" />
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <!-- <tr><div class="col-md-12"><th colspan="5"><input type="text" id="searchBox" placeholder="Search by name/email/gender"></th></div></tr> -->
                    <tr>      
                        <th></th>             
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Merge Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="contactTableBody">
                    @include('contacts.partials.table')
                </tbody>
            </table>
        </div>
        
        <!-- Edit Modal -->
        <div id="editModalContainer"></div>
        
        <!-- Merge Modal -->
        <div id="mergeModalContainer"></div>
    </div>
    @include('contacts.indexjs')
@endsection
