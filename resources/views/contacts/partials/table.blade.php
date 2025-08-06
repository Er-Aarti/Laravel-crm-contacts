@if(count($contacts) > 0)
    @foreach($contacts as $contact)
        <tr id="row-{{ $contact->id }}">
            <td><input type="checkbox" class="merge-check" value="{{ $contact->id }}"></td>
            <td class="contact-name">{{$contact->name}}</td>
            <td class="contact-email">{{$contact->email}}</td>
            <td class="contact-phone">{{$contact->phone}}</td>    
            <td class="contact-gender">{{ ucfirst($contact->gender) }}</td>
            <td class="contact-status">
                @if($contact->is_merged && $contact->mergedInto)
                    <span class="badge bg-warning">Merged into {{ $contact->mergedInto->name }}</span>
                @else
                    <span class="badge bg-success">Active</span>
                @endif
            </td>                    
            <td>
                <a href="#" data-id="{{ $contact->id }}" class="btn btn-sm btn-primary editBtn"><i class="bi bi-pencil-square"></i></a>
                <a href="#" onclick="deleteContact({{ $contact->id }})" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
    @endforeach
    <tr colspan="7"><a href="#" class="btn btn-sm btn-warning mergeBtn" title="Merge Contact"><i class="bi bi-sign-merge-right"></i> Merge Contacts </a></tr>
@endif