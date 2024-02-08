<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
</head>
<body style="background-color:white;">

<h2>Clickable Dropdown</h2>
<p>Click on the button to open the dropdown menu.</p>
<p id="demo"></p>
<div class="dropdown">



  <button onclick="myFunction()" class="dropbtn">Dropdown</button>
  <div id="myDropdown" class="dropdown-content">
    <button id="btn-jan calndr-btn">January</button>
    <button id="btn-feb calndr-btn">February</button>
    <button id="btn-mar calndr-btn">March</button>
    <button id="btn-apr calndr-btn">April</button>
    <button id="btn-may calndr-btn">May</button>
    <button id="btn-june calndr-btn">June</button>
    <button id="btn-jul calndr-btn">July</button>
    <button id="btn-aug calndr-btn">August</button>
    <button id="btn-sep calndr-btn">September</button>
    <button id="btn-oct calndr-btn">October</button>
    <button id="btn-nov calndr-btn">November</button>
    <button id="btn-dec calndr-btn">December</button>
  </div>
</div>

<script src="js/script.js"></script>


</body>
</html>