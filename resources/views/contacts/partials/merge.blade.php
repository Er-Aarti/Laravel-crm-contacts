<div class="modal fade" id="mergeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="mergeModalContent">
            <div class="modal-header">
                <h5 class="modal-title">Merge Contact</h5>                
            </div>
            <form id="mergeForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Select Primary Contact:</label>
                        <select name="primary_id" id="primary_id" class="form-control" required>
                            <option value="{{ $contact1->id }}">{{ $contact1->name }}</option>
                            <option value="{{ $contact2->id }}">{{ $contact2->name }}</option>
                        </select>
                    </div>
                    <div class="mb-2">    
                        <label>Select Secondary Contact:</label>
                        <select name="secondary_id" id="secondary_id" class="form-control" required>
                            <option value="{{ $contact1->id }}">{{ $contact1->name }}</option>
                            <option value="{{ $contact2->id }}">{{ $contact2->name }}</option>
                        </select>
                    </div>
                    <!-- Merge into this contact (master_id) -->
                    <div class="mb-2">
                        <label>Merge into:</label>
                        <select name="master_id" class="form-control" required>
                            <option value="{{ $contact1->id }}" selected>{{ $contact1->name }}</option>
                            <option value="{{ $contact2->id }}">{{ $contact2->name }}</option>
                        </select>
                    </div>
                    <!-- <div class="mb-2">
                        <label>Merge Custom Fields:</label>                       
                            @foreach($contact1->custom_fields as $field_ky=>$field)                                
                                <li>{{ $field_ky }}: {{ $field ?? 'N/A' }} (Primary Contact)</li>                               
                            @endforeach
                            //dd($contact1);                               
                    </div> -->
                    <!-- <button type="submit" class="btn btn-success mergeForm">Confirm Merge</button> -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="mergeForm">Merge</button>
                </div>
            </form>
        </div>
    </div>
</div>

