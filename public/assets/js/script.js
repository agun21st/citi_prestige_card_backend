$(function() {

    $("#searchByCategory").change(function() {
        if (this.value != 0) {
            $.ajax({
                url: 'get-brand-by-id/' + this.value,
                type: 'get',
                success: function(res) {
                    $("#searchBrands").empty();
                    var brandList = "<option value=''>Brand</option>";
                    var addBrand = "";
                    (res.success).forEach(brand => {
                        addBrand += `<option value="${brand["id"]}">${brand["name"]}</option>`
                    });
                    // console.log(brandList + addBrand);
                    $("#searchBrands").append(brandList + addBrand);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        } else {

        }
    });
});

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