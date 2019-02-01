var $body = $('body');

$body.on('submit','form.ajax',function(e) {
    e.preventDefault();
    var $this = $(this);
    var data = new FormData(this);
    data.append('not_spam', '1');
    $.ajax({
        url: "/send_request/",
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function() {
            $this.find('.result_form').html('Спасибо. Мы перезвоним вам в ближайшее время.');
            $this.find('.result_form').addClass("alert alert-success");
            $this.find("input:not([type='hidden'])").val("");
        },
        error: function() {
            $this.find('.result_form').html('Ошибка.');
            $this.find('.result_form').addClass("alert alert-danger");
            $this.find("input:not([type='hidden'])").val("");
        }
    });
    e.preventDefault();
});

$(document).ready(function () {
	$(".reviews__answer:not(.reviews__answer--right-photo), .footer__box--left, .staff > .staff__row:odd, .articles-list__title, .treatment-list, .section-pain .text, .pain-forms .text, .about-section ").animated("fadeInLeft", "fadeInLeft");
	$(".reviews__answer--right-photo, .footer__box--right, .slider__cont-text, .staff > .staff__row:even, .articles-list__text").animated("fadeInRight", "fadeInRight");
	$(".section-title, .section-line, .footer__text, .content__title, .content__line, .bottomForm__form").animated("fadeInDown", "fadeInDown");
	$(".galleria-license__item, .prices-table, .bottomForm__title").animated("fadeInUp", "fadeInUp");



    $body.on("click", ".button-show-form", function(){
        $(".ajax input:not([type='hidden'])").val("");
        var $resultPanel = $(".ajax .result_form ");
        $resultPanel.html("");
        $resultPanel.removeAttr("class");
        $resultPanel.addClass("result_form");
    });

    $('#carouselSlideMedika').carousel({
        interval: 4000
    });
    $(".dropdown-toggle").dropdown();

    var scrolled=0;

    $(".arrow-down").on("click" ,function(){
        scrolled=scrolled+120;
        $("html").animate({
            scrollTop:  scrolled
        }, 100);

    });

});
