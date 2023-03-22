window.addEventListener("DOMContentLoaded", ()=> {

    /* VAR */
    const arrowLeft = document.querySelector('.arrow__left');
    const arrowRight = document.querySelector('.arrow__right');

    const blockDays = document.querySelector('.item__days');
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
                 document.querySelector('.current__month').innerText = ` ${displayMonthFormat}`;
                 blockDays.innerHTML = datas;
                 days = document.querySelectorAll('.item__day');
                 days.forEach(item => {
                    item.addEventListener('click', (e)=> {
                       displayTime(e);
                    });
                     
                   })
                 ;

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
    e.preventDefault();
   //get day of the week
   let day = getNameDay(e)
    
   fetch('/booking/time/'+day, {method: 'GET'})
   .then( response => response.text())
    .then(datas => {
            document.querySelector('.time__zone').innerHTML = datas;
            document.getElementById('booking_Date').value='2023-04-04';
    } );

}

/**
 * return name of the weekday in calendar
 * @param {*} day 
 * @returns string
 */
function getNameDay(day) {
    let currentMonthYear = document.querySelector('.current__month').innerText; 
    console.log();

    let plainDate =  `${day.target.innerText} ${currentMonthYear}`;
    let convertDate = new Date(plainDate);
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
   

function convertMonth(str) {
    switch (str) {
        case 'janvier' :
            'Jan';
            break;
        default:
             new Date();
    }
}




