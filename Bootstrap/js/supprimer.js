window.addEventListener('load', () => {

let changer = function changer(e) {
  console.log("ee")
  let el = $(e.target).parent().parent();
  function slide(e) {
    if(e.target.responseText == 1) {
      el.slideToggle(400,"swing");
    }
  }
  let id = el.attr("id");
  alert("Faites gaffe");
  let xhr = new XMLHttpRequest();
xhr.open('GET',
 'https://webetu.iutnc.univ-lorraine.fr/www/gandioll4u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/supprimerMonOption/' + id);
 xhr.addEventListener("load",
  slide);
xhr.send();


}

let elem = $('.peutEtreSupprime1')
elem.on("click",changer)

});
