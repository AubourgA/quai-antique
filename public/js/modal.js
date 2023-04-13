 let btnDispalyModal = document.querySelector('#modalCancel');

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