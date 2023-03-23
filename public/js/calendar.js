window.addEventListener("DOMContentLoaded", ()=> {

    /* VAR */
    const arrowLeft = document.querySelector('.arrow__left');
    const arrowRight = document.querySelector('.arrow__right');

    const blockDays = document.querySelector('.item__days');
    let currentMonth = document.querySelector('.current__month');
    let days = document.querySelectorAll('.item__day');
    
    let click = 1;

    /**
     * Generate next month in calendar
     * @returns void
     */
    function getNextMonth() {
        click++;
            
        let currentDate = new Date();
        
        //get parameter for fetch API
        let month = currentDate.getMonth() + click ;
        let  year = currentDate.getFullYear();
        
        let displayMonth = add_months(new Date(currentDate), click - 1);
        let displayMonthFormat = displayMonth.toLocaleDateString('fr-fr', { month: 'long', year: 'numeric'});
        
        
        fetch('/booking/'+month+'-'+year, {method: 'GET'})
            .then( response => response.text())
            .then( datas => {
                currentMonth.innerText = ` ${displayMonthFormat}`;
                 blockDays.innerHTML = datas;
                 days = document.querySelectorAll('.item__day');
                 days.forEach(item => {
                    item.addEventListener('click', (e)=> {
                       displayTime(e);
                    });
                   });
          }
        )

        //condition only 3 months
        // if(click > 3) {
        //     // arrowRight.style.visibility = "hidden";
        //     return;
        // }
    }
    
    function getPreviousMonth() {
        click--;
        if(click > 2) {
            console.log(click);
            arrowRight.style.display = "block";
        }
    }


    days.forEach( item => {
        item.addEventListener('click', displayTime);
    })


    /* MAIN FUNCTION*/
    arrowRight.addEventListener('click', ()=> {
     getNextMonth();

    })

    arrowLeft.addEventListener('click', ()=> {
        getPreviousMonth();
    })
    
})



/**
 * display different time for booking  in grid
 * @param {*} e 
 */
function displayTime(e) {
   //get day of the week
   let day = getNameDay(e)

   fetch('/booking/time/'+day, {method: 'GET'})
   .then( response => response.text())
    .then(datas => {
            document.querySelector('.time__zone').innerHTML = datas;
        }
    );
    
   let displayDate = new Date(`${e.target.innerText} ${convertMonthFrtoEn(document.querySelector('.current__month').innerText)}`);
    // display in reservation
    document.getElementById('booking_Date').value= convertDateFormat(displayDate);
}

/**
 * return name of the weekday in calendar
 * @param {*} day 
 * @returns string
 */
function getNameDay(day) {
    let currentMonthYear = document.querySelector('.current__month').innerText; 
    let convertDateFrtoEn = convertMonthFrtoEn(currentMonthYear);

    let fullDate =  `${day.target.innerText} ${convertDateFrtoEn}`;
   
    let convertDate = new Date(fullDate);
    return convertDate.toLocaleDateString('local', {weekday: 'long'});
}

/**
 * Modify current month in adding month
 * @param {*} date 
 * @param {*} month 
 * @returns date
 */
function add_months(date, month) 
 {
   return new Date(date.setMonth(date.getMonth() + month));      
 }
   
/**
 * Convert string type "month + year" with month in FR into month in english
 * @param {*} string 
 * @returns 
 */
 function convertMonthFrtoEn(str) {
    let getMonth = str.split(' ')[0];
    let getYear = str.split(' ')[1];
    
    let monthEn;
    switch (getMonth) {
      case 'janvier':
        monthEn = 'jan';
        break;
      case 'février':
        monthEn = 'fev';
        break;
      case 'mars':
        monthEn = 'mar';
        break;
      case 'avril':
        monthEn = 'apr';
        break;
      case 'mai':
        monthEn = 'may';
        break;
      case 'juin':
        monthEn = 'jun';
        break;
      case 'juillet':
        monthEn = 'jul';
        break;
      case 'août':
        monthEn = 'aug';
        break;
      case 'septembre':
        monthEn = 'sep';
        break;
      case 'octobre':
        monthEn = 'oct';
        break;
      case 'novembre':
        monthEn = 'nov';
        break;
      case 'décembre':
        monthEn = 'dec';
        break;
    //   default:
    //     monthEn = 'jan'
        
    }
    return `${monthEn} ${getYear} `;
  }
  

// console.log('ici :' + convertDateFormat(new Date('02 apr 2023')));
let test = convertDateFormat(new Date('02 apr 2023'));

/**
 * return format in d-m-Y into format YYY-MM-DD
 * @param {*} str 
 * @returns 
 */
function convertDateFormat(str) {
  
  const year = str.toLocaleString('default', {year : 'numeric'});
  const month = str.toLocaleString('default', {month : '2-digit'});
  const day = str.toLocaleString('default', {day : '2-digit'});
  
  console.log(`${year}-${month}-${day}`);
  return `${year}-${month}-${day}`
    
}


