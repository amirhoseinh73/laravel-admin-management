'use strict';
(function($) {
    function topPrice() {
        $("#side-menu")["metisMenu"]();
    }

    function sortSelectControl() {
        $("#vertical-menu-btn")["on"]("click", function(canCreateDiscussions) {
            canCreateDiscussions["preventDefault"]();
            $("body")["toggleClass"]("sidebar-enable");
            if ($(window)["width"]() >= 992) {
                $("body")["toggleClass"]("vertical-collpsed");
            } else {
                $("body")["removeClass"]("vertical-collpsed");
            }
        });
    }

    function _fillFancyboxWithData() {
        $("#sidebar-menu a")["each"](function() {
            var _0x5e17fe = window["location"]["href"]["split"](/[?#]/)[0];
            if (this["href"] == _0x5e17fe) {
                $(this)["addClass"]("active");
                $(this)["parent"]()["addClass"]("mm-active");
                $(this)["parent"]()["parent"]()["addClass"]("mm-show");
                $(this)["parent"]()["parent"]()["prev"]()["addClass"]("mm-active");
                $(this)["parent"]()["parent"]()["parent"]()["addClass"]("mm-active");
                $(this)["parent"]()["parent"]()["parent"]()["parent"]()["addClass"]("mm-show");
                $(this)["parent"]()["parent"]()["parent"]()["parent"]()["parent"]()["addClass"]("mm-active");
            }
        });
    }

    function apply_grid_style() {
        $(".navbar-nav a")["each"](function() {
            var _0x1a7f57 = window["location"]["href"]["split"](/[?#]/)[0];
            if (this["href"] == _0x1a7f57) {
                $(this)["addClass"]("active");
                $(this)["parent"]()["addClass"]("active");
                $(this)["parent"]()["parent"]()["addClass"]("active");
                $(this)["parent"]()["parent"]()["parent"]()["addClass"]("active");
                $(this)["parent"]()["parent"]()["parent"]()["parent"]()["addClass"]("active");
                $(this)["parent"]()["parent"]()["parent"]()["parent"]()["parent"]()["addClass"]("active");
            }
        });
    }

    function removeaToolTip() {
        function MouseWheelHandler() {
            if (!document["webkitIsFullScreen"] && !document["mozFullScreen"] && !document["msFullscreenElement"]) {
                console["log"]("pressed");
                $("body")["removeClass"]("fullscreen-enable");
            }
        }
        $("[data-toggle='fullscreen']")["on"]("click", function(canCreateDiscussions) {
            canCreateDiscussions["preventDefault"]();
            $("body")["toggleClass"]("fullscreen-enable");
            if (!document["fullscreenElement"] && !document["mozFullScreenElement"] && !document["webkitFullscreenElement"]) {
                if (document["documentElement"]["requestFullscreen"]) {
                    document["documentElement"]["requestFullscreen"]();
                } else {
                    if (document["documentElement"]["mozRequestFullScreen"]) {
                        document["documentElement"]["mozRequestFullScreen"]();
                    } else {
                        if (document["documentElement"]["webkitRequestFullscreen"]) {
                            document["documentElement"]["webkitRequestFullscreen"](Element["ALLOW_KEYBOARD_INPUT"]);
                        }
                    }
                }
            } else {
                if (document["cancelFullScreen"]) {
                    document["cancelFullScreen"]();
                } else {
                    if (document["mozCancelFullScreen"]) {
                        document["mozCancelFullScreen"]();
                    } else {
                        if (document["webkitCancelFullScreen"]) {
                            document["webkitCancelFullScreen"]();
                        }
                    }
                }
            }
        });
        document["addEventListener"]("fullscreenchange", MouseWheelHandler);
        document["addEventListener"]("webkitfullscreenchange", MouseWheelHandler);
        document["addEventListener"]("mozfullscreenchange", MouseWheelHandler);
    }

    function createHPipe() {
        $(".right-bar-toggle")["on"]("click", function(canCreateDiscussions) {
            $("body")["toggleClass"]("right-bar-enabled");
        });
        $(document)["on"]("click", "body", function(arrayOfSelects) {
            if ($(arrayOfSelects["target"])["closest"](".right-bar-toggle, .right-bar")["length"] > 0) {
                return;
            }
            $("body")["removeClass"]("right-bar-enabled");
            return;
        });
    }

    function setUpVideo() {
        $(".dropdown-menu a.dropdown-toggle")["on"]("click", function(canCreateDiscussions) {
            if (!$(this)["next"]()["hasClass"]("show")) {
                $(this)["parents"](".dropdown-menu")["first"]()["find"](".show")["removeClass"]("show");
            }
            var _0x4d2a9a = $(this)["next"](".dropdown-menu");
            return _0x4d2a9a["toggleClass"]("show"), ![];
        });
    }

    function apply_selections() {
        $(function() {
            $("[data-toggle='tooltip']")["tooltip"]();
        });
        $(function() {
            $("[data-toggle='popover']")["popover"]();
        });
    }

    function container_resize_splitter() {
        $(window)["on"]("load", function() {
            $("#status")["fadeOut"]();
            $("#preloader")["delay"](350)["fadeOut"]("slow");
        });
    }

    function init() {
        if (window["sessionStorage"]) {
            var element = sessionStorage["getItem"]("is_visited");
            if (!element) {
                sessionStorage["setItem"]("is_visited", "light-mode-switch");
            } else {
                $(".right-bar input:checkbox")["prop"]("checked", ![]);
                $("#" + element)["prop"]("checked", !![]);
                // each(element);
            }
        }
        // $("#light-mode-switch, #dark-mode-switch")["on"]("change", function(quesResult) {
        //     each(quesResult["target"]["id"]);
        // });
    }

    function each(object) {
        if ($("#light-mode-switch")["prop"]("checked") == !![] && object === "light-mode-switch") {
            $("#dark-mode-switch")["prop"]("checked", ![]);
            $("#bootstrap-style")["attr"]("href", "assets/css/bootstrap.min.css");
            $("#app-style")["attr"]("href", "assets/css/app.css");
            sessionStorage["setItem"]("is_visited", "light-mode-switch");
        } else {
            if ($("#dark-mode-switch")["prop"]("checked") == !![] && object === "dark-mode-switch") {
                $("#light-mode-switch")["prop"]("checked", ![]);
                $("#bootstrap-style")["attr"]("href", "assets/css/bootstrap-dark.min.css");
                $("#app-style")["attr"]("href", "assets/css/app-dark.css");
                sessionStorage["setItem"]("is_visited", "dark-mode-switch");
            }
        }
    }

    function success() {
        topPrice();
        sortSelectControl();
        _fillFancyboxWithData();
        apply_grid_style();
        removeaToolTip();
        createHPipe();
        setUpVideo();
        apply_selections();
        init();
        container_resize_splitter();
        Waves["init"]();
    }
    success();
})(jQuery);
