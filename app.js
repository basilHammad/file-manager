$(document).ready(() => {
  $("#my_file").on("change", function () {
    $("#btnSubmit").click();
  });

  $("#selectAll").change(function () {
    if (this.checked) {
      $(".select").prop("checked", true);
    } else {
      $(".select").prop("checked", false);
    }
  });

  function itemsToDelete() {
    const checkBoxesValue = [];
    $(".select:checked").each(function () {
      checkBoxesValue.push($(this).val());
    });
    return checkBoxesValue;
  }

  // $(".fa-trash-alt").click(function () {
  //   $.ajax({
  //     type: "POST",
  //     url: "filemanager.php",
  //     data: `items-to-delete = ${itemsToDelete()}`,
  //     success: function () {
  //       alert("gg");
  //     },
  //   });
  // });

  $(".fa-trash-alt").click(function () {
    const x = JSON.stringify(itemsToDelete());
    $.post("http://localhost/filemanager.php", { itemsToDelete: x });
  });

  $(".fa-trash-alt").click(function () {
    const x = JSON.stringify(itemsToDelete());
    $.ajax({
      url: "filemanager.php",
      type: "POST",
      ContentType: "application/json",
      data: { itemsToDelete: x },
    })
      .done(function (response) {
        alert("success");
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("FAILED! ERROR: " + errorThrown);
      });
    // $.ajax({
    //   type: "POST",
    //   url: "filemanager.php",
    //   data: { itemsToDelete: x },
    //   contentType: "application/json",
    //   success: function (msg) {
    //     alert(msg);
    //   },
    //   error: function (err) {
    //     alert(err.responseText);
    //   },
    // });
  });
});
