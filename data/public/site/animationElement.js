$(document).ready(function () {
	$(".reviews__answer:not(.reviews__answer--right-photo), .footer__box--left, .staff > .staff__row:odd").animated("fadeInLeft", "fadeInLeft");
	$(".reviews__answer--right-photo, .footer__box--right, .slider__cont-text, .staff > .staff__row:even").animated("fadeInRight", "fadeInRight");
	$(".section-title, .section-line, .footer__text, .content__title, .content__line").animated("fadeInDown", "fadeInDown");
	$(".galleria-license__item, .prices-table").animated("fadeInUp", "fadeInUp");

	$("form.ajax").submit(function(e) {
        $.ajax({
            url: "/send_request/",
            type: "POST",
            dataType: "html",
            data: $(".ajax").serialize(),
            success: function(response) {
                result = $.parseJSON(response);
                $('.result_form').html('Сасайкудасай иди пешком сюда и в лицо скажи');
                $('.result_form').addClass("alert alert-success");
            },
            error: function(response) {
                $('.result_form').html('Ошибка.');
                $('.result_form').addClass("alert alert-danger");
            }
        });
        e.preventDefault();
	});

    $("body").on("click", ".button-show-form", function(){
        $(".ajax input").val("");
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
        });

    });

});
