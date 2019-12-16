import 'jquery'

(function ($) {
    $.fn.ajaxToHtmlContainer = function (options) {
        const $this = $(this)
        let defaults = {
            url: window.ajaxurl,
            dataProvider: null,
            logEvents: false
        }

        const settings = {...defaults, ...options}

        if (this.length > 1) {
            this.each(function () {
                $(this).ajaxToHtmlContainer(options)
            });
            return this;
        }

        const $bodyEl = $($this.data('bodySelector'))
        const triggerEvent = $this.data('triggerEvent')
        const triggerSelector = $this.data('triggerSelector')
        const action = $this.data('action')

        this.initialize = function () {
            if (triggerEvent === 'immediate') {
                doAjax().then(function () {
                    if (settings.logEvents) {
                        console.info('doAjax:immediate, action:' + action)
                    }
                })
            } else {
                console.info('BOUND: ' + triggerSelector + ' on ' + triggerEvent)
                $(triggerSelector).on(triggerEvent, function (e) {
                    console.log($(e.currentTarget).data('ajaxAction'), action)
                    if ($(e.target).data('ajaxAction') !== action) {
                        //console.error('Error. The trigger element action does not match this element.')
                        return;
                    }
                    doAjax().then(function () {
                        if (settings.logEvents) {
                            console.info('doAjax:' + triggerSelector + ' | ' + triggerEvent + ' , action:' + action)
                        }
                    })
                })
            }
            return this
        }


        async function doAjax() {

            //Get data from a provider function if one is declared
            let providerData = {};
            if ( typeof settings.dataProvider === 'function') {
                providerData = settings.dataProvider()
            }

            //Add a progress bar
            $bodyEl.html('<div class="progress" style="position: relative;"><div class="progress-bar progress-bar-striped indeterminate"></div></div>');

            $.post(
                {
                    dataType: 'html',
                    url: settings.url,
                    data: $.extend({}, {action: action},  providerData)
                }
            )
                .done(function (result) {
                    $bodyEl.html(result);
                    if(typeof settings.onDone === 'function'){ settings.onDone(result) }
                })
                .fail(function (err) {
                    $bodyEl.html('<div class="alert alert-danger ">An error occurred: ' + err.responseText + " (" + err.status + ")" + '</div>');
                    if(typeof settings.onError === 'function'){ settings.onError(err) }
                })
                .always(function () {
                    if(typeof settings.onAlways === 'function'){ settings.onAlways() }
                })
        }

        return this.initialize();
    }
})(jQuery)