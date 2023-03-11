window.addEventListener('DOMContentLoaded', () => {
  

    
    // MENU TOGGLE
    const hamburger = document.querySelector('.navbar__hamburger');
    const navbar = document.querySelector('.navbar__list');

    function openMenu(){
        hamburger.classList.toggle('active');
        navbar.classList.toggle('show');
        if(hamburger.classList.contains('active')) {
            document.querySelector('html').style.overflow = 'hidden';
        } else {
            document.querySelector('html').style.overflow = 'visible';
        }

    }

    hamburger.addEventListener("click", openMenu);


    // Gestion Carrousel
    const carrousel = document.querySelector('.carrousel__wrapper');
    if(carrousel) {


    
    

    const slides = Array.from(document.querySelectorAll('.carrousel__pics'));
    
    const previous = document.getElementById('arrow-left');
    const next = document.getElementById('arrow-right');
    
    
    let count = 0;
    let carrouselWidth = carrousel.getBoundingClientRect().width;

    //Duplicate first image into last slider
    let firstImg = carrousel.firstElementChild.cloneNode(true);
    carrousel.appendChild(firstImg);
    

    /**
     * display next slide 
    */
   function nextSlide() {
       count++;
       carrousel.style.transition = "1s linear";
       let rate = count * (-carrouselWidth);
       carrousel.style.transform = `translateX(${rate}px)`;
       
       setTimeout( ()=> {
            if(count >= slides.length) {
                count = 0;
                carrousel.style.transition = "unset";
                carrousel.style.transform = "translateX(0)";
            }
        } , 1000);
    }
    
     /**
      * display previous slide
      */
    function prevSlide(){
        count--;
        carrousel.style.transition = "1s linear";

        if(count < 0) {
            count = slides.length;
            let rate = count * (-carrouselWidth);
            carrousel.style.transition = "unset";
            carrousel.style.transform = `translateX(${rate}px)`;
            setTimeout(prevSlide,1);
        }

        let rate = count * (-carrouselWidth);
        carrousel.style.transform = `translateX(${rate}px)`;
    };

    //slider automatic
    let sliderAutomatic = setInterval(nextSlide, 3000);

    carrousel.addEventListener('mouseout', ()=> {
        sliderAutomatic= setInterval(nextSlide,3000);
    });
    
    carrousel.addEventListener('mouseover', ()=> {
        clearInterval(sliderAutomatic);
    });

    //slider manual
    next.addEventListener("click", nextSlide);
    previous.addEventListener('click', prevSlide);
    }

    //display modal cancel action (customer page)
    const btnDispalyModal = document.querySelector('#modalCancel');

    if(btnDispalyModal) {
        let idBooking;
        let path;

        const modal = document.querySelector('.modal__wrapper');
        const btnCancel = document.querySelector('#btn__cancel');
        const btnValid = document.querySelector('#btn__valid');
        
        
        btnDispalyModal.addEventListener('click', (e) => {
            modal.classList.add('active');
            idBooking = e.target.dataset.id;
            path = e.target.dataset.path;
            

        })
        
        btnCancel.addEventListener('click', ()=> {
            modal.classList.remove('active');
       })

       btnValid.addEventListener('click', ()=> {
        location.href = `${path}/${idBooking}`;
       })

    }
})

