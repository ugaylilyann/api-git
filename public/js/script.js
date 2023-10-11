$(document).ready(function () {


    $(document).on('submit', '#addNameAPI', function (event) {
        event.preventDefault();
        var fname = $('input[name=fname]').val();
        var lname = $('input[name=lname]').val();

        $.ajax({
            type: "POST",
            url: "public/postNames",
            data: JSON.stringify({
                fname: fname,
                lname: lname,
            }),
            success: function (response) {
                // console.log(answer);
                if (response === "success") {
                    // console.log();
                    $("#addSuccess").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    $("#addFailed").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
    $("#search").click(function () {
        id = prompt("Enter Student ID");
        //endpoint
        $.post("public/searchNames",
            JSON.stringify(
                //payload
                {
                    id: id
                }
            ),
            function (data, status) {
                //result
                var json = JSON.parse(data);
                $("#upfname").get(0).value = json.data[0].fname;
                $("#uplname").get(0).value = json.data[0].lname;
                console.log(json);

            });
    });
    $("#delete").click(function () {

        $.ajax({
            type: "POST",
            url: "public/deleteNames",
            data: JSON.stringify({
                id: id
            }),
            success: function (response) {
                // console.log(answer);
                if (response === "success") {
                    // console.log();
                    $("#delSuccess").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    $("#delFailed").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
    $("#update").click(function () {

        var fname = $("#upfname").get(0).value;
        var lname = $("#uplname").get(0).value;
        $.ajax({
            type: "POST",
            url: "public/updateNames",
            data: JSON.stringify({
                id: id,
                lname: lname,
                fname: fname
            }),
            success: function (response) {
                // console.log(answer);
                if (response === "success") {
                    // console.log();
                    $("#upSuccess").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    $("#upFailed").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
});


