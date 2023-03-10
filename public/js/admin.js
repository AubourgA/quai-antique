document.addEventListener('DOMContentLoaded', function(){

    const graphBooking = document.querySelector('#booking__graph');
    let days = [];
    let tabLunch = document.querySelector('.js-tab-lunch');
    let tabDinner = document.querySelector('.js-tab-dinner');
    let tabDate = document.querySelector('.js-tab-date');

    
    let dataLunch = JSON.parse(tabLunch.dataset.abs, true);
    let dataDinner = JSON.parse(tabDinner.dataset.abs, true);
    let dataDate= JSON.parse(tabDate.dataset.abs, true);
    // let dataDinner = [25,40,30,45,85,12];
    
  

   




    const data = {
    //   labels: ['Janvier','fev','mar','avr','mai','juin'],
        labels: dataDate,
      datasets: [
        {
        data: dataLunch,
        label: "Midi",
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)'
        ]
      },
      {
        data: dataDinner,
        label: "Soir",
        backgroundColor: [
          'rgba(155, 79, 432, 0.7)'
        ]
      }
    ]
    };

    const config = new Chart( graphBooking, {
        type: 'bar',
        data: data,
        options: {
          plugins: {
            legend: {
                display:true
            }
          },
          scales: {
            y: {
                stacked:true,
                grid: {
                    display:false
                }
            },
            x: {
                stacked:true,
                grid: {
                    display:false
                }
            }
          },
          responsive:true,
        },
      })
    
})


