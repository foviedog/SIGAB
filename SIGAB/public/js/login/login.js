// Incorpara el 'API' dentro del html
var textWrapper = document.querySelector(".ml1 .letters");
textWrapper.innerHTML = textWrapper.textContent.replace(
    /\S/g,
    "<span class='letter'>$&</span>"
);

anime
    /* Al ponerse en false solamente se hace una vez*/
    .timeline({ loop: false })
    /* Aparecer letras  SIGAB*/
    .add({
        targets: ".ml1 .letter",
        scale: [0.3, 1],
        opacity: [0, 1],
        translateZ: 0,
        easing: "easeOutExpo",
        duration: 900,
        delay: (el, i) => 70 * (i + 1)
    })
    /* Lineas de arriba y abajo de las letras SIGAB */
    .add({
        targets: ".ml1 .line",
        scaleX: [0, 1],
        opacity: [0.9, 1],
        easing: "easeOutExpo",
        duration: 2000,
        offset: "-=875",
        delay: (el, i, l) => 80 * (l - i)
    });
/* Desaparecer letras SIGAB*/

/*.add({
        targets: ".ml1",
        opacity: 0,
        duration: 1000,
        easing: "easeOutExpo",
        delay: 1000,
    })*/
