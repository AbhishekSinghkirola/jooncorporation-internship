$(document).ready(function () {
  // Function to Generate Form
  function generateHTML(id = 0) {
    let data, contact_info;
    if (id) {
      const result = $.ajax({
        url: "show-reviews.php",
        method: "POST",
        data: {
          id,
        },
        global: false,
        async: false,
        success: function (response) {
          return response;
        },
      }).responseText;

      data = jQuery.parseJSON(result);

      contact_info = jQuery.parseJSON(data.contact_info);
    }

    html = `
                <form id="review-form" action="" class="row g-0">
                    <div class="col-md-12 mt-3 px-3">
                        <label for="" class="form-label d-block text-start">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Full Name" value="${
                          id ? data.name : ""
                        }" ${id ? "" : "required"}>
                    </div>
                    <div class="col-md-12 mt-3 px-3">
                        <label for="" class="form-label d-block text-start">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" value="${
                          id ? contact_info.email : ""
                        }"  ${id ? "" : "required"}>
                    </div>
                    <div class="col-md-12 mt-3 px-3">
                        <label for="" class="form-label d-block text-start">Mobile</label>
                        <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile" value="${
                          id ? contact_info.mobile : ""
                        }"  ${id ? "" : "required"}>
                    </div>
                    <div class="col-md-12 mt-3 px-3">
                        <label class="form-label d-block text-start">Rating</label>
                        <div class=" form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating1" value="1" ${
                              id ? (data.rating == 1 ? "checked" : "") : ""
                            } ${id ? "" : "required"}>
                            <label class="form-check-label" for="rating1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating2" value="2"  ${
                              id ? (data.rating == 2 ? "checked" : "") : ""
                            }>
                            <label class="form-check-label" for="rating2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating3" value="3"  ${
                              id ? (data.rating == 3 ? "checked" : "") : ""
                            }>
                            <label class="form-check-label" for="rating3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating4" value="4"  ${
                              id ? (data.rating == 4 ? "checked" : "") : ""
                            }>
                            <label class="form-check-label" for="rating4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating5" value="5"  ${
                              id ? (data.rating == 5 ? "checked" : "") : ""
                            }>
                            <label class="form-check-label" for="rating5">5</label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 px-3 ">
                        <label class="form-label d-block text-start" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description"  ${
                          id ? "" : "required"
                        }>${id ? data.description : ""}</textarea>
                    </div>
                    <div class="col-md-12 mt-4 text-center">
                        <input type="submit" name="submit" value="Submit" class="btn btn-lg btn-success">
                    </div>
                </form>
            `;

    Swal.fire({
      title: `<h1>${id ? "Update" : "Create"} Review</h1>`,
      html: html,
      showCloseButton: true,
      showConfirmButton: false,
    });
  }

  function sendRequest(type, id = 0) {
    const name = $("input[name=name]").val();
    const email = $("input[name=email]").val();
    const mobile = $("input[name=mobile]").val();
    const rating = parseInt($("input[name=rating]:checked").val());
    const description = $("textarea[name=description]").val();

    $.ajax({
      url: "handle-review.php",
      method: "POST",
      data: {
        type,
        id,
        name,
        email,
        mobile,
        rating,
        description,
      },
      success: function (response) {
        location.reload(true);
      },
    });
  }
  // Create Review
  $("#create").on("click", function () {
    generateHTML();

    $("#review-form").on("submit", function (e) {
      e.preventDefault();

      sendRequest("add");
    });
  });

  // Edit Reviews
  $(".edit-review").on("click", function () {
    const id = $(this).attr("data-eid");
    generateHTML(id);

    const type = "update";
    $(document).on("submit", "#review-form", function (e) {
      e.preventDefault();
      sendRequest("update", id);
    });
  });

  // Delete Review
  $(".delete-review").on("click", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Do you want to Delete The Record?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Delete",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        const id = $(this).attr("data-id");
        const type = "delete";
        $.ajax({
          url: "handle-review.php",
          method: "POST",
          data: {
            type,
            id,
          },
          success: function (response) {
            if (response) {
              // Swal.fire('Deleted!', '', 'success')
              location.reload(true);
            }
          },
        });
      }
    });
  });

  // Delete All functionality
  $("#delete-all").on("click", function () {
    let selectedRows = table.column(0).checkboxes.selected();
    let delIds = [];
    $.each(selectedRows, function (key, value) {
      delIds.push(value);
    });
    Swal.fire({
      title: "Do you want to Delete The Record?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Delete",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        const type = "deleteall";
        $.ajax({
          url: "handle-review.php",
          method: "POST",
          data: {
            type,
            id: delIds,
          },
          success: function (response) {
            location.reload(true);
          },
        });
      }
    });
  });
});
