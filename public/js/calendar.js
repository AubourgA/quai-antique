window.addEventListener("DOMContentLoaded", ()=> {

    const arrowLeft = document.querySelector('.arrow__left');
    const arrowRight = document.querySelector('.arrow__right');

    const blockDays = document.querySelector('.item__days');

    let click = 1;
    



    arrowRight.addEventListener('click', (e)=> {
    
        click++;
        
        let currentDate = new Date();
        
        
        //get parameter for fetch API
        let month = currentDate.getMonth() + click;
        let  year = currentDate.getFullYear();
        
        let displayMonth = add_months(new Date(currentDate), click - 1);
        let displayMonthFormat = displayMonth.toLocaleDateString('fr-fr', { month: 'long', year: 'numeric'});
        
        
        fetch('/booking/'+month+'-'+year)
                .then( response => response.text())
                .then( datas => {
                    document.querySelector('.current__month').innerText = ` ${displayMonthFormat}`;
                    blockDays.innerHTML = datas;
                }
            )
        
        /* A MODIFIER */
        if (month % 12 === 0) {
        click = -1 ;
        }

    })

})



function add_months(date, month) 
 {
   return new Date(date.setMonth(date.getMonth() + month));      
 }
   



