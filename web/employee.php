<?php
session_start();
if (!isset($_SESSION['user']))
    header("Location: index.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employee page</title>
    <link href="css/471_style.css" rel = "stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">

        //Helper function, creates a PHP request for the specified PHP file with the given arguments
        function callPHP(scriptName, args){
            //scriptName is a string, the name of a PHP function (eg "test.php")
            //args is an array of parameters to be passed to the PHP function, in order.

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
            console.log("what is being called: " +
                urlString.slice(0, urlString.length-1));
            toSend.open("GET", urlString.slice(0, urlString.length-1), true);
            toSend.send();
        }
        window.onload = function(){
            var button = document.getElementById("button1");
            button.onclick = function(){
                //Add new equipment function
                //Add fields for equipment_id, price per day, weight, status and location name to body
                $('#commandTitle').empty()
                    .append("Add New Equipment")
                $('#inputArea').empty()
                            .append('<form id="input" target="result"></form>')
                          .append('<button id = "submit new equipment"> Submit </button>')
                $('#input').append('Price per day <input type="text" id = "input price per day"><br>')
                            .append('Weight  <input type="text" id="input weight"><br>')
                            .append('Available  <input type="radio" name = "status" value="available" checked>')
                            .append('Rented  <input type="radio" name = "status" value="rented">')
                            .append('Under Maintenence  <input type="radio" name = "status" value="maintenance">')
                            .append('<br>Location Name  <input type="text" id = "input loc name"><br>')

                button = document.getElementById("submit new equipment");
                button.onclick = function() {
                    let testArgs = [];
                    let temp = document.getElementById("input price per day").value;
                    testArgs.push(temp);
                    temp = document.getElementById("input weight").value;
                    testArgs.push(temp);
                    temp = $('input[name=status]:checked', '#input').val();
                    temp = temp.toString().charAt(0);
                    testArgs.push(temp);
                    temp = document.getElementById("input loc name").value;
                    testArgs.push(temp);
                    temp = Date.now();
                    testArgs.push(temp);
                    callPHP("pscripts/addEquip.php", testArgs);
                }
            };

            button = document.getElementById("button2");
            button.onclick = function(){
                //Remove existing equipment function
                $('#commandTitle').empty()
                    .append("Remove Existing Equipment")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input type="text" id = "input1"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    callPHP("pscripts/removeEquip.php", args);
                }

            };


            button = document.getElementById("button3");
            button.onclick = function(){
                //confirm user card
                $('#commandTitle').empty()
                    .append("Confirm User Credit card")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Customer Username <input id = "input1" type="text"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    callPHP("pscripts/confirmCard.php", args);
                }
            };



            button = document.getElementById("button4");
            button.onclick = function(){
                //Create new maintanence
                $('#commandTitle').empty()
                    .append("Create new Maintanence")
                $('#inputArea').empty()
                    .append('<form  id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Start Date <input id = "input1" type="text"><br>')
                    .append('Finish Date <input id = "input2" type="text"><br>')
                    .append('Equipment ID <input id = "input3" type="text"><br>')
                    .append('Cost <input id = "input4" type="text"><br>')

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

                    callPHP("pscripts/createMaint.php", args);
                }
            };


            button = document.getElementById("button5");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Update User Account Information")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Current Password <input id = "input2" type="password"><br>')
                    .append('New Password <input id = "input3" type="password"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = "";
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    callPHP("pscripts/updateUser.php", args);
                }
            };

            button = document.getElementById("button10");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Upgrade User Account ")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Username <input id = "input1" type="text"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    callPHP("pscripts/upgradeUser.php", args);
                }
            };


            button = document.getElementById("button6");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Update Rental")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input id = "input1" type="text"><br>')
                    .append('Rental Start Date <input id = "input2" type="text"><br>')
                    .append('Rental Return Date <input id = "input3" type="text"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    callPHP("pscripts/updateRental.php", args);
                }
            };


            button = document.getElementById("button7");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Display User List")
                $('#inputArea').empty()
                    .append('<button id = "submit button"> Get Users </button>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    callPHP("pscripts/dispUsers.php", args);
                }
            };


            button = document.getElementById("button8");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Display Rental List")
                $('#inputArea').empty()
                    .append('<button id = "submit button"> Get Rentals </button>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    callPHP("pscripts/dispRentals.php", args);
                }
            };


            button = document.getElementById("button9");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Display Maintanence Schedule")
                $('#inputArea').empty()
                    .append('<button id = "submit button"> Get Maintenence </button>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    callPHP("pscripts/dispMaint.php", args);
                }
            };

            button = document.getElementById("button11");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Add Customer payment")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Credit Card  <input type="radio" name = "type" value="cc" checked>')
                    .append('Cash  <input type="radio" name = "type" value="cash">')
                    .append('Debit  <input type="radio" name = "type" value="debit">')
                    .append('Other  <input type="radio" name = "type" value="other">')
                    .append('<br>Employee Username <input type="text" id = "input1"><br>')
                    .append('Customer Username  <input type="text" id="input2"><br>')
                    .append('Available Balance  <input type="text" id = "input3"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let temp = $('input[name=type]:checked', '#input').val();
                    temp = temp.toString();
                    args.push(temp);
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    callPHP("pscripts/addPayment.php", args);
                }
            };

            button = document.getElementById("button12");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Create Training Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input id = "input1" type="text"><br>')
                    .append('Start Date <input id = "input2" type="date"><br>')
                    .append('Finish Date <input id = "input3" type="date"><br>')
                    .append('Camp ID <input id = "input4" type="text"><br>')

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
                    callPHP("pscripts/createTraining.php", args);
                }
            };

            button = document.getElementById("button13");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Modify Training Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input id = "input1" type="text"><br>')
                    .append('Start Date <input id = "input2" type="date"><br>')
                    .append('Finish Date <input id = "input3" type="date"><br>')
                    .append('Camp ID <input id = "input4" type="text"><br>')

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
                    callPHP("pscripts/updateTraining.php", args);
                }
            };

            button = document.getElementById("button14");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Delete Training Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input id = "input1" type="text"><br>')
                    .append('Camp ID <input id = "input2" type="text"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    callPHP("pscripts/deleteTraining.php", args);
                }
            };

            button = document.getElementById("button15");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Add trainer to Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input id = "input1" type="text"><br>')
                    .append('Camp ID <input id = "input2" type="text"><br>')
                    .append('Employee Username <input id = "input3" type="text"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    callPHP("pscripts/addTrainer.php", args);
                }
            };

            button = document.getElementById("button16");
            button.onclick = function(){
                $('#commandTitle').empty()
                    .append("Remove trainer from Camp")
                $('#inputArea').empty()
                    .append('<form id="input"></form>')
                    .append('<button id = "submit button"> Submit </button>')
                $('#input').append('Equipment ID <input id = "input1" type="text"><br>')
                    .append('Camp ID <input id = "input2" type="text"><br>')
                    .append('Employee Username <input id = "input3" type="text"><br>')

                button = document.getElementById("submit button");
                button.onclick = function(){
                    let args = [];
                    let inText = document.getElementById("input1").value;
                    args.push(inText);
                    inText = document.getElementById("input2").value;
                    args.push(inText);
                    inText = document.getElementById("input3").value;
                    args.push(inText);
                    callPHP("pscripts/removeTrainer.php", args);
                }
            };



        }
    </script>
