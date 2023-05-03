<?php include "includes/header.inc.php"; ?>
<div class="container">
    <h1 class="text-center pt-4"> Add Form</h1>
    <form id="review-form" action="" class="row g-0">
        <div class="col-md-6 mt-3 px-3">
            <label for="" class="form-label ">Full Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Full Name">
        </div>
        <div class="col-md-6 mt-3 px-3">
            <label for="" class="form-label ">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email">
        </div>
        <div class="col-md-6 mt-3 px-3">
            <label for="" class="form-label ">Mobile</label>
            <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile">
        </div>
        <div class="col-md-6 mt-3 px-3">
            <label class="form-label d-block">Rating</label>
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
        <div class="col-md-12 mt-3 px-3">
            <label class="form-label " for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter Description"></textarea>
        </div>
        <div class="col-md-12 mt-4 text-center">
            <input type="submit" name="submit" value="Submit" class="btn btn-lg btn-primary">
        </div>
    </form>
</div>
<?php include "includes/footer.inc.php"; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#review-form').on('submit', function(e) {
            e.preventDefault();

            const name = $('input[name=name').val();
            const email = $('input[name=email').val();
            const mobile = $('input[name=mobile').val();
            const rating = parseInt($('input[name=rating').val());
            const description = $('textarea[name=description').val();

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
                }
            })
        })
    })
</script>