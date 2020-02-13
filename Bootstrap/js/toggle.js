window.addEventListener('load', () => {

let changer = function changer(e) {

  $(e.target).parent().parent().toggleClass("overview-item--c7").toggleClass("overview-item--c8");
}


let elem = $('.aModifier2')
elem.on("click",changer)

});