</head>
<body>
<div class="page-container">
    <div class="menu">
        <h3 style="padding-top: 4%; padding-bottom: 10%">Main Menu</h3>
        <button class = "menuButton" id = "button1" type="button">Add new Equipment</button>
        <button class = "menuButton" id = "button2" type="button">Remove Equipment</button>
        <button class = "menuButton" id = "button3" type="button">Confirm user card</button>
        <button class = "menuButton" id = "button4" type="button">Create new Maintanence</button>
        <button class = "menuButton" id = "button5" type="button">Update account information</button>
        <button class = "menuButton" id = "button10" type="button">Upgrade user account</button>
        <button class = "menuButton" id = "button6" type="button">Update Rental</button>

        <button class = "menuButton" id = "button7" type="button">Display User List</button>
        <button class = "menuButton" id = "button8" type="button">Display Rental List</button>
        <button class = "menuButton" id = "button9" type="button">Display Maintanence Schedule</button>

        <button class = "menuButton" id = "button11" type="button">Add Customer Payment</button>
        <button class = "menuButton" id = "button12" type="button">Create Training Camp</button>
        <button class = "menuButton" id = "button13" type="button">Update Training Camp</button>
        <button class = "menuButton" id = "button14" type="button">Delete Training Camp</button>
        <button class = "menuButton" id = "button15" type="button">Add Trainer</button>
        <button class = "menuButton" id = "button16" type="button">Remove Trainer</button>
        <form method="get" action="pscripts/logout.php"><button class="menuButton" id="logoutButton" type="submit">Log Out</button></form>
    </div>
    <div class="window">
        <h1 id="Input Window"> Employee </h1>
        <h2 id = "commandTitle"> </h2>
        <div id = "inputArea"></div>
        <div id = "phpReply"></div>
    </div>
</div>

</body>
</html>
