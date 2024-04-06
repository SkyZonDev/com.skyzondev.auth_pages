var progressBar = $(".progress-bar"),
    bar = $(".bar"),
    boxes = $(".box"),
    btnNext = $(".button-next"),
    btnReturn = $(".button-previous");

btnNext.on("click", ()=> {
    for (let i = 0; i < boxes.length; i++) {
        var wdt = 100/3
        currentWidth = bar.width() / bar.parent().width() * 100
        if(boxes.eq(i).hasClass("active")) {
            boxes.eq(i).addClass("check").removeClass("active");
            boxes.eq(i+1).addClass("active");
            bar.css("width", wdt*(i+2) + "%");
            return;
        }
    }
});
btnReturn.on("click", ()=> {
    for (let i = 0; i < boxes.length; i++) {
        var wdt = 100/3
        currentWidth = bar.width() / bar.parent().width() * 100
        if(boxes.eq(i).hasClass("active")) {
            boxes.eq(i).removeClass("active");
            boxes.eq(i-1).addClass("active").removeClass("check");
            bar.css("width", wdt*(i) + "%");
            return;
        }
    }
});