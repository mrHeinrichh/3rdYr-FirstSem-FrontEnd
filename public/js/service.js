$(document).ready(function () {
    $("#stable").DataTable({
        ajax: {
            url: "http://localhost:5000/api/v1/service",
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
                text: "Add Service",
                className: "btn btn-success",
                action: function (e, dt, node, config) {
                    $("#sform").trigger("reset");
                    $("#serviceModal").modal("show");
                },
            },
        ],
        columns: [
            {
                data: "service_id",
            },
            {
                data: "service_type",
            },
            {
                data: "date_of_service",
            },
            {
                data: "price",
            },
            {
                data: "operator_id",
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
                        data.service_id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a><a href='#' class='deletebtn' data-id=" +
                        data.service_id +
                        "><i class='fa-solid fa-trash-can' style='font-size:24px; color:red; margin-left:15px;'></a></i>"
                    );
                },
            },
        ],
    });

    $("#serviceSubmit").on("click", function (e) {
        e.preventDefault();
        var data = $("#sform")[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        $.ajax({
            type: "POST",
            url: "http://localhost:5000/api/v1/service",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#serviceModal").modal("hide");
                var $stable = $("#stable").DataTable();
                $stable.ajax.reload();
                $stable.row.add(data.service).draw(false);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("#stable tbody").on("click", "a.deletebtn", function (e) {
        var table = $("#stable").DataTable();
        var id = $(this).data("id");
        var $row = $(this).closest("tr");

        console.log(id);
        e.preventDefault();
        bootbox.confirm({
            message: "do you want to delete this service",
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
                        url: `http://localhost:5000/api/v1/service/${id}`,
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

    $("#stable tbody").on("click", "a.editBtn", function (e) {
        e.preventDefault();
        $("#serviceModal").modal("show");
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `http://localhost:5000/api/v1/service/${id}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#service_id").val(data[0].service_id);
                $("#service_type").val(data[0].name);
                $("#date_of_service").val(data[0].contact_number);
                $("#price").val(data[0].age);
                $("#operator_id").val(data[0].address);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#serviceUpdate").on("click", function (e) {
        e.preventDefault();
        var id = $("#service_id").val();
        console.log(id);

        var crow = $("tr td:contains(" + id + ")").closest("tr");
        var table = $("#stable").DataTable();
        var data = $("#sform")[0];
        console.log(data);
        let formData = new FormData(data);

        $.ajax({
            type: "PUT",
            url: `http://localhost:5000/api/v1/service/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#serviceModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("#service").on("click", function (e) {
        e.preventDefault();
        $("#service").show();

        $.ajax({
            type: "GET",
            url: "/api/service",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $.each(data, function (key, value) {
                    console.log(value);
                    var id = value.service_id;
                    var tr = $("<tr>");
                    tr.append($("<td>").html(value.service_id));
                    tr.append($("<td>").html(value.service_type));
                    tr.append($("<td>").html(value.date_of_service));
                    tr.append($("<td>").html(value.price));
                    tr.append($("<td>").html(value.operator_id));
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
