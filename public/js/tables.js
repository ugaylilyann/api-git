$(document).ready(function () {


    $.post("public/getNames",
        function (data, status) {
            var json = JSON.parse(data);
            var row = "";
            for (var i = 0; i < json.data.length; i++) {
                row = row + "<tr><td>" +
                    json.data[i].id + "</td><td>" +
                    json.data[i].fname + "</td><td>" +
                    json.data[i].lname + "</td></tr>";
            }
            $("#nameData").get(0).innerHTML = row;
            /*  $.ajax({
                 type: "POST",
                 url: "public/updateNames",
                 data: JSON.stringify({
                     id: id,
                     fname: fname,
                     lname: lname
                 }),
                 success: function (response) {
 
                 }
             });
             $.ajax({
                 type: "POST",
                 url: "public/deleteNames",
                 data: JSON.stringify({
                     id: id
                 }),
                 success: function (response) {
 
                 }
             }); */
        });

});