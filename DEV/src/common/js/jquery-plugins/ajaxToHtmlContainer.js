
import 'jquery'
(function ($) {
    $.fn.ajaxToHtmlContainer = function (options) {
        let defaults = {
            url: window.ajaxurl
        }
        const settings = { ...defaults, ...options }

        if (this.length > 1) {
            this.each(function() { $(this).ajaxToHtmlContainer(options) });
            return this;
        }

        this.initialise = function () {
            console.log('test', this)
            return this
        }

        return this.initialize();
    }
})(jQuery)