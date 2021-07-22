window.addEventListener("load", init);

function init() {

  var a = document.querySelector("#activeTab");
  a.addEventListener("click", active);
  
  var b = document.querySelector("#assignedTab");
  b.addEventListener("click", assigned);

  var c = document.querySelector("#closedTab");
  c.addEventListener("click", closed);

 
  document.querySelector("#search-bar").addEventListener("click", function(e) {
    e.preventDefault();
  })

    
  deleteTicket();
} 

var d = document.querySelector("#search-bar");
addEventListener("keydown", event => {     
  var input, filter, table, tr, td, i, txtValue;
  table = document.querySelectorAll(".activeTable");
  input = document.getElementById("search-bar");
  filter = input.value.toUpperCase();
  
  table.forEach((table) => {
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByClassName("subject-c")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          table.style.display = "";
        } else {
          table.style.display = "none";
        }
      }
    }
    
  })
});

function active(){
  var a = document.querySelector("#Active");
  var b = document.querySelector("#Assigned");
  var c = document.querySelector("#Closed");

  var aTab = document.querySelector("#activeTab");
  var bTab = document.querySelector("#assignedTab");
  var cTab = document.querySelector("#closedTab");

  tab = "#Active";
  a.style.display = "block";
  a.className += " active";
  aTab.style.backgroundColor = "rgb(18 94 144)";

  b.style.display = "none";
  b.className.replace(" active", "");
  bTab.style.backgroundColor = "#2e79ab";

  c.style.display = "none";
  c.className.replace(" active", "");
  cTab.style.backgroundColor = "#2e79ab";


}
function assigned(){
  var a = document.querySelector("#Active");
  var b = document.querySelector("#Assigned");
  var c = document.querySelector("#Closed");

  var aTab = document.querySelector("#activeTab");
  var bTab = document.querySelector("#assignedTab");
  var cTab = document.querySelector("#closedTab");

  tab = "#Assigned";
  b.style.display = "block";
  b.className += " active";
  bTab.style.backgroundColor = "rgb(18 94 144)";

  a.style.display = "none";
  a.className.replace(" active", "");
  aTab.style.backgroundColor = "#2e79ab";

  c.style.display = "none";
  c.className.replace(" active", "");
  cTab.style.backgroundColor = "#2e79ab";

  var d = document.querySelector("#search-bar");
  addEventListener("keydown", event => {     
    var input, filter, table, tr, td, i, txtValue;
    table = document.querySelectorAll(".assignedTable");
    input = document.getElementById("search-bar");
    filter = input.value.toUpperCase();
    
    table.forEach((table) => {
      tr = table.getElementsByTagName("tr");
  
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("subject-c")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            table.style.display = "";
          } else {
            table.style.display = "none";
          }
        }
      }
      
    })
  });

  
}
function closed(){
  var a = document.querySelector("#Active");
  var b = document.querySelector("#Assigned");
  var c = document.querySelector("#Closed");

  var aTab = document.querySelector("#activeTab");
  var bTab = document.querySelector("#assignedTab");
  var cTab = document.querySelector("#closedTab");

  tab = "#Active";
  c.style.display = "block";
  c.className += " active";
  cTab.style.backgroundColor = "rgb(18 94 144)";

  b.style.display = "none";
  b.className.replace(" active", "");
  bTab.style.backgroundColor = "#2e79ab";

  a.style.display = "none";
  a.className.replace(" active", "");
  aTab.style.backgroundColor = "2e79ab";

  var d = document.querySelector("#search-bar");
  addEventListener("keydown", event => {     
    var input, filter, table, tr, td, i, txtValue;
    table = document.querySelectorAll(".closedTable");
    input = document.getElementById("search-bar");
    filter = input.value.toUpperCase();
    
    table.forEach((table) => {
      tr = table.getElementsByTagName("tr");
  
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("subject-c")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            table.style.display = "";
          } else {
            table.style.display = "none";
          }
        }
      }
      
    })
  });

  
}

function deleteTicket(){
  var x =  document.querySelectorAll('.btnDelete');

  for (var i = 0; i < x.length; i++) {
    x[i].addEventListener('click', function() {
      console.clear();
      console.log("You clicked:", this.value);

      var showForm = document.querySelector("#create-ticket-popup");
      showForm.style.opacity = "1";
      showForm.style.left = "auto";

        
      var dash = document.querySelector(".form-style-tickets");
      var wrapper = document.querySelector("#wrapper");

      dash.style.opacity = "0.1";
      wrapper.style.backgroundColor = "rgb(34, 33, 33)";
      wrapper.style.transition = "all 1s";


      var p = document.querySelector("#delete-p");
      p.textContent = "You are about to delete the ticket with the ID of: " + this.value + ". This process cannot be undone and once executed there will be no records available.";
      var x = document.querySelector("#form-btn-delete");
      x.setAttribute("value", this.value);
      x.setAttribute("type", "submit");
      x.setAttribute("name", "delete-ticket");
      document.querySelector(".btn-div").appendChild(x);


      document.querySelector("#form-btn-close").addEventListener("click", function() {
  
        showForm.style.opacity = "0";
        showForm.style.left = "-999em";
        dash.style.opacity = "1";    
        wrapper.style.backgroundColor = "lightgrey";
        
      });

    });
  }
}