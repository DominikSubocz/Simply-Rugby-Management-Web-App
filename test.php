<?php

require("classes/components.php");

session_start();

Components::pageHeader("Timetable", ["style"], ["mobile-nav"]);

?>


<div class="calendar">
  <div class="calendar-header">
    <button id="prevWeek">Previous Week</button>
    <h2 id="currentWeek">Week of: <span></span></h2>
    <button id="nextWeek">Next Week</button>
  </div>


  <div class="calendar-content">

      <div class="weekdays">
        <div class="calendar-column"> </div>
        
      </div>

      <div>
        <div class="timeslots">
        </div>
      </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>



