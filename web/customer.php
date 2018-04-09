<?php
session_start();
if (!isset($_SESSION['user']))
    header("Location: index.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer page</title>
    <link href="css/471_style.css" rel = "stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">

        //Helper function, creates a PHP request for the specified PHP file with the given arguments
        function callPHP(scriptName, args){
            //scriptName is a string, the name of a PHP function (eg "test.php")
            //args is an array of parameters to be passed to the PHP function, in order.
            console.log("start callPHP function");
            var toSend = new XMLHttpRequest();
            toSend.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    $('#phpReply').empty()
                        .append('<h1> Server Reply </h1>')
                        .append(this.responseText);
                }
            };
            let urlString = "";
            urlString = urlString + scriptName + "?";
            for (let i = 0; i < args.length; i++){
                urlString = urlString + "arg" + i + "=" + args[i] + "&";
            }
            urlString.slice(0, urlString.length-2);
            /*
            console.log("what is being called: " +
                urlString.slice(0, urlString.length-1));
                */
            toSend.open("GET", urlString.slice(0, urlString.length-1), true);
            toSend.send();
        }
        window.onload = function(){
            var button = document.getElementById("button1");
            button.onclick = function(){
                //Add new rental
                $('#commandTitle').empty()
                    .append("Place a Rental")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input type="text" id = "input1"><br>')
                    .append('Username <input type="text" id = "input2"><br>')
                    .append('Start Date <input type="date" id = "input3"><br>')
                    .append('End Date <input type="date" id = "input4"><br>')


                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    inText = document.getElementById("input4").value;
                    args.push(inText);
                    callPHP("pscripts/placeRental.php", args);
                }

            };


            button = document.getElementById("button2");
            button.onclick = function() {
                //Remove existing rental
                $('#commandTitle').empty()
                    .append("Cancel a Rental")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input type="text" id = "input1"><br>')
                    .append('Username <input type="text" id = "input2"><br>')
                    .append('Start Date <input type="date" id = "input3"><br>')
                    .append('End Date <input type="date" id = "input4"><br>')

                button = document.getElementById("submit button");
                button.onclick = function () {
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    inText = document.getElementById("input4").value;
                    args.push(inText);
                    callPHP("pscripts/deleteRental.php", args);
                }
            };

                button = document.getElementById("button3");
                button.onclick = function(){
                    //Modify a rental
                    $('#commandTitle').empty()
                        .append("Change a Rental")
                    $('#inputArea').empty()
                        .append('<form id="input"></form>')
                        .append('<button id = "submit button"> Submit </button>')
                    $('#input').append('Equipment ID <input type="text" id = "input1"><br>')
                        .append('Username <input type="text" id = "input2"><br>')
                        .append('Start Date <input type="date" id = "input3"><br>')
                        .append('End Date <input type="date" id = "input4"><br>')

                    button = document.getElementById("submit button");
                    button.onclick = function () {
                        let args = [];
                        let inText = document.getElementById("input1").value;
                        args.push(inText);
                        inText = document.getElementById("input2").value;
                        args.push(inText);
                        inText = document.getElementById("input3").value;
                        args.push(inText);
                        inText = document.getElementById("input4").value;
                        args.push(inText);
                        callPHP("pscripts/updateRental.php", args);
                    }
                };

            button = document.getElementById("button4");
            button.onclick = function(){
                //Display all my rentals
                $('#commandTitle').empty()
                    .append("My Rentals")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Username <input type="text" id = "input1"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    callPHP("pscripts/myRentalList.php", args);
                }

            };

            button = document.getElementById("button5");
            button.onclick = function(){
                //Display all my rentals
                $('#commandTitle').empty()
                    .append("Training Camps")
                $('#inputArea').empty();
                let args = [];
                callPHP("pscripts/displayCampList.php", args);
            };


            button = document.getElementById("button6");
            button.onclick = function(){
                //Register for camp
                $('#commandTitle').empty()
                    .append("Register for Training Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input type="text" id = "input1"><br>')
                    .append('Camp ID <input type="text" id = "input2"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    callPHP("pscripts/campRegister.php", args);
                }

            };

            button = document.getElementById("button7");
            button.onclick = function(){
                //Remove from a camp
                $('#commandTitle').empty()
                    .append("Leave a Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input type="text" id = "input1"><br>')
                    .append('Camp ID <input type="text" id = "input2"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    callPHP("pscripts/campDeregister.php", args);
                }
            };
        }
    </script>
</head>
<body>
<div class="page-container">
    <div class="menu">
        <h3 style="padding-top: 4%; padding-bottom: 10%">Main Menu</h3>
        <button class = "menuButton" id = "button1" type="button">Place a Rental</button>
        <button class = "menuButton" id = "button2" type="button">Cancel a Rental</button>
        <button class = "menuButton" id = "button3" type="button">Modify a Rental</button>
        <button class = "menuButton" id = "button4" type="button">My Rentals</button>
        <button class = "menuButton" id = "button5" type="button">View available Training</button>

        <button class = "menuButton" id = "button6" type="button">Register for Training Camp</button>

        <button class = "menuButton" id = "button7" type="button">Leave a Camp</button>
        <form method="get" action="pscripts/logout.php"><button class="menuButton" id="logoutButton" type="submit">Log Out</button></form>
    </div>
    <div class="window">
        <h1 id="Input Window"> Customer </h1>
        <h2 id = "commandTitle"> </h2>
        <div id = "inputArea"></div>
        <div id = "phpReply"></div>
    </div>
</div>

</body>
</html>
