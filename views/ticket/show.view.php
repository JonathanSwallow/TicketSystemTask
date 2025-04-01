<?php require('Views/partials/header.php') ?>
<?php require('Views/partials/nav.php') ?>

<main class="container py-4">
    <h4 class="mb-4">Show Ticket</h4>

    <form id="UpdateTicketForm">
        <div class="mb-3">
            <label for="title" class="form-label">Ticket Title</label>
            <input type="text" class="form-control" id="title" name="title" required />
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

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Open">Open</option>
                <option value="Closed">Closed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
    </form>

    <div class="mt-5">
        <h4 class="text-center">Replies</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody id="replies-list-body">
                </tbody>
            </table>
        </div>
        <form id="CreateReplyForm">
            <div class="row">
                <div class="col-6">
                    <label for="title" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
                <div class="col-6">
                    <label for="description" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="1" required></textarea>
                </div>
            </div>
            <div class="row mt-4">
                <button type="submit" class="btn btn-warning">Reply</button>
            </div>
        </form>
    </div>
</main>

<script>
    let params = new URLSearchParams(window.location.search);
    let ticketId = params.get('id');
    const repliesBody = $("#replies-list-body");

    $(document).ready(function() {
        fetchTicket();
    });

    $('#UpdateTicketForm').submit(function (e) {
        e.preventDefault();

        const formData = {
            title: $('#title').val(),
            description: $('#description').val(),
            department: $('#department').val(),
            status: $('#status').val()
        };

        $.ajax({
            url: `http://127.0.0.1:8000/api/ticket.php?id=${ticketId}`,
            method: "PUT",
            contentType: "application/json",
            dataType: "json",
            cache: false,
            data: JSON.stringify(formData),
            success: function(response) {
                alert("Ticket updated successfully.");
                fetchTicket();
            },
            error: function() {
                alert("Error updating ticket.");
            }
        });
    });

    function fetchTicket() {
        $.ajax({
            url: `http://127.0.0.1:8000/api/ticket.php?id=${ticketId}`,
            method: "GET",
            dataType: "json",
            success: function(response) {
                fillForm(response.data);
                fetchReplies(response.data.id);
            }
        });
    }

    function fillForm(ticket) {
        $('#title').val(ticket.title);
        $('#description').val(ticket.description);
        $('#department').val(ticket.department);
        $('#status').val(ticket.status);
    }

    function fetchReplies(id) {
        $.ajax({
            url: `http://127.0.0.1:8000/api/reply.php?id=${id}`,
            method: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response);
                renderReplies(response.data);
            }
        });
    }


    function renderReplies(replies) {
        repliesBody.empty();
        replies.forEach(reply => {
            renderReply(reply)
        });
    }

    function renderReply(reply) {
        const row = $(`
            <tr>
                <td>${reply.name}</td>
                <td>${reply.message}</td>
            </tr>
        `);
        repliesBody.append(row);
    }

    $('#CreateReplyForm').submit(function (e) {
            e.preventDefault();

            const formData = {
                name: $('#name').val(),
                message: $('#message').val(),
                ticket_id: ticketId,
            };

            $.ajax({
                url: "http://127.0.0.1:8000/api/reply.php",
                method: "POST",
                contentType: "application/json",
                dataType: "json",
                cache: false,
                data: JSON.stringify(formData),
                success: function(response) {
                    $('#CreateReplyForm')[0].reset();
                    renderReply(response.data);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });
</script>

<?php require('Views/partials/footer.php') ?>
