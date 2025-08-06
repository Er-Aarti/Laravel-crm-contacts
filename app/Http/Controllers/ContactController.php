<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\ContactCustomField;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('mergedInto')->get();
        // dd($contacts->toArray());
        $customFields = CustomField::all();
        // dd($contacts->toArray());
        if ($request->ajax()) {
            if ($request->name) {
                $contacts->where('name', $request->name);
            }
            if ($request->email) {
                $contacts->where('email', $request->email);
            }
            if ($request->gender) {
                $contacts->where('gender', $request->gender);
            }
            $contacts = $contacts->all();
            return response()->json(view('contacts.index', compact('contacts'))->render());
        }
        $contacts = $contacts->all();
        $customFields = CustomField::all();
        view()->share('customFields',$customFields);
        return view('contacts.index', compact('contacts', 'customFields'));
    }

    public function store(Request $request)
    {
        $input= $request->except('_id', '_token');        

        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:contacts,email|max:255',        
            'phone' => 'numeric|digits:10',
            'gender' => 'required|in:male,female',   
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'document' => 'mimes:pdf,doc,docx|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle Input Files
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_images'), $filename);
            $input['profile_image'] = $filename;
        }
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $input['document'] = $filename;
        }        
       
        // Manage Custom Fields
        if (isset($input['custom'])) {
            $customFields = $input['custom'];
            unset($input['custom']);
        } else {
            $customFields = [];
        }
        $input['custom_fields'] = json_encode($customFields);
        // dd($request->custom);

        // Create the contact
        unset($input['id']);
        $contact = Contact::create($input);

        ContactCustomField::where('contact_id', $contact->id)->delete();
        if ($request->custom) {
            foreach ($request->custom as $fieldId => $value) {
                ContactCustomField::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $fieldId,
                    'value' => $value
                ]);
            }
        }
        
        if ($contact) {            
            return response()->json(['success' => true, 'message'=>'Contact Created.','data' => $contact]);
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to create contact.'], 500);
            }
            return redirect()->back()->with('error', 'Failed to create contact.');  
        }
    }

    public function edit($id)
    {
        // dd($id);
        $contact = Contact::with(['customFieldValues'])->findOrFail($id);
        $contact->custom_fields = $contact->customFieldValues
            ->pluck('value', 'custom_field_id')
            ->toArray();

        $customFields = CustomField::all();
        
        return view('contacts.partials.edit', compact(['contact', 'customFields']))->render();
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $contact = Contact::findOrFail($id);
        $input = $request->all();

        // $emails = array_filter(array_map('trim', explode(',', $request->email)));
        $phones = array_filter(array_map('trim', explode(',', $request->phone)));
        $emails = array_filter(array_map('trim', explode(',', $request->email)));

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            // 'email' => 'email|max:255|unique:contacts,email,'.$id,
            // 'phone' => 'numeric|digits:10',
            'gender' => 'required|in:male,female',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);
        $validator->after(function ($validator) use ($emails) {
            foreach ($emails as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validator->errors()->add('email', "Invalid email: $email");
                }
            }
        });
        $validator->after(function ($validator) use ($phones) {            
            foreach ($phones as $phone) {
                if (!preg_match('/^\d{10}$/', $phone)) {
                    $validator->errors()->add('phone', "Invalid phone number: $phone");
                }
            }
        });
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile_images'), $filename);
            $input['profile_image'] = $filename;
        }
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents'), $filename);
            $input['document'] = $filename;
        }

        $input['email'] = implode(',', $emails);
        $input['phone'] = implode(',', $phones);
        $contact->update($input);

        ContactCustomField::where('contact_id', $contact->id)->delete();
        if ($request->custom) {
            foreach ($request->custom as $fieldId => $value) {
                ContactCustomField::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $fieldId,
                    'value' => $value
                ]);
            }
        }
        return response()->json(['success' => true, 'message'=> 'Contact updated successfully.', 'data' => $contact]);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        ContactCustomField::where('contact_id', $contact->id)->delete();
        $contact->delete();
        return response()->json(['success' => true, 'message'=>'Contact deleted successfully.']);
    }   
    public function search(Request $request)
    {
        $data = $request->input('filter');
        $contacts = Contact::where('name', 'like', "%$data%")
            ->orWhere('email', 'like', "%$data%")
            ->orWhere('phone', 'like', "%$data%")
            ->orWhere('gender', 'like', "%$data%")
            ->get();
            
        return response()->json([
            'html' => view('contacts.partials.table', compact('contacts'))->render()
        ]);
    }
    public function mergeForm(Request $request)
    {
        $contact1 = Contact::with('customFieldValues.customField')->find($request->contact1_id);
        $contact2 = Contact::with('customFieldValues.customField')->find($request->contact2_id);

        $contact1_arr = $contact2_arr = [];
        foreach ($contact1->customFieldValues as $value) {
            $contact1_arr[$value->customField->name] = $value->value;
        }
        foreach ($contact2->customFieldValues as $value) {
            $contact2_arr[$value->customField->name] = $value->value;
        }
        $contact1->custom_fields = $contact1_arr; 
        $contact2->custom_fields = $contact2_arr; 
        
        $customFields = CustomField::all();

        // dd($contact1, $contact2);
        return view('contacts.partials.merge', compact('contact1', 'contact2','customFields'))->render();
    }
    public function merge(Request $request)
    {
        // dd($request->all());
        $primary = Contact::with('customFieldValues.customField')->find($request->primary_id);
        $secondary = Contact::with('customFieldValues.customField')->find($request->secondary_id);
        if ($primary->id == $secondary->id) {
            return response()->json(['message' => 'Cannot merge the same contact!'], 422);
        }

        if ($secondary->email && $secondary->email != $primary->email) {
            $emails = explode(',', $primary->email);
            $secondaryEmails = explode(',', $secondary->email ?? '');
            $allEmails = array_unique(array_map('trim', array_merge($emails, $secondaryEmails)));
            $primary->email = implode(', ', $allEmails);
        }
        if ($secondary->phone && $secondary->phone != $primary->phone) {            
            $phones = explode(',', $primary->phone);
            $secondaryPhones = explode(',', $secondary->phone ?? '');
            $allPhones = array_unique(array_map('trim', array_merge($phones, $secondaryPhones)));
            $primary->phone = implode(', ', $allPhones);
        }
        $primary->save();
        // dd($primary, $secondary);

        // Merge custom fields
        foreach ($secondary->customFieldValues as $secFieldValue) {
            $fieldId = $secFieldValue->custom_field_id;
            $existing = $primary->customFieldValues->firstWhere('custom_field_id', $fieldId);

            if (!$existing) {
                // If not exists, re-assign this value to primary contact
                $secFieldValue->contact_id = $primary->id;
                $secFieldValue->save(); // Moves it from secondary to primary
            } elseif ($existing->value !== $secFieldValue->value) {
                // If same field but different value, optionally append
                $existing->value .= ', ' . $secFieldValue->value;
                $existing->save();
            }
        }
        
        $secondary->is_merged = true;
        $secondary->merged_into_id = $primary->id;
        // $secondary->status = 'merged';
        $secondary->save();

        return response()->json(['success' => true, 'message'=>'Contacts merged successfully.', 'data' => [
            'primary' => $primary,
            'secondary' => $secondary
        ]]);
    }
}
