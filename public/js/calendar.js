import { convertDateFormat, convertMonthFrtoEn, addEvent } from "./utils.js";

window.addEventListener("DOMContentLoaded", () => {
  /* VAR */
  const arrowLeft = document.querySelector(".arrow__left");
  const arrowRight = document.querySelector(".arrow__right");

  const blockDays = document.querySelector(".item__days");
  let currentMonth = document.querySelector(".current__month");
  let days = document.querySelectorAll(".item__day");

  let click = 1;

  /**
   * Generate next month in calendar
   * @returns void
   */
  function getNextMonth() {
    click++;
    //reset alert message
    document.getElementById('message').innerText = "";

    let currentDate = new Date();

    //get parameter for fetch API
    let month = currentDate.getMonth() + click;
    let year = currentDate.getFullYear();

    let displayMonth = add_months(new Date(currentDate), click - 1);
    let displayMonthFormat = displayMonth.toLocaleDateString("fr-fr", {
      month: "long",
      year: "numeric",
    });

    if(currentMonth != null) {
      fetch("/booking/" + month + "-" + year, { method: "POST" })
        .then((response) => response.text())
        .then((datas) => {
          currentMonth.innerText = ` ${displayMonthFormat}`;
          blockDays.innerHTML = datas;
          days = document.querySelectorAll(".item__day");
          addEvent(days, displayTime);
        });
    }
  }

  /* A FINIR */
  function getPreviousMonth() {
    click--;
    //reset alert message
    document.getElementById('message').innerText = "";

    if (click > 2) {
      console.log(click);
      arrowRight.style.display = "block";
    }
  }

  /* MAIN FUNCTION*/
  arrowRight.addEventListener("click", () => {
    getNextMonth();
  });

  arrowLeft.addEventListener("click", () => {
    getPreviousMonth();
  });

  addEvent(days, displayTime);

});

/**
 * Modify current month in adding month
 * @param {*} date
 * @param {*} month
 * @returns date
 */
function add_months(date, month) {
  return new Date(date.setMonth(date.getMonth() + month));
}



/**
 * return name of the weekday in calendar
 * @param {*} day
 * @returns string
 */
function getNameDay(day) {
  let currentMonthYear = document.querySelector(".current__month").innerText;
  let convertDateFrtoEn = convertMonthFrtoEn(currentMonthYear);

  let fullDate = `${day.target.innerText} ${convertDateFrtoEn}`;

  let convertDate = new Date(fullDate);
  return convertDate.toLocaleDateString("local", { weekday: "long" });
}

/**
 * display different time for booking  in grid
 * @param {*} e
 */
function displayTime(e) {
  //reset message alert
  document.getElementById('message').innerText = "";
  
  //get day of the week
  let day = getNameDay(e);
  const responseAjax = document.querySelector(".time__zone");

  if( responseAjax != null) {
    fetch("/booking/time/" + day, { method: "POST" })
      .then((response) => response.text())
      .then((datas) => {
        responseAjax.innerHTML = datas;
        checkHour();
      });
  }
 
  // complete data in  BOOKING FORM
  let displayDate = new Date(
    `${e.target.innerText} ${convertMonthFrtoEn(
      document.querySelector(".current__month").innerText
    )}`
  );
  
  document.getElementById("booking_Date").value = convertDateFormat(displayDate);
  
}



function checkHour() {
  const periodsTime = document.querySelectorAll('.list__time');
  let formDate = document.getElementById("booking_Date").value;
 
  if(periodsTime != null) {

    periodsTime.forEach( item => {
      item.addEventListener('click', function(e) {
       let  hour = e.target.innerText;
       fetch("/booking/check/" + formDate + "/" + hour, { method: "POST" })
           .then( reponse => reponse.json())
           .then( datas => {
            if(datas.isAvailable === true) {
              document.getElementById('booking_time').value = hour;
            }
            else {
              document.getElementById('message').innerText = 'Plus de place disponible. Veuillez choisir une autre date'
            }
           });
       
      })
      
       })
   
  
  }
  else {
    alert("pas de valuer");
  }

}







