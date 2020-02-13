window.addEventListener('load', () => {

let changer = function changer(e) {
  let el = $(e.target).parent().parent();
  el.toggleClass("overview-item--c7").toggleClass("overview-item--c8");
  let id = el.attr("id");

  let xhr = new XMLHttpRequest();
xhr.open('GET',
 'https://webetu.iutnc.univ-lorraine.fr/www/gandioll4u/CCD_GANDIOLLE_MENDEZ_PENNERAT_RETTER_TRUBERT_JENIN/changerActivitee/' + id);
xhr.send();


}

let elem = $('.aModifier2')
elem.on("click",changer)

});
