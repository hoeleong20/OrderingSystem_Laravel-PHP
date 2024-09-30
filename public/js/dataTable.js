$(document).ready(function () {
    const dataTableConfig = {
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "pageLength": 10,
        'columnDefs': [
            {
                "targets": 7,
                "width": "40%"
            },
            {
                "targets": 10,
                "width": "20%",
                "className": "text-center",
            },
            {
                "targets": '_all',
                "className": "align-top"
            }
        ]
    }

    $('#discountTable').DataTable(dataTableConfig);

    const page = 'admin/discount'
    $(document).on('click', '.btn-view', function () {
        const id = $(this).data('id');

        $.ajax({
            url: `/${page}/${id}/view`,
            method: 'GET',
            success: function (response) {
                // Populate the modal with the form
                $('#viewForm').html(response);

                showModal('viewModal');
            },
            error: function () {
                alert('Failed to load form.');
            }
        });
    });

    $(document).on('click', '.btn-create', function () {
        $.ajax({
            url: `/${page}/create`,
            method: 'GET',
            success: function (response) {
                $('#createForm').html(response);

                showModal('createModal');
            },
            error: function () {
                alert('Failed to load form.');
            }
        });
    });

    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');

        $.ajax({
            url: `/${page}/${id}/edit`,
            method: 'GET',
            success: function (response) {
                // Populate the modal with the form
                $('#editForm').html(response);

                showModal('editModal');
            },
            error: function () {
                alert('Failed to load form.');
            }
        });
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();

        const id = $(this).data('id');

        // Set the action URL for the confirmation form
        $('#deleteConfirmationForm').attr('action', `/${page}/${id}`);
        showModal('deleteConfirmationModal');
    });

    $(document).on('click', '.btn-activate', function (e) {
        e.preventDefault();

        const id = $(this).data('id');

        // Set the action URL for the confirmation form
        $('#activateConfirmationForm').attr('action', `/${page}/${id}/activate`);
        showModal('activateConfirmationModal');
    });


    function initFormCloseAction() {
        formClose('#viewModal');
        formClose('#createModal');
        formClose('#editModal');
    }

    function formClose(modal) {
        $(document).on('hidden.bs.modal', modal, function () {
            $(this).find('form').remove();
        });
    }

    initFormCloseAction();

    $(document).on('submit', '#createForm form', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                submitSuccessAction(response, 'createModal');
            },
            error: function (xhr) {
                submitErrorAction(xhr, 'create');
            }
        });
    });

    $(document).on('submit', '#editForm form', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'PATCH',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                submitSuccessAction(response, 'editModal');
            },
            error: function (xhr) {
                submitErrorAction(xhr, 'edit');
            }
        });
    });

    $(document).on('submit', '#deleteConfirmationForm', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'DELETE',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                submitSuccessAction(response, 'deleteConfirmationModal');
            },
            error: function (xhr) {
                submitErrorAction(xhr, 'delete');
            }
        });
    });

    $(document).on('submit', '#activateConfirmationForm', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'PATCH',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                submitSuccessAction(response, 'activateConfirmationModal');
            },
            error: function (xhr) {
                submitErrorAction(xhr, 'activate');
            }
        });
    });

    function showModal(modalId) {
        const modal = new bootstrap.Modal(document.getElementById(modalId), { keyboard: false });
        modal.show();

        // check if can find add criteria button
        const addCriteriaButton = document.getElementById('addCriteriaButton');
        if (addCriteriaButton) {
            addCriteriaButton.addEventListener('click', addCriteria);
        }
    }

    function hideModal(modalId) {
        const modal = new bootstrap.Modal(document.getElementById(modalId), { keyboard: false });
        modal.hide();
    }

    function submitSuccessAction(response, modalId) {
        hideModal(modalId);
        alert(response.message);
        location.reload();
    }

    function submitErrorAction(xhr, operation) {
        if (xhr.status === 422) {
            let errorMessage = '';
            const errors = xhr.responseJSON.errors;
            $.each(errors, function (field, messages) {
                errorMessage += field + ': ' + messages.join(', ') + '\n';
            });

            alert(errorMessage);
            return;
        }

        alert(`Failed to ${operation}. Please try again later.`);
    }
});

// Function to update criteria inputs based on selection
function updateCriteriaInputs(selectElement) {
    // Use nextElementSibling to get the next sibling that is an element
    const criteriaInputs = selectElement.nextElementSibling;
    const selectedValue = selectElement.value;

    // Clear previous inputs
    criteriaInputs.innerHTML = '';

    if (selectedValue === 'new_user') {
        criteriaInputs.insertAdjacentHTML('beforeend', `
            <div class="col-md-7">
                <input type="number" name="newUserDay[]" class="form-control" required="true" min="1"/>
            </div>

            <div class="col-md-3">
                <select name="newUserTimeUnit[]" class="form-control">
                    <option value="days">Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>
            
            <input type="hidden" name="conditions[]" />
        `);
    } else if (selectedValue === 'min_purchase') {
        criteriaInputs.insertAdjacentHTML('beforeend', `            
            <div class="col-md-10">                
                <div class="input-group">
                    <span class="input-group-text">> RM</span>
                    <input type="text" name="conditions[]" class="form-control" required="true" min="0" />
                </div>
            </div>
        `);
    }

    // Append the remove button
    criteriaInputs.insertAdjacentHTML('beforeend', `
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-block" onclick="removeCriteria(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `);
}



// Function to remove criteria
function removeCriteria(buttonElement) {
    const criteriaContainer = buttonElement.closest('.criteria');
    criteriaContainer.remove();
}

function addCriteria() {
    const criteriaContainer = document.getElementById('criteriaContainer');

    const newCriteriaHTML = `
            <div class="criteria">
                <select name="criteriaNames[]" class="form-control criteria-select" onchange="updateCriteriaInputs(this)">
                    <option value="new_user">New User</option>
                    <option value="min_purchase">Min Purchase</option>
                </select>

                <div class="criteria-inputs row" style="margin-top:5px;">
                    <div class="col-md-7">
                        <input type="number" name="newUserDay[]" class="form-control" required="true" min="1"/>
                    </div>

                    <div class="col-md-3">
                        <select name="newUserTimeUnit[]" class="form-control">
                            <option value="days">Days</option>
                            <option value="months">Months</option>
                            <option value="years">Years</option>
                        </select>
                    </div>
                    
                    <input type="hidden" name="conditions[]" />
                    
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-block" onclick="removeCriteria(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div><br/>
            </div>
        `;

    criteriaContainer.insertAdjacentHTML('beforeend', newCriteriaHTML);
}

// Function to update the discount value input based on type
function updateDiscountValueInput() {
    const discountType = document.getElementById('discount_type').value;

    if (discountType === 'percentage') {
        document.getElementById('discount_prefix').style.display = 'none';
        document.getElementById('discount_suffix').style.display = 'block';
    } else {
        document.getElementById('discount_prefix').style.display = 'block';
        document.getElementById('discount_suffix').style.display = 'none';
    }
}

function mergeFormInput() {
    event.preventDefault();
    const newUserDay = document.getElementsByName('newUserDay[]');

    newUserDay.forEach((element) => {
        const newUserTimeUnit = element.parentNode.nextElementSibling.children[0];

        const mergedDate = element.value + ' ' + newUserTimeUnit.value;
        const hiddenInput = newUserTimeUnit.parentNode.nextElementSibling;
        hiddenInput.value = mergedDate;
    });
}