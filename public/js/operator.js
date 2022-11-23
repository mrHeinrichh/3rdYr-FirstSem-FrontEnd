$(document).ready(function () {
    $("#otable").DataTable({
        ajax: {
            url: "http://localhost:5000/api/v1/operator",
            dataSrc: "",
        },
        dom: '<"top"<"left-col"B><"center-col"l><"right-col"f>>rtip',
        buttons: [
            {
                extend: "pdf",
                className: "btn btn-success glyphicon glyphicon-file",
            },
            {
                extend: "excel",
                className: "btn btn-success glyphicon glyphicon-list-alt",
            },
            {
                text: "Add Operator",
                className: "btn btn-success",
                action: function (e, dt, node, config) {
                    $("#oform").trigger("reset");
                    $("#operatorModal").modal("show");
                },
            },
        ],
        columns: [
            {
                data: "operator_id",
            },
            {
                data: "name",
            },
            {
                data: "contact_number",
            },
            {
                data: "age",
            },
            {
                data: "address",
            },
            {
                data: null,
                render: function (data, type, JsonResultRow, row) {
                    return `<img src= ${data.image_path} "height="100px" width="100px">`;
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='editBtn' id='editbtn' data-id=" +
                        data.operator_id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a><a href='#' class='deletebtn' data-id=" +
                        data.operator_id +
                        "><i class='fa-solid fa-trash-can' style='font-size:24px; color:red; margin-left:15px;'></a></i>"
                    );
                },
            },
        ],
    });

    $("#operatorSubmit").on("click", function (e) {
        e.preventDefault();
        var data = $("#oform")[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        $.ajax({
            type: "POST",
            url: "http://localhost:5000/api/v1/operator",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#operatorModal").modal("hide");
                var $otable = $("#otable").DataTable();
                $otable.ajax.reload();
                $otable.row.add(data.operator).draw(false);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("#otable tbody").on("click", "a.deletebtn", function (e) {
        var table = $("#otable").DataTable();
        var id = $(this).data("id");
        var $row = $(this).closest("tr");

        console.log(id);
        e.preventDefault();
        bootbox.confirm({
            message: "do you want to delete this operator",
            buttons: {
                confirm: {
                    label: "yes",
                    className: "btn-success",
                },
                cancel: {
                    label: "no",
                    className: "btn-danger",
                },
            },
            callback: function (result) {
                console.log(result);
                if (result)
                    $.ajax({
                        type: "DELETE",
                        url: `http://localhost:5000/api/v1/operator/${id}`,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $row.fadeOut(4000, function () {
                                table.row($row).remove().draw(false);
                            });
                            bootbox.alert(data.success);
                        },
                        error: function (error) {
                            console.log("error");
                        },
                    });
            },
        });
    });

    $("#otable tbody").on("click", "a.editBtn", function (e) {
        e.preventDefault();
        $("#operatorModal").modal("show");
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `http://localhost:5000/api/v1/operator/${id}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#operator_id").val(data[0].operator_id);
                $("#name").val(data[0].name);
                $("#contact_number").val(data[0].contact_number);
                $("#age").val(data[0].age);
                $("#address").val(data[0].address);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#operatorUpdate").on("click", function (e) {
        e.preventDefault();
        var id = $("#operator_id").val();
        console.log(id);

        var crow = $("tr td:contains(" + id + ")").closest("tr");
        var table = $("#otable").DataTable();
        var data = $("#oform")[0];
        console.log(data);
        let formData = new FormData(data);

        $.ajax({
            type: "PUT",
            url: `http://localhost:5000/api/v1/operator/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#operatorModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("#operator").on("click", function (e) {
        e.preventDefault();
        $("#operator").show();

        $.ajax({
            type: "GET",
            url: "/api/operator",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $.each(data, function (key, value) {
                    console.log(value);
                    var id = value.operator_id;
                    var tr = $("<tr>");
                    tr.append($("<td>").html(value.operator_id));
                    tr.append($("<td>").html(value.name));
                    tr.append($("<td>").html(value.contact_number));
                    tr.append($("<td>").html(value.age));
                    tr.append($("<td>").html(value.address));
                    tr.append($("<td>").html(value.image_path));
                    tr.append(
                        "<td align='center'><a href='#' data-bs-toggle='modal' data-bs-target='#editModal' id='editbtn' data-id=" +
                            id +
                            "><i class='fa fa-pencil' aria-hidden='true' style='font-size:24px' ></a></i></td>"
                    );
                    tr.append(
                        "<td><a href='#'  class='deletebtn' data-id=" +
                            id +
                            "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>"
                    );

                    $("#obody").append(tr);
                });
            },
            error: function () {
                console.log("AJAX load did not work");
                alert("error");
            },
        });
    });
});
