/**
 * Custom by 2019
 **/
;(function ($) {
    $.isMobileTablet = function(){
        if(navigator.userAgent.match(/Android/i)|| navigator.userAgent.match(/webOS/i)|| navigator.userAgent.match(/iPhone/i)|| navigator.userAgent.match(/iPad/i)|| navigator.userAgent.match(/iPod/i)|| navigator.userAgent.match(/BlackBerry/i)|| navigator.userAgent.match(/Windows Phone/i)|| navigator.userAgent.match(/bada/i)|| navigator.userAgent.match(/Bada/i)||(navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i)))
            return 1;
        return 0;
    };

    /*Check if component exists*/
    $.fn.isExists = function() {
        return this.length > 0;
    };

    // ==== Check is Mobile
    $.isMobile = function(widthScreen) {
        if(widthScreen < 768)
            return 1;
        return 0;
    };

    $.isDevice = function() {
        if($('html').hasClass('mobile'))
            return 1;
        return 0;
    };

    $.fn.outerHTML = function() {
        // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
        return (!this.length) ? this : (this[0].outerHTML || (
            function(el){
                var div = document.createElement('div');
                div.appendChild(el.cloneNode(true));
                var contents = div.innerHTML;
                div = null;
                return contents;
            })(this[0]));

    };

    $.createDotDotDot = function(target){
        if($(target).length > 0) {
            $(target).dotdotdot();
        }
    };

    $.createTonggleDropdown = function(index, element) {
        if (!jQuery(element).is(index.target) && jQuery(element).has(index.target).length === 0) {
            $(element).find('.block-title').removeClass('active');
            $(element).find('.block-content').removeClass('selected');
        }
    };

    /* Begin Tabs */
    $.fn.createTabs = function() {
        let selector = this;

        this.each(function() {
            let obj = $(this);
            $(obj.attr('href')).hide(0);

            $(obj).on('click', function() {
                $(selector).removeClass('selected');

                $(selector).each(function(i, element) {
                    $($(element).attr('href')).removeClass('selected');
                    $($(element).attr('href')).removeAttr('style');
                    $($(element).attr('href')).hide(0);
                });

                $(this).addClass('selected');
                $($(this).attr('href')).addClass('selected');
                $($(this).attr('href')).css('display', 'block');

                $($(this).attr('href')).show(0, function () {
                    setTimeout(function() {

                    }, 100);
                });

                return false;
            });
        });

        $(this).show(0);
        $(this).first().click();
    };
})(jQuery);

// =============================
// Shota Harada Scripts 2017
// =============================
$(document).ready(function () {
    Modernizr.addTest('ios', function () {
        return navigator.userAgent.match(/(iPad|iPhone|Android|BlackBerry|Windows Phone|webOS|iPod)/i);
    });

    // =============================================
    // Skip Links
    // =============================================
    var skipLinks = $('.skip-link');
    var skipContents = $('.skip-content');

    skipLinks.on('click', function (e) {
        e.preventDefault();

        let self = $(this);
        let target = self.attr('data-target-element') ? self.attr('data-target-element') : self.attr('href');
        let elem = $(target);
        var isSkipContentOpen = elem.hasClass('skip-active') ? 1 : 0;

        // Hide all stubs
        skipLinks.removeClass('skip-active');
        skipContents.removeClass('skip-active');

        // Toggle stubs
        if (isSkipContentOpen) {
            self.removeClass('skip-active');
        } else {
            self.addClass('skip-active');
            elem.addClass('skip-active');
        }
    });

    // Click outSite hide Element
    $(document).mouseup(function (e){
        if(!$(e.target).closest(skipLinks).length && !$(e.target).closest(skipContents).length){
            skipLinks.removeClass('skip-active');
            skipContents.removeClass('skip-active');
        }
    });
});