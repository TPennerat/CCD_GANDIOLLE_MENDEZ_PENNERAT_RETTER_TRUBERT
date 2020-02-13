window.addEventListener('load', () => {

let changer = function changer(e) {
  let el = $(e.target).parent().parent();
  function slide(e) {
      el.slideToggle(400,"swing");
  }
  let id = el.attr("id");
  alert("Vous avez supprimé une permanence");
  let xhr = new XMLHttpRequest();
xhr.open('GET',
 'https://webetu.iutnc.univ-lorraine.fr/www/pennerat7u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/supprimerMonOption/' + id);
 xhr.addEventListener("load",
  slide);
xhr.send();


}

let elem = $('.peutEtreSupprime1')
elem.on("click",changer)

});
