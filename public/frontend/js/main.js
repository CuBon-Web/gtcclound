! function(e) {
    "use strict";
    if (e(window).on("load", (function() {
            e(".preloader").fadeOut()
        })), e(window).on("resize", (function() {
            e(".slick-slider").slick("refresh")
        })), e.fn.asmobilemenu = function(t) {
            var s = e.extend({
                menuToggleBtn: ".themeholy-menu-toggle",
                bodyToggleClass: "themeholy-body-visible",
                subMenuClass: "themeholy-submenu",
                subMenuParent: "themeholy-item-hthemeholy-children",
                subMenuParentToggle: "themeholy-active",
                meanExpandClass: "themeholy-mean-expand",
                appendElement: '<span class="themeholy-mean-expand"></span>',
                subMenuToggleClass: "themeholy-open",
                toggleSpeed: 400
            }, t);
            return this.each((function() {
                var t = e(this);

                function a() {
                    t.toggleClass(s.bodyToggleClass);
                    var a = "." + s.subMenuClass;
                    e(a).each((function() {
                        e(this).hasClass(s.subMenuToggleClass) && (e(this).removeClass(s.subMenuToggleClass), e(this).css("display", "none"), e(this).parent().removeClass(s.subMenuParentToggle))
                    }))
                }
                t.find("li").each((function() {
                    var t = e(this).find("ul");
                    t.addClass(s.subMenuClass), t.css("display", "none"), t.parent().addClass(s.subMenuParent), t.prev("a").append(s.appendElement), t.next("a").append(s.appendElement)
                }));
                var o = "." + s.meanExpandClass;
                e(o).each((function() {
                    e(this).on("click", (function(t) {
                        var a;
                        t.preventDefault(), a = e(this).parent(), e(a).next("ul").length > 0 ? (e(a).parent().toggleClass(s.subMenuParentToggle), e(a).next("ul").slideToggle(s.toggleSpeed), e(a).next("ul").toggleClass(s.subMenuToggleClass)) : e(a).prev("ul").length > 0 && (e(a).parent().toggleClass(s.subMenuParentToggle), e(a).prev("ul").slideToggle(s.toggleSpeed), e(a).prev("ul").toggleClass(s.subMenuToggleClass))
                    }))
                })), e(s.menuToggleBtn).each((function() {
                    e(this).on("click", (function() {
                        a()
                    }))
                })), t.on("click", (function(e) {
                    e.stopPropagation(), a()
                })), t.find("div").on("click", (function(e) {
                    e.stopPropagation()
                }))
            }))
        }, e(".themeholy-menu-wrapper").asmobilemenu(), e(window).scroll((function() {
            var t = e(this).scrollTop();

            function s() {
                t > 400 && (e(".sticky-wrapper").addClass("sticky"), e(".sticky-wrapper").removeClass("will-sticky"))
            }
            s(), t > 150 ? (e(".sticky-wrapper").addClass("will-sticky"), s()) : (e(".sticky-wrapper").removeClass("sticky"), e(".sticky-wrapper").removeClass("will-sticky"))
        })), e(".scroll-top").length > 0) {
        var t = document.querySelector(".scroll-top"),
            s = document.querySelector(".scroll-top path"),
            a = s.getTotalLength();
        s.style.transition = s.style.WebkitTransition = "none", s.style.strokeDasharray = a + " " + a, s.style.strokeDashoffset = a, s.getBoundingClientRect(), s.style.transition = s.style.WebkitTransition = "stroke-dashoffset 10ms linear";
        var o = function() {
            var t = e(window).scrollTop(),
                o = e(document).height() - e(window).height(),
                n = a - t * a / o;
            s.style.strokeDashoffset = n
        };
        o(), e(window).scroll(o);
        jQuery(window).on("scroll", (function() {
            jQuery(this).scrollTop() > 50 ? jQuery(t).addClass("show") : jQuery(t).removeClass("show")
        })), jQuery(t).on("click", (function(e) {
            return e.preventDefault(), jQuery("html, body").animate({
                scrollTop: 0
            }, 750), !1
        }))
    }
    e("[data-bg-lazy][data-bg-src]").length > 0 && e("[data-bg-lazy][data-bg-src]").each((function() {
        var t = e(this),
            s = t.attr("data-bg-src");

        function n() {
            t.css("background-image", "url(" + s + ")").removeAttr("data-bg-src").removeAttr("data-bg-lazy").addClass("background-image")
        }
        if ("IntersectionObserver" in window) {
            var i = new IntersectionObserver((function(e) {
                e.forEach((function(e) {
                    e.isIntersecting && (n(), i.unobserve(e.target))
                }))
            }), {
                rootMargin: "160px 0px",
                threshold: .01
            });
            i.observe(this)
        } else n()
    })), e("[data-bg-src]").not("[data-bg-lazy]").length > 0 && e("[data-bg-src]").not("[data-bg-lazy]").each((function() {
        var t = e(this).attr("data-bg-src");
        e(this).css("background-image", "url(" + t + ")"), e(this).removeAttr("data-bg-src").addClass("background-image")
    })), e("[data-mask-src]").length > 0 && e("[data-mask-src]").each((function() {
        var t = e(this).attr("data-mask-src");
        e(this).css({
            "mask-image": "url(" + t + ")",
            "-webkit-mask-image": "url(" + t + ")"
        }), e(this).addClass("bg-mask"), e(this).removeAttr("data-mask-src")
    })), e(".themeholy-carousel").each((function() {
        var t = e(this);

        function s(e) {
            return t.data(e)
        }
        var a = '<button type="button" class="slick-prev"><i class="' + s("prev-arrow") + '"></i></button>',
            o = '<button type="button" class="slick-next"><i class="' + s("next-arrow") + '"></i></button>';
        e("[data-slick-next]").each((function() {
            e(this).on("click", (function(t) {
                t.preventDefault(), e(e(this).data("slick-next")).slick("slickNext")
            }))
        })), e("[data-slick-prev]").each((function() {
            e(this).on("click", (function(t) {
                t.preventDefault(), e(e(this).data("slick-prev")).slick("slickPrev")
            }))
        })), 1 == s("arrows") && (t.closest(".arrow-wrap").length || t.closest(".container").parent().addClass("arrow-wrap")), t.slick({
            dots: !!s("dots"),
            fade: !!s("fade"),
            arrows: !!s("arrows"),
            speed: s("speed") ? s("speed") : 1e3,
            asNavFor: !!s("asnavfor") && s("asnavfor"),
            autoplay: 0 != s("autoplay"),
            infinite: 0 != s("infinite"),
            slidesToShow: s("slide-show") ? s("slide-show") : 1,
            adaptiveHeight: !!s("adaptive-height"),
            centerMode: !!s("center-mode"),
            autoplaySpeed: s("autoplay-speed") ? s("autoplay-speed") : 8e3,
            centerPadding: s("center-padding") ? s("center-padding") : "0",
            focusOnSelect: 0 != s("focuson-select"),
            pauseOnFocus: !!s("pauseon-focus"),
            pauseOnHover: !!s("pauseon-hover"),
            variableWidth: !!s("variable-width"),
            vertical: !!s("vertical"),
            verticalSwiping: !!s("vertical"),
            prevArrow: s("prev-arrow") ? a : '<button type="button" class="slick-prev"><i class="far fa-arrow-left"></i></button>',
            nextArrow: s("next-arrow") ? o : '<button type="button" class="slick-next"><i class="far fa-arrow-right"></i></button>',
            rtl: "rtl" == e("html").attr("dir"),
            responsive: [{
                breakpoint: 1600,
                settings: {
                    arrows: !!s("xl-arrows"),
                    dots: !!s("xl-dots"),
                    slidesToShow: s("xl-slide-show") ? s("xl-slide-show") : s("slide-show"),
                    centerMode: !!s("xl-center-mode"),
                    centerPadding: "0"
                }
            }, {
                breakpoint: 1400,
                settings: {
                    arrows: !!s("ml-arrows"),
                    dots: !!s("ml-dots"),
                    slidesToShow: s("ml-slide-show") ? s("ml-slide-show") : s("slide-show"),
                    centerMode: !!s("ml-center-mode"),
                    centerPadding: 0
                }
            }, {
                breakpoint: 1200,
                settings: {
                    arrows: !!s("lg-arrows"),
                    dots: !!s("lg-dots"),
                    slidesToShow: s("lg-slide-show") ? s("lg-slide-show") : s("slide-show"),
                    centerMode: !!s("lg-center-mode") && s("lg-center-mode"),
                    centerPadding: 0
                }
            }, {
                breakpoint: 992,
                settings: {
                    arrows: !!s("md-arrows"),
                    dots: !!s("md-dots"),
                    slidesToShow: s("md-slide-show") ? s("md-slide-show") : 1,
                    centerMode: !!s("md-center-mode") && s("md-center-mode"),
                    centerPadding: 0
                }
            }, {
                breakpoint: 768,
                settings: {
                    arrows: !!s("sm-arrows"),
                    dots: !!s("sm-dots"),
                    slidesToShow: s("sm-slide-show") ? s("sm-slide-show") : 1,
                    centerMode: !!s("sm-center-mode") && s("sm-center-mode"),
                    centerPadding: 0
                }
            }, {
                breakpoint: 576,
                settings: {
                    arrows: !!s("xs-arrows"),
                    dots: !!s("xs-dots"),
                    slidesToShow: s("xs-slide-show") ? s("xs-slide-show") : 1,
                    centerMode: !!s("xs-center-mode") && s("xs-center-mode"),
                    centerPadding: 0
                }
            }]
        })
    }));
    var n = e(".slick-3d-active");
    n.on("init", (function(t, s, a) {
        var o = e(s.$slides[s.currentSlide]),
            n = o.next(),
            i = o.next().next(),
            r = o.prev(),
            l = o.prev().prev();
        r.addClass("slick-3d-prev"), n.addClass("slick-3d-next"), l.addClass("slick-3d-prev2"), i.addClass("slick-3d-next2"), o.removeClass("slick-3d-next").removeClass("slick-3d-prev").removeClass("slick-3d-next2").removeClass("slick-3d-prev2"), s.$prev = r, s.$next = n
    })).on("beforeChange", (function(t, s, a, o) {
        var n = e(s.$slides[o]);
        s.$prev.removeClass("slick-3d-prev"), s.$next.removeClass("slick-3d-next"), s.$prev.prev().removeClass("slick-3d-prev2"), s.$next.next().removeClass("slick-3d-next2");
        var i = n.next(),
            r = n.prev();
        r.addClass("slick-3d-prev"), i.addClass("slick-3d-next"), r.prev().addClass("slick-3d-prev2"), i.next().addClass("slick-3d-next2"), s.$prev = r, s.$next = i, n.removeClass("slick-next").removeClass("slick-3d-prev").removeClass("slick-next2").removeClass("slick-3d-prev2")
    })), n.slick({
        speed: 1e3,
        arrows: !1,
        dots: !1,
        focusOnSelect: !0,
        prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fal fa-arrow-right"></i></button>',
        infinite: !0,
        centerMode: !0,
        slidesPerRow: 1,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerPadding: "0",
        swipe: !0,
        customPaging: function(e, t) {
            return ""
        },
        responsive: [{
            breakpoint: 1024,
            settings: {
                arrows: !1
            }
        }]
    });
    var i = e(".heroSlider"),
        r = e(".progress"),
        l = e(".pagingInfo1"),
        c = e(".slider__label"),
        d = e(".pagingInfo2");
    i.on("init reInit afterChange", (function(e, t, s, a) {
        if (t.$dots) {
            var o = (s || 0) + 0;
            l.text(o + 1), d.text(t.slideCount)
        }
    })), i.on("beforeChange", (function(e, t, s, a) {
        var o = a / (t.slideCount - 1) * 100;
        r.css("background-size", o + "% 100%").attr("aria-valuenow", o), c.text(o + "% completed")
    })), e(".heroSlider").slick({
        autoplay: !0,
        dots: !0,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: "<button class='arrowLeft'><i class='fa-solid fa-arrow-left'></i></button>",
        nextArrow: "<button class='arrowRight'><i class='fa-solid fa-arrow-right'></i></button>"
    });
    i = e(".heroSlider2"), r = e(".progress");
    var u = e(".paging1"),
        p = (c = e(".slider__line"), e(".paging2"));
    i.on("init reInit afterChange", (function(e, t, s, a) {
        if (t.$dot) {
            var o = (s || 0) + 0;
            u.text(x + o), p.text(t.slideCount)
        }
    })), i.on("beforeChange", (function(e, t, s, a) {
        var o = a / (t.slideCount - 1) * 100;
        r.css("background-size", o + "% 100%").attr("aria-valuenow", o), c.text(o + "% completed")
    })), e(".heroSlider2").slick({
        autoplay: !0,
        dots: !0,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: "<button class='arrowLeft'><i class='fa-solid fa-arrow-left'></i></button>",
        nextArrow: "<button class='arrowRight'><i class='fa-solid fa-arrow-right'></i></button>"
    }), e(".slider-nav").slick({
        pauseOnHover: !1,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: !1,
        dots: !0,
        autoplay: !0,
        autoplaySpeed: 5e3,
        focusOnSelect: !0,
        dots: !0,
        appendDots: e(".slider-dots-box"),
        dotsClass: "slider-dots"
    }), e(".slider-nav").on("beforeChange", (function(t, s, a, o) {
        e(".slider-dots-box button").html("")
    })).trigger("beforeChange"), e(".slider-nav").on("afterChange", (function(t, s, a) {
        e(".slider-dots-box button").html(""), e(".slider-dots-box .slick-active button").html(`<svg class="progress-svg"> \n\t\t<g transform="translate(40,40)"> \n      <circle class="circle-go" r="40" cx="0" cy="0"></circle>    \n      <text class="circle-tx" x="0" y="4" alignment-baseline="middle" stroke-width="0" text-anchor="middle">${(a||0)+1}</text>\n\t\t</g>\n    </svg>`)
    })).trigger("afterChange"), e("[data-ani-duration]").each((function() {
        var t = e(this).data("ani-duration");
        e(this).css("animation-duration", t)
    })), e("[data-ani-delay]").each((function() {
        var t = e(this).data("ani-delay");
        e(this).css("animation-delay", t)
    })), e("[data-ani]").each((function() {
        var t = e(this).data("ani");
        e(this).addClass(t), e(".slick-current [data-ani]").addClass("themeholy-animated")
    })), e(".themeholy-carousel").on("afterChange", (function(t, s, a, o) {
        e(s.$slides).find("[data-ani]").removeClass("themeholy-animated"), e(s.$slides[a]).find("[data-ani]").addClass("themeholy-animated")
    }));
    var h = e("#ProjectSlide2");
    h.on("init reInit afterChange", (function(e, t, s, a) {})), h.on("edge breakpoint setPosition beforeChange afterChange", (function(t, s, a, o) {
        e(window).trigger("resize.twentytwenty")
    })), h.slick({
        speed: 2e3,
        centerMode: !0,
        centerPadding: "25%",
        slidesToShow: 1,
        focusOnSelect: !0,
        prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fal fa-arrow-right"></i></button>',
        autoplay: !0,
        swipe: !1,
        touchMove: !1,
        arrows: !1,
        dots: !1,
        infinite: !0,
        adaptiveHeight: !1,
        responsive: [{
            breakpoint: 991,
            settings: {
                arrows: !1,
                dots: !0,
                centerMode: !1,
                slidesToShow: 1
            }
        }]
    }), e(".flip-gallery").length > 0 && e(".flip-gallery").flipster({
        style: "carousel",
        spacing: -.5,
        nav: !0,
        buttons: !0,
        loop: !0,
        scrollwheel: !1
    });
    var f, g, v, m = ".ajax-contact",
        b = '[name="email"]',
        w = e(".form-messages");

    function y() {
        var t = e(m).serialize();
        (function() {
            var t, s = !0;

            function a(a) {
                a = a.split(",");
                for (var o = 0; o < a.length; o++) t = m + " " + a[o], e(t).val() ? (e(t).removeClass("is-invalid"), s = !0) : (e(t).addClass("is-invalid"), s = !1)
            }
            a('[name="name"],[name="email"],[name="subject"],[name="number"],[name="message"]'), e(b).val() && e(b).val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/) ? (e(b).removeClass("is-invalid"), s = !0) : (e(b).addClass("is-invalid"), s = !1);
            return s
        })() && jQuery.ajax({
            url: e(m).attr("action"),
            data: t,
            type: "POST"
        }).done((function(t) {
            w.removeClass("error"), w.addClass("success"), w.text(t), e(m + ' input:not([type="submit"]),' + m + " textarea").val("")
        })).fail((function(e) {
            w.removeClass("success"), w.addClass("error"), "" !== e.responseText ? w.html(e.responseText) : w.html("Oops! An error occured and your message could not be sent.")
        }))
    }

    function k(e) {
        return parseInt(e, 10)
    }
    e(m).on("submit", (function(e) {
            e.preventDefault(), y()
        })), f = ".popup-search-box", g = ".searchClose", v = "show", e(".searchBoxToggler").on("click", (function(t) {
            t.preventDefault(), e(f).addClass(v)
        })), e(f).on("click", (function(t) {
            t.stopPropagation(), e(f).removeClass(v)
        })), e(f).find("form").on("click", (function(t) {
            t.stopPropagation(), e(f).addClass(v)
        })), e(g).on("click", (function(t) {
            t.preventDefault(), t.stopPropagation(), e(f).removeClass(v)
        })),
        function(t, s, a, o) {
            e(s).on("click", (function(s) {
                s.preventDefault(), e(t).addClass(o)
            })), e(t).on("click", (function(s) {
                s.stopPropagation(), e(t).removeClass(o)
            })), e(t + " > div").on("click", (function(s) {
                s.stopPropagation(), e(t).addClass(o)
            })), e(a).on("click", (function(s) {
                s.preventDefault(), s.stopPropagation(), e(t).removeClass(o)
            }))
        }(".sidemenu-wrapper", ".sideMenuToggler", ".sideMenuCls", "show"), e(".popup-image").magnificPopup({
            type: "image",
            gallery: {
                enabled: !0
            }
        }), e(".popup-video").magnificPopup({
            type: "iframe"
        }), e(".popup-content").magnificPopup({
            type: "inline",
            midClick: !0
        }), e(".popup-content").on("click", (function() {
            e(".slick-slider").slick("refresh")
        })), e.fn.sectionPosition = function(t, s) {
            e(this).each((function() {
                var a, o, n, i, r, l = e(this);
                a = Math.floor(l.height() / 2), o = l.attr(t), n = l.attr(s), i = k(e(n).css("padding-top")), r = k(e(n).css("padding-bottom")), "top-half" === o ? (e(n).css("padding-bottom", r + a + "px"), l.css("margin-top", "-" + a + "px")) : "bottom-half" === o && (e(n).css("padding-top", i + a + "px"), l.css("margin-bottom", "-" + a + "px"))
            }))
        };
    var C;
     e(".counter-number").counterUp({
        delay: 10,
        time: 1e3
    }), e.fn.asTab = function(t) {
        var s = e.extend({
            sliderTab: !1,
            tabButton: "button"
        }, t);
        e(this).each((function() {
            var t = e(this),
                a = t.find(s.tabButton);
            t.append('<span class="indicator"></span>');
            var o = t.find(".indicator");
            if (a.on("click", (function(t) {
                    t.preventDefault();
                    var a = e(this);
                    a.addClass("active").siblings().removeClass("active"), s.sliderTab ? e(n).slick("slickGoTo", a.data("slide-go-to")) : r()
                })), s.sliderTab) {
                var n = t.data("asnavfor"),
                    i = 0;
                a.each((function() {
                    var a = e(this);
                    a.attr("data-slide-go-to", i), i++, a.hasClass("active") && e(n).slick("slickGoTo", a.data("slide-go-to")), e(n).on("beforeChange", (function(e, a, o, n) {
                        t.find(s.tabButton + '[data-slide-go-to="' + n + '"]').addClass("active").siblings().removeClass("active"), r()
                    }))
                }))
            }

            function r() {
                var n = t.find(s.tabButton + ".active"),
                    i = n.css("height"),
                    r = n.css("width"),
                    l = n.position().top + "px",
                    c = n.position().left + "px";
                o.get(0).style.setProperty("--height-set", i), o.get(0).style.setProperty("--width-set", r), o.get(0).style.setProperty("--pos-y", l), o.get(0).style.setProperty("--pos-x", c), e(a).first().position().left == n.position().left ? o.addClass("start").removeClass("center").removeClass("end") : e(a).last().position().left == n.position().left ? o.addClass("end").removeClass("center").removeClass("start") : o.addClass("center").removeClass("start").removeClass("end")
            }
            r()
        }))
    }, e(".product-thumb-tab").length && e(".product-thumb-tab").asTab({
        sliderTab: !0,
        tabButton: ".tab-btn"
    }), e(".project-card-tab").length && e(".project-card-tab").asTab({
        sliderTab: !0,
        tabButton: ".tab-btn"
    }), e(".tab-menu1").length && e(".tab-menu1").asTab({
        sliderTab: !0,
        tabButton: ".tab-btn"
    }), e(".hero-indicator").length && e(".hero-indicator").asTab({
        sliderTab: !0,
        tabButton: ".indicatior-btn"
    }), e(".hero-indicator5").length && e(".hero-indicator5").asTab({
        sliderTab: !0,
        tabButton: ".indicatior-btn"
    }), e(".portfolio-indicator").length && e(".portfolio-indicator").asTab({
        sliderTab: !0,
        tabButton: ".indicatior-btn"
    }), e.fn.shapeMockup = function() {
        e(this).each((function() {
            var t = e(this),
                s = t.data("top"),
                a = t.data("right"),
                o = t.data("bottom"),
                n = t.data("left");
            t.css({
                top: s,
                right: a,
                bottom: o,
                left: n
            }).removeAttr("data-top").removeAttr("data-right").removeAttr("data-bottom").removeAttr("data-left").parent().addClass("shape-mockup-wrap")
        }))
    }, e(".shape-mockup") && e(".shape-mockup").shapeMockup(), e.fn.countdown = function() {
        e(this).each((function() {
            var t = e(this),
                s = new Date(t.data("offer-date")).getTime();

            function a(e) {
                return t.find(e)
            }
            var o = setInterval((function() {
                var e = (new Date).getTime(),
                    n = s - e,
                    i = Math.floor(n / 864e5),
                    r = Math.floor(n % 864e5 / 36e5),
                    l = Math.floor(n % 36e5 / 6e4),
                    c = Math.floor(n % 6e4 / 1e3);
                i < 10 && (i = "0" + i), r < 10 && (r = "0" + r), l < 10 && (l = "0" + l), c < 10 && (c = "0" + c), n < 0 ? (clearInterval(o), t.addClass("expired"), t.find(".message").css("display", "block")) : (a(".day").html(i), a(".hour").html(r), a(".minute").html(l), a(".seconds").html(c))
            }), 1e3)
        }))
    }, e(".counter-list").length && e(".counter-list").countdown(), e(".progress-bar").waypoint((function() {
        e(".progress-bar").css({
            animation: "animate-positive 1.8s",
            opacity: "1"
        })
    }), {
        offset: "75%"
    }), e(".price_slider").slider({
        range: !0,
        min: 10,
        max: 100,
        values: [10, 75],
        slide: function(t, s) {
            e(".from").text("$" + s.values[0]), e(".to").text("$" + s.values[1])
        }
    }), e(".from").text("$" + e(".price_slider").slider("values", 0)), e(".to").text("$" + e(".price_slider").slider("values", 1)), jQuery(document).ready((function() {
        jQuery(".progress-bar").each((function() {
            jQuery(this).find(".progress-content").animate({
                width: jQuery(this).attr("data-percentage")
            }, 2e3), jQuery(this).find(".progress-number-mark").animate({
                left: jQuery(this).attr("data-percentage")
            }, {
                duration: 2e3,
                step: function(e, t) {
                    var s = Math.round(e);
                    jQuery(this).find(".percent").html(s + "%")
                }
            })
        }))
    })), e(C = ".onepage-nav").length > 0 && e(C).each((function() {
        var t = e(this).find("a");
        e(this).find(t).each((function() {
            e(this).on("click", (function() {
                var t = e(this.getAttribute("href"));
                t.length && (event.preventDefault(), e("html, body").stop().animate({
                    scrollTop: t.offset().top - 10
                }, 1e3))
            }))
        }))
    })), e(window).on("scroll", (function() {
        e(".onepage").length > 0 && (e(window).scrollTop() > 0 ? e(".themeholy-header .sticky-active").addClass("sticky") : e(".themeholy-header .sticky-active").removeClass("sticky"))
    })), e.fn.indicator = function() {
        var t = e(this),
            s = t.find("a"),
            a = t.find("button");
        t.append('<span class="indicator"></span>');
        var o = t.find(".indicator");
        if (s.length) var n = s;
        else if (a.length) n = a;

        function i() {
            var s = t.find(".active"),
                a = s.css("height"),
                n = s.css("width"),
                i = s.position().top + "px",
                r = s.position().left + "px";
            e(window).on("resize", (function() {
                i = s.position().top + "px", r = s.position().left + "px"
            })), o.get(0).style.setProperty("--height-set", a), o.get(0).style.setProperty("--width-set", n), o.get(0).style.setProperty("--pos-y", i), o.get(0).style.setProperty("--pos-x", r)
        }
        n.on("click", (function(t) {
            t.preventDefault(), e(this).addClass("active"), e(this).siblings(".active").removeClass("active"), i()
        })), i()
    }, e(".indicator-active").length && e(".indicator-active").indicator(), e("#ship-to-different-address-checkbox").on("change", (function() {
        e(this).is(":checked") ? e("#ship-to-different-address").next(".shipping_address").slideDown() : e("#ship-to-different-address").next(".shipping_address").slideUp()
    })), e(".woocommerce-form-login-toggle a").on("click", (function(t) {
        t.preventDefault(), e(".woocommerce-form-login").slideToggle()
    })), e(".woocommerce-form-coupon-toggle a").on("click", (function(t) {
        t.preventDefault(), e(".woocommerce-form-coupon").slideToggle()
    })), e(".shipping-calculator-button").on("click", (function(t) {
        t.preventDefault(), e(this).next(".shipping-calculator-form").slideToggle()
    })), e('.wc_payment_methods input[type="radio"]:checked').siblings(".payment_box").show(), e('.wc_payment_methods input[type="radio"]').each((function() {
        e(this).on("change", (function() {
            e(".payment_box").slideUp(), e(this).siblings(".payment_box").slideDown()
        }))
    })), e(".rating-select .stars a").each((function() {
        e(this).on("click", (function(t) {
            t.preventDefault(), e(this).siblings().removeClass("active"), e(this).parent().parent().addClass("selected"), e(this).addClass("active")
        }))
    })), e(".quantity-plus").each((function() {
        e(this).on("click", (function(t) {
            t.preventDefault();
            var s = e(this).siblings(".qty-input"),
                a = parseInt(s.val(), 10);
            isNaN(a) || s.val(a + 1)
        }))
    })), e(".quantity-minus").each((function() {
        e(this).on("click", (function(t) {
            t.preventDefault();
            var s = e(this).siblings(".qty-input"),
                a = parseInt(s.val(), 10);
            !isNaN(a) && a > 1 && s.val(a - 1)
        }))
    })), window.addEventListener("contextmenu", (function(e) {
        e.preventDefault()
    }), !1)
}(jQuery);