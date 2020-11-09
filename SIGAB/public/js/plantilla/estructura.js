$(document).ready(function() {
    (function ($) {

        "use strict"; // Start of use strict

        // Toggle the side navigation
        $("#sidebarToggle, #sidebarToggleTop").on("click", function(e) {
            $("body").toggleClass("sidebar-toggled");
            $(".sidebar").toggleClass("toggled");
            if ($(".sidebar").hasClass("toggled")) {
                $(".sidebar .collapse").collapse("hide");
            }
        });


        // Close any open menu accordions when window is resized below 768px
        $(window).resize(function() {
            if ($(window).width() < 768) {
                $(".sidebar .collapse").collapse("hide");
            }
        });

        // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
        $("body.fixed-nav .sidebar").on(
            "mousewheel DOMMouseScroll wheel",
            function(e) {
                if ($(window).width() > 768) {
                    var e0 = e.originalEvent,
                        delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                    e.preventDefault();
                }
            }
        );

        // Scroll to top button appear
        $(document).on("scroll", function() {
            var scrollDistance = $(this).scrollTop();
            if (scrollDistance > 100) {
                $(".scroll-to-top").fadeIn();
            } else {
                $(".scroll-to-top").fadeOut();
            }
        });

        // Smooth scrolling using jQuery easing
        $(document).on("click", "a.scroll-to-top", function(e) {
            var $anchor = $(this);
            $("html, body")
                .stop()
                .animate(
                    {
                        scrollTop: $($anchor.attr("href")).offset().top
                    },
                    1000,
                    "easeInOutExpo"
                );
            e.preventDefault();
        });
    })(jQuery); // End of use strict
    var elixir = require("laravel-elixir");

    elixir(function(mix) {
        mix.scripts(
            [
                "jquery/dist/jquery.min.js"
                // list your other npm packages here
            ],
            "public/js/vendor.js", // 2nd param is the output file
            "node_modules"
        ) // 3rd param is saying "look in /node_modules/ for these scripts"

            .scripts(
                [
                    "scripts.js" // your custom js file located in default location: /resources/assets/js/
                ],
                "public/js/app.js"
            ) // looks in default location since there's no 3rd param

            .version([
                // optionally append versioning string to filename
                "js/vendor.js", // compiled files will be in /public/build/js/
                "js/app.js"
            ]);
    });
});
