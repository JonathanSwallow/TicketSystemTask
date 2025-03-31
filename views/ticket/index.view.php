
<?php require('Views/partials/header.php') ?>
<?php require('Views/partials/nav.php') ?>
<main>
    <div class="container py-4">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th class="text-center">Title</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Department</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Created At</th>
                    <th class="text-center">Replies</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody id="tickets-list-body">
            </tbody>
        </table>
    </div>
</main>

<script>
    const tableBody = $("#tickets-list-body");
    $(document).ready(function () {
        fetchTickets()
        .done(function (response) {
            renderTickets(response.data);
        });
    });

    function fetchTickets() {
        return $.ajax({
            url: "http://127.0.0.1:8000/api/ticket.php",
            method: "GET",
            dataType: "json",
            cache:false
        });
    }

    function renderTickets(tickets) {
        tableBody.empty();
        tickets.forEach(ticket => {
                const row = $(`
                <tr data-ticket-id="${ticket.id}" style="cursor:pointer;">
                    <td>${ticket.title}</td>
                    <td>${ticket.description}</td>
                    <td class="text-center">${ticket.department}</td>
                    <td class="text-center">${ticket.status}</td>
                    <td class="text-center">${ticket.created_at}</td>
                    <td></td>
                    <td class="px-4 py-2 text-center">
                        <button class="delete-btn text-red-600 hover:text-red-800 font-medium">
                            Delete
                        </button>
                    </td>
                </tr>
            `);
            row.find('.delete-btn').on('click', function(event) {
                event.stopPropagation();
                deleteTicket(row, ticket.id);
            });
            row.on('click', function() {
                viewTicket(ticket.id);
            });

            tableBody.append(row);
        });
    }

    function deleteTicket(row, id) {
        if (confirm('Are you sure you want to delete this ticket?')) {
            $.ajax({
                url: `http://127.0.0.1:8000/api/ticket.php?id=${id}`,
                method: "DELETE",
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    row.remove();
                }
            });
        }
    }
    function viewTicket(id) {
        window.location.href = `/show_ticket?id=${id}`;
    }

</script>

<?php require('Views/partials/footer.php') ?>
