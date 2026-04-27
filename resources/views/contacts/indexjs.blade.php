@push('scripts')
<script>
jQuery(function ($) {
    // CSRF Token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Dashboard Tab Persistence
    $('#dashboardTabs button').on('shown.bs.tab', function (e) {
        localStorage.setItem('activeDashboardTab', $(e.target).attr('data-bs-target'));
    });

    var activeTab = localStorage.getItem('activeDashboardTab');
    if (activeTab) {
        $(`#dashboardTabs button[data-bs-target="${activeTab}"]`).tab('show');
    }

    // Handle Select All checkbox
    $('#selectAll').on('change', function() {
        $('.merge-check').prop('checked', $(this).prop('checked'));
    });

    // STORE CONTACT
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<span class="spinner-border  spinner-border-sm me-2"></span>Saving...');

        clearErrors();
        $.ajax({
            url: '{{ route('contacts.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Contact Saved',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });

                $('#addContactModal').modal('hide');
                $('#contactForm')[0].reset();
                refreshTable();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    showErrors(xhr.responseJSON.errors);
                } else {
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('Save Contact');
            }
        });
    });

    // EDIT CONTACT
    $(document).on('click', '.editBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var originalHtml = $(this).html();
        $(this).html('<span class="spinner-border spinner-border-sm"></span>');

        $.get('/contacts/' + id + '/edit', function (res) {
            $('#editModalContainer').html(res);
            $('#editModal').modal('show');
            $('.editBtn[data-id="' + id + '"]').html(originalHtml);
        });
    });

    // UPDATE CONTACT
    $(document).on('submit', '#editContactForm', function (e) {
        e.preventDefault();
        var id = $(this).find('input[name="id"]').val();
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');

        clearErrors();
        $.ajax({
            type: 'POST',
            url: '/contacts/update/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Update Complete',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
                $('#editModal').modal('hide');
                refreshTable();
            },
            error: function (err) {
                if (err.status === 422) {
                    showErrors(err.responseJSON.errors, '#editModal');
                } else {
                    Swal.fire('Error', 'Failed to update contact.', 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('Save Changes');
            }
        });
    });

    // SEARCH (DEBOUNCED)
    let searchTimer;
    $('#globalSearch').on('input', function () {
        clearTimeout(searchTimer);
        let query = $(this).val();
        searchTimer = setTimeout(function() {
            $.ajax({
                url: "{{ route('contacts.search') }}",
                type: 'GET',
                data: { filter: query },
                success: function(response) {
                    $('#contactTableBody').html(response.html);
                }
            });
        }, 300);
    });

    // MERGE ACTION
    $(document).on('click', '.mergeBtn', function () {
        var selected = $('.merge-check:checked');
        if (selected.length !== 2) {
            Swal.fire({
                title: 'Invalid Selection',
                text: 'Select exactly 2 contacts to merge.',
                icon: 'info',
                confirmButtonColor: '#4f46e5'
            });
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

    // MERGE SUBMIT
    $(document).on('submit', '#mergeForm', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        Swal.fire({
            title: 'Confirm Merge Operation',
            text: "This will consolidate contact data. Continue?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, merge data'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('contacts.merge') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        Swal.fire('Merged!', res.message, 'success');
                        $('#mergeModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function (err) {
                        if (err.status === 422) {
                            Swal.fire('Operation Blocked', err.responseJSON.message, 'error');
                        }
                    }
                });
            }
        });
    });
});

function deleteContact(id) {
    Swal.fire({
        title: 'Delete Contact?',
        text: "This action will permanently remove the contact record.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Permanently Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/contacts/delete/' + id,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    $('#row-' + id).fadeOut(300, function() { $(this).remove(); });
                },
                error: function() {
                    Swal.fire('Error', 'Deletion failed. Contact may already be removed.', 'error');
                }
            });
        }
    });
}

function refreshTable() {
    let query = $('#globalSearch').val();
    $.ajax({
        url: "{{ route('contacts.search') }}",
        type: 'GET',
        data: { filter: query },
        success: function(response) {
            $('#contactTableBody').html(response.html);
        }
    });
}

function showErrors(errors, container = '') {
    $('.error-text').text('');
    $.each(errors, function (key, val) {
        $(`${container} .${key}_error`).text(val[0]);
    });
}

function clearErrors() {
    $('.error-text').text('');
}
</script>
@endpush
