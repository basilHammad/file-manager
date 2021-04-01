$(document).ready(() => {
  const url = window.location.href;
  // post upload file
  $("#file-to-upload").on("change", function () {
    $("#btnSubmit").click();
  });

  // post create file
  $("#create-folder").click(function (e) {
    e.preventDefault();
    const value = $("#create-folder-input").val();
    $("#create-folder-input").removeClass("is-invalid");
    if (
      value.trim() === "" ||
      value.trim() === "." ||
      value.trim() === ".." ||
      value.trim() === "/"
    ) {
      $("#create-folder-input").addClass("is-invalid");
    } else {
      $.post(url, { "create-folder": value }, function (data, status) {
        if (JSON.parse(data)) {
          window.location = url;
        } else {
          $("#create-alert").slideToggle().delay(2000).slideToggle();
        }
      });
    }
  });

  // handle check all checkboxes
  $("#selectAll").change(function () {
    if (this.checked) {
      $(".select").prop("checked", true);
    } else {
      $(".select").prop("checked", false);
    }
  });

  // collect the value from the checked boxes
  function itemsToDelete() {
    const checkBoxesValue = [];
    $(".select:checked").each(function () {
      checkBoxesValue.push($(this).val());
    });
    return checkBoxesValue;
  }

  // post the files to delete them
  $(".fa-trash-alt").click(function () {
    const filesToDelete = itemsToDelete().length
      ? itemsToDelete()
      : [$(this).parent().siblings("th").children().text().trim()];
    $.post(url, { itemsToDelete: filesToDelete }, (_, status) => {
      if (status === "success") window.location = url;
    });
  });

  // preview imges handler
  $(".fa-eye").click(function () {
    const fileName = $(this).parent().siblings("th").children().text().trim();
    $("img").each(function (_, img) {
      if (fileName === $(img).data("image-name")) {
        $(img).addClass("show").siblings().removeClass("show");
      }
    });
    $("#image").modal("show");
  });

  // showing the back btn
  if (url !== "http://localhost/filemanager.php")
    $("#back").css({ display: "block" });

  // handling the back btn
  $("#back").click(function () {
    const urlArray = Array.from(url);
    for (let i = url.length - 1; i > 0; i--) {
      urlArray.pop();
      if (url[i] === "/" || url[i] === "?") break;
    }
    const dist = urlArray.join("");
    window.location.href = dist;
  });
});
