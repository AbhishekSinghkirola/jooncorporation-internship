<?php
include "includes/header.inc.php";

$sql = "SELECT * FROM review ORDER BY id DESC";
$res = mysqli_query($con, $sql);

$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<div class="container">
    <h1 class="text-center py-4"> Review Rating System</h1>
    <button type="button" id="create" class="btn btn-primary my-3">Create New Review</button>
    <button type="button" id="delete-all" class="btn btn-danger my-3">Delete All Records</button>
    <table id="myTable" class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="check-all"></th>
                <th>S. No.</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Rating</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        <tbody>
            <?php foreach ($data as $row) : ?>
                <?php extract(json_decode($row['contact_info'], true)); ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $email ?></td>
                    <td><?= $mobile ?></td>
                    <td><?= $row['rating'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td> <a href="#" class="edit-review" data-eid="<?= $row['id'] ?>">Edit</a> &nbsp; &nbsp; <a href="#" class="delete-review" data-id="<?= $row['id'] ?>">Delete</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </thead>

    </table>
</div>
<?php include "includes/footer.inc.php"; ?>

<script>
    $(document).ready(function() {




        // Create Review
        $('#create').on('click', function() {
            let html = `
            <form id="review-form" action="" class="row g-0">
                <div class="col-md-12 mt-3 px-3">
                    <label for="" class="form-label d-block text-start">Full Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Full Name">
                </div>
                <div class="col-md-12 mt-3 px-3">
                    <label for="" class="form-label d-block text-start">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter Email">
                </div>
                <div class="col-md-12 mt-3 px-3">
                    <label for="" class="form-label d-block text-start">Mobile</label>
                    <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile">
                </div>
                <div class="col-md-12 mt-3 px-3">
                    <label class="form-label d-block text-start">Rating</label>
                    <div class=" form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="rating1" value="1">
                        <label class="form-check-label" for="rating1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="rating2" value="2">
                        <label class="form-check-label" for="rating2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="rating3" value="3">
                        <label class="form-check-label" for="rating3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="rating4" value="4">
                        <label class="form-check-label" for="rating4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="rating5" value="5">
                        <label class="form-check-label" for="rating5">5</label>
                    </div>
                </div>
                <div class="col-md-12 mt-3 px-3 ">
                    <label class="form-label d-block text-start" for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Enter Description"></textarea>
                </div>
                <div class="col-md-12 mt-4 text-center">
                    <input type="submit" name="submit" value="Submit" class="btn btn-lg btn-success">
                </div>
            </form>
            `;
            Swal.fire({
                title: '<h1>Create Review</h1>',
                html,
                showCloseButton: true,
                showConfirmButton: false,
            })

            $('#review-form').on('submit', function(e) {
                e.preventDefault()


                const name = $('input[name=name]').val();
                const email = $('input[name=email]').val();
                const mobile = $('input[name=mobile]').val();
                const rating = parseInt($('input[name=rating]:checked').val());
                const description = $('textarea[name=description]').val();

                const type = 'add';

                $.ajax({
                    url: 'handle-review.php',
                    method: 'POST',
                    data: {
                        type,
                        name,
                        email,
                        mobile,
                        rating,
                        description,
                    },
                    success: function(response) {
                        location.reload(true)
                    }
                })
            })
        })


        // Edit Reviews
        $('.edit-review').on('click', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-eid');

            $.ajax({
                url: 'show-reviews.php',
                method: "POST",
                data: {
                    id,
                },
                success: function(response) {
                    const result = jQuery.parseJSON(response)
                    const {
                        email,
                        mobile
                    } = jQuery.parseJSON(result.contact_info)
                    let html = `
                            <form id="review-form" action="" class="row g-0">
                                <div class="col-md-12 mt-3 px-3">
                                    <label for="" class="form-label d-block text-start">Full Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Full Name" value="${result.name}">
                                </div>
                                <div class="col-md-12 mt-3 px-3">
                                    <label for="" class="form-label d-block text-start">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email" value="${email}">
                                </div>
                                <div class="col-md-12 mt-3 px-3">
                                    <label for="" class="form-label d-block text-start">Mobile</label>
                                    <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile" value="${mobile}">
                                </div>
                                <div class="col-md-12 mt-3 px-3">
                                    <label class="form-label d-block text-start">Rating</label>
                                    <div class=" form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating1" value="1" ${result.rating == 1 ? 'checked' :''}>
                                        <label class="form-check-label" for="rating1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating2" value="2"  ${result.rating == 2 ? 'checked' :''}>
                                        <label class="form-check-label" for="rating2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating3" value="3"  ${result.rating ==3 ? 'checked' :''}>
                                        <label class="form-check-label" for="rating3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating4" value="4"  ${result.rating == 4 ? 'checked' :''}>
                                        <label class="form-check-label" for="rating4">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating5" value="5"  ${result.rating == 5 ? 'checked' :''}>
                                        <label class="form-check-label" for="rating5">5</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 px-3 ">
                                    <label class="form-label d-block text-start" for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Enter Description">${result.description}</textarea>
                                </div>
                                <div class="col-md-12 mt-4 text-center">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-lg btn-success">
                                </div>
                            </form>
                        `;

                    $('input[type=radio]').on('change', function() {
                        $(this).attr('checked', true)
                    })

                    Swal.fire({
                        title: '<h1>Update Review</h1>',
                        html,
                        showCloseButton: true,
                        showConfirmButton: false,
                    })

                    const type = 'update';
                    $('#review-form').on('submit', function(e) {
                        e.preventDefault()


                        const name = $('input[name=name]').val();
                        const email = $('input[name=email]').val();
                        const mobile = $('input[name=mobile]').val();
                        const rating = parseInt($('input[name=rating]:checked').val());
                        const description = $('textarea[name=description]').val();

                        console.log(rating);
                        $.ajax({
                            url: 'handle-review.php',
                            method: 'POST',
                            data: {
                                type,
                                id,
                                name,
                                email,
                                mobile,
                                rating,
                                description,
                            },
                            success: function(response) {
                                location.reload(true)
                            }
                        })
                    })
                }
            })
        })

        // Delete Review
        $('.delete-review').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Do you want to Delete The Record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const id = $(this).attr('data-id')
                    const type = 'delete';
                    $.ajax({
                        url: 'handle-review.php',
                        method: 'POST',
                        data: {
                            type,
                            id,
                        },
                        success: function(response) {
                            if (response) {
                                // Swal.fire('Deleted!', '', 'success')
                                location.reload(true)
                            }
                        }
                    })

                }
            })


        })

        // Delete All functionality
        $('#delete-all').on('click', function() {
            let selectedRows = table.column(0).checkboxes.selected();
            let delIds = [];
            $.each(selectedRows, function(key, value) {
                delIds.push(value)
            })
            Swal.fire({
                title: 'Do you want to Delete The Record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const type = 'deleteall';
                    $.ajax({
                        url: 'handle-review.php',
                        method: 'POST',
                        data: {
                            type,
                            id: delIds,
                        },
                        success: function(response) {
                            location.reload(true)
                         
                        }
                    })

                }
            })
        })
    })
</script>