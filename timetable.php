<?php

require("classes/components.php");

session_start();
Components::pageHeader("Timetable", ["style"], ["mobile-nav"]);

?>

<body>

<div class="main">
  <div class="calendar-container">
    <div>
      <div id="nav"></div>
    </div>
    <div class="calendar-wrapper">
      <div class="toolbar buttons">
        <span class="toolbar-item"><a class="button" id="buttonDay" href="#">Day</a></span>
        <span class="toolbar-item"><a class="button" id="buttonWeek" href="#">Week</a></span>
        <span class="toolbar-item"><a class="button" id="buttonMonth" href="#">Month</a></span>
      </div>
      <div id="dpDay"></div>
      <div id="dpWeek"></div>
      <div id="dpMonth"></div>
    </div>
  </div>
</div>

<script type="text/javascript">


  const nav = new DayPilot.Navigator("nav");
  nav.showMonths = 3;
  nav.skipMonths = 3;
  nav.init();

  const day = new DayPilot.Calendar("dpDay");
  day.viewType = "Day";
  configureCalendar(day);
  day.init();

  const week = new DayPilot.Calendar("dpWeek");
  week.viewType = "Week";
  configureCalendar(week);
  week.init();

  const month = new DayPilot.Month("dpMonth");
  configureCalendar(month);
  month.init();

  function configureCalendar(dp) {
    dp.contextMenu = new DayPilot.Menu({
      items: [
        {
          text: "Delete",
          onClick: async args => {
            var params = {
              id: args.source.id(),
            };
            await DayPilot.Http.post("calendar_delete.php", params);
            dp.events.remove(params.id);
            console.log("Deleted");
          }
        },
        {
          text: "-"
        },
        {
          text: "Blue",
          icon: "icon icon-blue",
          color: "#3d85c6",
          onClick: args => { updateColor(args.source, args.item.color); }
        },
        {
          text: "Green",
          icon: "icon icon-green",
          color: "#6aa84f",
          onClick: args => { updateColor(args.source, args.item.color); }
        },
        {
          text: "Orange",
          icon: "icon icon-orange",
          color: "#e69138",
          onClick: args => { updateColor(args.source, args.item.color); }
        },
        {
          text: "Red",
          icon: "icon icon-red",
          color: "#cc4125",
          onClick: args => { updateColor(args.source, args.item.color); }
        }
      ]
    });


    dp.onBeforeEventRender = args => {
      if (!args.data.backColor) {
        args.data.backColor = "#6aa84f";
      }
      args.data.borderColor = "darker";
      args.data.fontColor = "#fff";
      args.data.barHidden = true;

      args.data.areas = [
        {
          right: 2,
          top: 2,
          width: 20,
          height: 20,
          html: "&equiv;",
          action: "ContextMenu",
          cssClass: "area-menu-icon",
          visibility: "Hover"
        }
      ];
    };

    dp.onEventMoved = async args => {
      const params = {
        id: args.e.id(),
        newStart: args.newStart,
        newEnd: args.newEnd
      };
      await DayPilot.Http.post("calendar_move.php", params);
      console.log("Moved.");
    };

    dp.onEventResized = async args => {
      const params = {
        id: args.e.id(),
        newStart: args.newStart,
        newEnd: args.newEnd
      };
      await DayPilot.Http.post("calendar_move.php", params);
      console.log("Resized.");
    };

    dp.onTimeRangeSelected = async args => {

      const form = [
        {name: "Name", id: "text"},
        {name: "Start", id: "start", dateFormat: "MMMM d, yyyy h:mm tt", disabled: true},
        {name: "End", id: "end", dateFormat: "MMMM d, yyyy h:mm tt", disabled: true},
      ];

      const data = {
        start: args.start,
        end: args.end,
        text: "Event"
      };

      const dp = switcher.active.control;

      const modal = await DayPilot.Modal.form(form, data);
      dp.clearSelection();

      if (modal.canceled) {
        return;
      }

      const {data: result} = await DayPilot.Http.post("calendar_create.php", modal.result);

      dp.events.add({
        start: data.start,
        end: data.end,
        id: result.id,
        text: data.text
      });

    };

    dp.onEventClick = args => {
      DayPilot.Modal.alert(args.e.data.text);
    };
  }

  const switcher = new DayPilot.Switcher({
    triggers: [
      {id: "buttonDay", view: day },
      {id: "buttonWeek", view: week},
      {id: "buttonMonth", view: month}
    ],
    navigator: nav,
    selectedClass: "selected-button",
    onChanged: args => {
      console.log("onChanged fired");
      switcher.events.load("calendar_events.php");
    }
  });

  switcher.select("buttonWeek");

  async function updateColor(e, color) {
    const params = {
      id: e.data.id,
      color: color
    };

    await DayPilot.Http.post("calendar_color.php", params);
    const dp = switcher.active.control;
    e.data.backColor = color;
    dp.events.update(e);
    console.log("Color updated");
  }

</script>

</body>
</html>






