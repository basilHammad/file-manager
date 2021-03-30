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
});
