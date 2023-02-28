$("#return_page_teacher").click(function () {
  window.location.href = "page_teacher.php";
});

function update_btn(input) {
  document.getElementById("update-btn").style.visibility = "visible";
  document.getElementById("create-q-btn").style.visibility = "hidden";
  document.getElementById("autocheck-btn").style.visibility = "hidden";
  document.getElementById("input-create").placeholder =
    'Write here to update the question: "' +
    document.getElementById(input).innerHTML +
    '"';
  $.post(
    "zerver_page_teacher_curr_q_update.php",
    { curr: input },
    function (data) {
      alert(data);
    }
  );
}

function delete_btn(input) {
  input = input.replace("delete_", "");
  $.post(
    "zerver_page_teacher_question_delete.php",
    { deleting: input },
    function () {
      page_start();
      alert("SUCCESSFULLY DELETED");
    }
  );
}

$("#update-btn").click(function () {
  if (document.getElementById("input-create").value == "") {
    alert("Please update the question with contents...");
    return;
  }
  document.getElementById("update-btn").style.visibility = "hidden";
  document.getElementById("create-q-btn").style.visibility = "visible";
  document.getElementById("autocheck-btn").style.visibility = "visible";
  document.getElementById("input-create").placeholder =
    "Write your question here...";
  $.post(
    "zerver_page_teacher_question_update_q.php",
    { q_content: document.getElementById("input-create").value },
    function () {
      page_start();
    }
  );
});

$("#autocheck-btn").click(function () {
  document.getElementById("autocheck-textarea").style.visibility = "visible";
});

$("#create-q-btn").click(function () {
  if (document.getElementById("input-create").value == "") {
    alert("Please write a question before creating...");
    return;
  } else {
    alert("recog");
    $.post(
      "zerver_page_teacher_question_create.php",
      {
        question: document.getElementById("input-create").value,
        autocheck: document.getElementById("autocheck-textarea").value,
      },
      function () {
        page_start();
      }
    );
  }
});

function publish_q(input) {
  input = input.replace("publish_", "");
  $.post(
    "zerver_page_teacher_question_publish.php",
    { publish_id: input },
    function () {
      alert("PUBLISHED");
      page_start();
    }
  );
}

function unpublish_q(input) {
  input = input.replace("unpublish_", "");
  $.post(
    "zerver_page_teacher_question_unpublish.php",
    { publish_id: input },
    function () {
      alert("UNPUBLISHED");
      page_start();
    }
  );
}

function page_start() {
  $.get("zerver_page_teacher_fetch_questions.php", function (data) {
    data = JSON.parse(data);
    $("#created-q").empty();
    output = "";
    for (x = 0; x < data.length; x++) {
      output +=
        "<tr><td id='question_gear_" +
        data[x]["question_id"] +
        "'>" +
        data[x]["question"] +
        "</td><td>";
      if (data[x]["publish"] == "1") {
        output +=
          "PUBLISHED<td><button id='unpublish_" +
          data[x]["question_id"] +
          "' onclick='unpublish_q(this.id)'>UNPUBLISH</button>";
      } else {
        output +=
          "NOT PUBLISHED</td><td><button id='publish_" +
          data[x]["question_id"] +
          "' onclick='publish_q(this.id)'>PUBLISH</button>";
      }
      output +=
        "<button id='gear_" +
        data[x]["question_id"] +
        "'onclick='update_btn(" +
        '"question_"' +
        " + this.id)'>⚙️</button><button id='delete_" +
        data[x]["question_id"] +
        "' onclick='delete_btn(this.id)'>DELETE</button></td></tr>";
    }
    $("#created-q").append(output);
  });
}

page_start();
