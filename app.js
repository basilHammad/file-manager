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
          $("#create-alert").addClass("slide");
          setTimeout(() => {
            $("#create-alert").removeClass("slide");
          }, 2000);
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

  if (document.querySelector(".main-form")) {
    const form = document.querySelector(".main-form");
    form.addEventListener("submit", (e) => {
      if (form.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        form.classList.add("was-validated");
      }
    });
  }

  // preview imges handler
  $(".fa-eye").click(function () {
    const fileName = $(this).parent().siblings("th").children().text().trim();
    // console.log(fileName);
    $("img,video").each(function (_, item) {
      console.log($(item).data("item-name"));
      if (fileName === $(item).data("item-name")) {
        $(item).addClass("show").siblings().removeClass("show");
      }
    });
    $("#image").modal("show");
  });

  // showing the back btn
  if (url !== "http://localhost/filemanger/index.php?page=filemanager")
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
