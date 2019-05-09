$(document).ready(function() {
    var jsonToSend = {
        "action" : "PRODUCTSD"
    };

    var descriptions = [];

    $.ajax({
        url : "../data/applicationLayer.php",
        type : "POST",
        data : jsonToSend,
        ContentType : "application/json",
        datatype : "json",
        success : function(dataReceived) {
            console.log(dataReceived[1]);
            for (var i = 0; i < dataReceived.length; i++) {
                descriptions.push(dataReceived[i]);
            }

            jsonToSend = {
                "action" : "PRODUCTS"
            };

            $.ajax({
                url : "../data/applicationLayer.php",
                type : "POST",
                data : jsonToSend,
                ContentType : "application/json",
                datatype : "json",
                success : function(dataReceived) {

                    for (var i = 0; i < dataReceived.length; i++) {
                        var image = document.createElement("img");
                        var div = document.createElement("div");
                        div.setAttribute("class", "col-12 col-sm-6 col-md-3 box");
                        image.src = 'data:image/jpeg;base64,' + dataReceived[i]["image"];

                        var list = document.getElementById("image-list");

                        div.append(image);
                        list.append(div);

                        div = document.createElement("div");
                        div.setAttribute("class", "col-12 col-sm-6 col-md-3 box");
                        var newHtml = '<p>' + descriptions[i]["description"] + '</p>';
                        div.insertAdjacentHTML("beforeend", newHtml);

                        list.append(div);
                    }
                },
                error : function(errorMessage) {
                    alert(errorMessage.statusText);
                }
            });
        },
        error : function(errorMessage) {
            alert(errorMessage.statusText);
        }
    });
});