/**/
/* Custom by Scripts 2017 */
/**/
if (typeof Scripts == "undefined") {
    var Scripts = {};
}

Scripts.Modules = {
    winWidth: $(window).width(),
    scrollToTop: $(window).scrollTop(),
    init: function () {
        /* Define Scrollbar */
        const container = document.querySelectorAll('.scrollWrapper');
        for(let i = 0; i < container.length; i++){
            new PerfectScrollbar(container[i], {
                suppressScrollX: true
            });
        }

        $('[data-toggle="tooltip"]').tooltip();

        this.createMenuMobile();
        this.getModalPopup();
        this.scrollToComment();
        this.creatEventSlider();
        this.windowScrollTop();
    },
    createMenuMobile: function () {
        if ($('header .btn-navbar').length > 0) {
            var event = "click";

            if($('html').hasClass('mobile')){
                event = 'touchstart';
            }

            $(document).on(event, ".btn-navbar", function(){
                if ($('html').hasClass('nav-open')) {
                    $('html').removeClass('nav-open');
                    console.log($('html').attr('class'));
                } else {
                    $('html').addClass('nav-open');
                    console.log($('html').attr('class'));
                }
            });
        }
    },
    creatEventSlider: function () {
        if ($('.block-top-event-slider .event-slider-home').length > 0) {
            $(".event-slider-home").slick({
                dots: true,
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 7000,
                appendDots: ".block-top-event-slider .block-top-event-slider-inner",
            });
        }
    },
    getModalPopup: function() {
        $('#gNav_ModalPopupConfirm').on('show.bs.modal', function (event) {
            let modal = $(this);
            let button = $(event.relatedTarget);

            //let modal_title = button.data('title');
            let modal_id = button.data('id');
            let modal_content = button.data('content');
            let modal_button = button.data('button');
            let modal_class = modal_button;

            modal.find('#confirmContent').text('');
            modal.find('#confirmButton').removeAttr('data-id');
            modal.find('#confirmButton').removeClass(modal_button);

            modal.find('#confirmContent').text(modal_content);
            modal.find('#confirmButton').addClass(modal_class);
            modal.find('#confirmButton').attr('data-id', modal_id);
        });

        $('#gNav_ModalPopupConfirm, #gNav_ModalUserLevelUpGrade').on('click', '.close-popup', function (event) {
            $(this).parents().modal('hide');
        });
    },
    scrollToComment: function () {
        let currentLocation = window.location;

        if (currentLocation.hash != '' && $(currentLocation.hash).length > 0) {
            $(currentLocation.hash).find('textarea.form-control').focus();

            $('body, html').animate({
                scrollTop: $(currentLocation.hash).offset().top
            }, 0);
        }
    },
    windowScrollTop: function () {
        var self = this;

        $(window).scroll(function () {
            let scrollHeight = $(document).height();
            let scrollPosition = $(this).scrollTop() + $(window).height();
            let footHeight = $("footer").innerHeight();

            let totalScroll = scrollHeight - scrollPosition;

            if (self.winWidth <= 767) {
                if ($(this).scrollTop() > 50) {
                    //$('header .btn-navbar').addClass('fixed');
                    $('#nav-left-sidebar').addClass('fixed');
                } else {
                    //$('header .btn-navbar').removeClass('fixed');
                    $('#nav-left-sidebar').removeClass('fixed');
                }

                $('#nav-left-sidebar').removeClass('addSticky');
            } else {
                //$('header .btn-navbar').removeClass('fixed');
                $('#nav-left-sidebar').removeClass('fixed');

                if ($(this).scrollTop() > 110) {
                    $('#nav-left-sidebar').addClass('addSticky');
                } else {
                    $('#nav-left-sidebar').removeClass('addSticky');
                }
            }

            if (totalScroll < footHeight) {
                $("#staticBlockEvent").removeAttr('style');
                //$('#backToTop').addClass('fixbutton');
            } else {
                $("#staticBlockEvent").css('position', 'fixed');
                //$('#backToTop').removeClass('fixbutton');
            }

            if ($(this).scrollTop() > 100) {
                $('#backToTop').css('opacity', 1);
            } else {
                $('#backToTop').css('opacity', 0);
            }

            /*if ( scrollHeight - scrollPosition  <= footHeight ) {
                $("#backToTop").css({
                    "position":"absolute",
                    "bottom": footHeight + 20
                });
            } else {
                $("#back-top").css({
                    "position":"fixed",
                    "bottom": "20px"
                });
            }*/
        });

        $('#backToTop > a').on('click', function () {
            $('body, html').animate({
                scrollTop: 0
            }, 600);

            return false;
        });
    }
};

$(document).ready(function () {
    Scripts.Modules.winWidth = $(window).width();
    Scripts.Modules.init();

    $('.unread-notification').click(function(){
        var id = $(this).attr('data-id');

        $.ajax({
            url: '/user-setting/ajaxUpdateViewNotification',
            type: "post",
            data: {
                id:id,
            },
        });
    });

    $('.read_all_notification').click(function(){
        $.ajax({
            url: '/user-setting/ajaxRealAllNotification',
            type: "post",
            success: function() {
                $('.notification-list').find('.unread').removeClass('unread');
                $('.count_unread_notification').remove();
            }
        });
    });
});

var windowResize;

$(window).resize(function () {
    let winNewWidth = $(window).width();

    if (Scripts.Modules.winWidth != winNewWidth) {
        clearTimeout(windowResize);

        windowResize = setTimeout(function() {
            Scripts.Modules.winWidth = winNewWidth;
            Scripts.Modules.windowScrollTop();
        }, 100);
    }
});

