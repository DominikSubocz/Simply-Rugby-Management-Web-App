
    const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    const d = new Date("2021-03-25");
    let month = months[d.getMonth()];
    document.getElementById("demo").innerHTML = month;

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
      }

      
      
      // Close the dropdown if the user clicks outside of it
      window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
          var dropdowns = document.getElementsByClassName("dropdown-content");
          var i;
          for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
            }
          }
        }
      }