/**
 * Convert string type "month + year" with month in FR into month in english
 * @param {*} string
 * @returns
 */
function convertMonthFrtoEn(str) {
  let getMonth = str.split(" ")[0];
  let getYear = str.split(" ")[1];

  let monthEn;
  switch (getMonth) {
    case "janvier":
      monthEn = "jan";
      break;
    case "février":
      monthEn = "fev";
      break;
    case "mars":
      monthEn = "mar";
      break;
    case "avril":
      monthEn = "apr";
      break;
    case "mai":
      monthEn = "may";
      break;
    case "juin":
      monthEn = "jun";
      break;
    case "juillet":
      monthEn = "jul";
      break;
    case "août":
      monthEn = "aug";
      break;
    case "septembre":
      monthEn = "sep";
      break;
    case "octobre":
      monthEn = "oct";
      break;
    case "novembre":
      monthEn = "nov";
      break;
    case "décembre":
      monthEn = "dec";
      break;
    //   default:
    //     monthEn = 'jan'
  }
  return `${monthEn} ${getYear} `;
}

/**
 * return format  d-m-Y into format YYY-MM-DD
 * @param {*} str
 * @returns
 */
function convertDateFormat(str) {
  const year = str.toLocaleString("default", { year: "numeric" });
  const month = str.toLocaleString("default", { month: "2-digit" });
  const day = str.toLocaleString("default", { day: "2-digit" });

  return `${year}-${month}-${day}`;
}


/**
 * Add an event click on multiple elements with a callback function
 * @param {} el
 * @param {*} callback
 */
function addEvent(el, callback) {
  el.forEach((item) => {
    item.addEventListener("click", callback);
  });
}


function desactiveDay(item, fn) {
  let i=0;
  while( parseInt(item[i].innerText) > 1) {
    item[i].removeEventListener('click', fn);
    item[i].classList.remove('item__day');
    item[i].classList.add('item__day--desactive')
  
    i++;
  }
 

  

}


export { convertMonthFrtoEn, convertDateFormat, addEvent, desactiveDay };
