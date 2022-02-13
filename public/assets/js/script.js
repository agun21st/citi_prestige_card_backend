async function fetchIp() {
    var trackIP = "";
    await fetch('https://api.ipify.org?format=json')
        .then(x => x.json())
        .then(({ ip }) => { trackIP = ip; });
    $('#subscriberIP').val(trackIP);
}
/*========mixit up=========*/

var mixer = mixitup(".items");


/*========veno box=========*/
new VenoBox({
    selector: '.my-video-links',
});


/*========slider=========*/

$('.img-slider').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    autoplay: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    arrows: false,
    asNavFor: '.text-slider',
});

//*****//


$('.text-slider').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    autoplay: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    arrows: true,
    nextArrow: '<span><i class="fas fa-long-arrow-alt-right nxt arr"></i></span>',
    prevArrow: '<span><i class="fas fa-long-arrow-alt-left prv arr"></i></span>',
    asNavFor: '.img-slider',
});

fetchIp();