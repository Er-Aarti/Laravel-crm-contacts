<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;

class CustomFieldController extends Controller
{
    public function index()
    {
        $custom_fields = CustomField::all();
        return view('custom_fields.index', compact('custom_fields'));
    }

    public function store(Request $request)
    {
        // Validate and store the custom field
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
        ]);
        CustomField::create($request->all());
        return redirect()->back()->with('success', 'Custom field created successfully.');
    }
}
