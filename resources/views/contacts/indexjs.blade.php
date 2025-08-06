<script>
jQuery(function () {
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        clearErrors();
        $.ajax({
            url: '{{ route('contacts.store') }}',
            type: 'POST',
            data: formData,
            processData: false,     
            contentType: false,     
            success: function(response) {
                alert(response.message);
                $('#contactForm')[0].reset();
                var row = `<tr id="row-${response.data.id}">
                    <td><input type="checkbox" class="merge-check" value="${response.data.id}"></td>
                    <td>${response.data.name}</td>
                    <td>${response.data.email}</td>
                    <td>${response.data.phone}</td>
                    <td>${response.data.gender}</td>
                    <td class="contact-status">
                        ${response.data.is_merged && response.data.merged_into_name
                            ? `<span class="badge bg-warning">Merged into ${response.data.merged_into_name}</span>`
                            : `<span class="badge bg-success">Active</span>`
                        }
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary editBtn" data-id="${response.data.id}"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteContact(${response.data.id})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>`;
                $('#contactTableBody').append(row);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    showErrors(xhr.responseJSON.errors);
                }
            }
        });
    });
});

// EDIT
$(document).on('click', '.editBtn', function () {
    var id = $(this).data('id');
    $.get('/contacts/' + id + '/edit', function (res) {
        //console.log(res);       
        // debugger;
        $('#editModalContainer').html(res);
        $('#editModal').modal('show');
    });
});

// MERGE
$(document).on('click', '.mergeBtn', function () {
    var selected = $('.merge-check:checked');
    // console.log(selected);
    if (selected.length !== 2) {
        alert('Please select exactly 2 contacts.');
        return;
    }

    var ids = selected.map(function () { return $(this).val(); }).get();
    $.get("{{ route('contacts.merge.form') }}", {
        contact1_id: ids[0],
        contact2_id: ids[1]
    }, function (html) {
        $('#mergeModalContainer').html(html);
        $('#mergeModal').modal('show');
    });
});

// UPDATE
$(document).on('submit', '#editContactForm', function (e) {
    e.preventDefault();
    var id = $(this).find('input[name="id"]').val();
    var formData = new FormData(this);
    clearErrors();
    $.ajax({
        type: 'POST',
        url: '/contacts/update/' + id,
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            alert(res.message);
            $('#editModal').modal('hide');
            var contact = res.data;
            console.log(contact);
            var row = $(`#row-${contact.id}`);
            row.find('.contact-name').text(contact.name);
            row.find('.contact-email').text(contact.email);
            row.find('.contact-phone').text(contact.phone);
            row.find('.contact-gender').text(contact.gender);
        },
        error: function (err) {
            console.log(err);
            showErrors(err.responseJSON.errors,'#editModal');
        }
    });
});

// MERGE FORM SUBMIT
$(document).on('submit', '#mergeForm', function (e) {  
    // alert('Merge Form Submitted');
    // debugger;
    e.preventDefault();
    var formData = new FormData(this);
    clearErrors();

    if (confirm('Are you sure you want to merge these two contacts?')) {
        $.ajax({
            type: 'POST',
            url: "{{ route('contacts.merge') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                alert(res.message);
                $('#mergeModal').modal('hide');
                // Optionally wait before reload
                setTimeout(function () {
                    location.reload();
                }, 300);
            },
            error: function (err) {
                console.log(err);
                if (err.status === 422) {
                    alert(err.responseJSON.message);
                }
                // $('#mergeModal').modal('show');
            }
        });
    }
}); 

$(document).on('keyup', '#globalSearch', function (e) {
    var input = $(this).val();
    $.ajax({
        url: "{{ route('contacts.search') }}",
        type: 'GET',
        data: { filter: input },
        success: function(response) {
            // $('#contactTableBody').html('');
            $('#contactTableBody').html(response.html);
        }
    });
});

function deleteContact(id) {
    if (confirm('Delete this contact?')) {
        $.ajax({
            url: '/contacts/' + id,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(response) {
                alert(response.message);
                $('#row-' + id).remove();
            }
        });
    }
}

function showErrors(errors,container = '') {
    $.each(errors, function (key, val) {
        $(`${container} .${key}_error`).text(val[0]);
    });
}

function clearErrors() {
    $('.error-text').text('');
}
</script>
