@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
<h4>Add Custom Field</h4>
<form action="{{ route('custom-fields.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Field Name" required>
    <select name="type" required>
        <option value="text">Text</option>
        <option value="number">Number</option>
        <option value="date">Date</option>
        <option value="textarea">Textarea</option>
    </select>
    <button type="submit btn-success">Add</button>
</form>
<hr>
<h3>Existing Fields:</h3>
<table class="table table-bordered table-striped table-hover">
    <thead>
        <th>Field</th>
        <th>Field Type</th>
    </thead>
    @foreach($custom_fields as $field)
    <tr>
        <td>{{ $field->name }} </td>
        <td>{{ ucfirst($field->type) }}</td>
    </tr>
    @endforeach
</table>
@endsection