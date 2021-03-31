$(document).ready(() => {
  const url = window.location.href;

  $("#my_file").on("change", function () {
    $("#btnSubmit").click();
    console.log("gg");
  });

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
          $("#alert").slideToggle().delay(2000).slideToggle();
          // setTimeout(() => {
          //   $("#alert").slideToggle();
          // }, 2000);
        }
      });
    }
  });
  $(".alert").alert();

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

  $(".fa-trash-alt").click(function () {
    const filesToDelete = itemsToDelete().length
      ? itemsToDelete()
      : [$(this).parent().siblings("th").children().text().trim()];
    $.post(url, { itemsToDelete: filesToDelete }, (_, status) => {
      if (status === "success") window.location = url;
    });
  });
  $(".fa-eye").click(function () {
    const fileName = $(this).parent().siblings("th").children().text().trim();
    $("img").each(function (_, img) {
      if (fileName === $(img).data("image-name")) {
        $(img).addClass("show").siblings().removeClass("show");
      }
    });
    $("#image").modal("show");
  });

  if (url !== "http://localhost/filemanager.php")
    $("#back").css({ display: "block" });

  $("#back").click(function () {
    let urlArray = Array.from(url);
    for (let i = url.length - 1; i > 0; i--) {
      urlArray.pop();
      if (url[i] === "/" || url[i] === "?") break;
    }
    const dist = urlArray.join("");
    window.location.href = dist;
  });
});
