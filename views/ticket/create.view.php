
<?php require('Views/partials/header.php') ?>
<?php require('Views/partials/nav.php') ?>
<main>
    <div class="container mt-4">
        <h4>Create a New Ticket</h4>
        <form id="CreateTicketForm" class="mt-3">
            <div class="mb-3">
            <label for="title" class="form-label">Ticket Title</label>
            <input type="text" class="form-control" id="title" name="title" required/>
            </div>

            <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <select class="form-select" id="department" name="department" required>
                <option value="IT">IT</option>
                <option value="Accounts">Accounts</option>
                <option value="Operations">Operations</option>
            </select>
            </div>

            <button type="submit" class="bg-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                Create Ticket
            </button>
        </form>
    </div>
</main>
<script>
    $('#CreateTicketForm').submit(function (e) {
        e.preventDefault(); // prevent default form submission

        const formData = {
            title: $('#title').val(),
            description: $('#description').val(),
            department: $('#department').val()
        };

        $.ajax({
            url: "http://127.0.0.1:8000/api/ticket.php",
            method: "POST",
            contentType: "application/json",
            dataType: "json",
            cache: false,
            data: JSON.stringify(formData),
            success: function(response) {
                $('#CreateTicketForm')[0].reset();
                window.location.href = '/';
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });
</script>
<?php require('Views/partials/footer.php') ?>
