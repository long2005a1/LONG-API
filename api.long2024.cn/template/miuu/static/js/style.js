//移动端搜索
$(function() {
    $("#search").click(function() {
        $("#search i").toggleClass("fa-times");
        $("#search i").toggleClass("fa-search");
        $(".search").slideToggle(100);
        $(".nav").slideUp(100)
    })
});
//移动端导航
$(function() {
    $("#mnav").click(function() {
        $("#mnav i").toggleClass("fa-times");
        $("#mnav i").toggleClass("fa-bars");
        $(".nav").slideToggle(100);
        $(".search").slideUp(100)
    })
});

//导航高亮
$(function() {
    var a = $("#monavber").attr("data-type");
    $(".navbar>li ").each(function() {
        try {
            var L = $(this).attr("id");
            if ("index" == a) {
                if (L == "nvabar-item-index") {
                    $("#nvabar-item-index").addClass("active")
                }
            } else if ("category" == a) {
                var c = $("#monavber").attr("data-infoid");
                if (c != null) {
                    var ca = c.split(" ");
                    for (var C = 0; C < ca.length; C++) {
                        if (L == "navbar-category-" + ca[C]) {
                            $("#navbar-category-" + ca[C] + "").addClass("active")
                        }
                    }
                }
            } else if ("article" == a) {
                var c = $("#monavber").attr("data-infoid");
                if (c != null) {
                    var ca = c.split(" ");
                    for (var C = 0; C < ca.length; C++) {
                        if (L == "navbar-category-" + ca[C]) {
                            $("#navbar-category-" + ca[C] + "").addClass("active")
                        }
                    }
                }
            } else if ("page" == a) {
                var c = $("#monavber").attr("data-infoid");
                if (c != null) {
                    if (L == "navbar-page-" + c) {
                        $("#navbar-page-" + c + "").addClass("active")
                    }
                }
            } else if ("tag" == a) {
                var c = $("#monavber").attr("data-infoid");
                if (c != null) {
                    if (L == "navbar-tag-" + c) {
                        $("#navbar-tag-" + c + "").addClass("active")
                    }
                }
            }
        } catch(a) {}
    });
    $("#monavber").delegate("a", "click",
    function() {
        $(".navbar>li").each(function() {
            $(this).removeClass("active")
        });
        if ($(this).closest("ul") != null && $(this).closest("ul").length != 0) {
            if ($(this).closest("ul").attr("id") == "munavber") {
                $(this).addClass("active")
            } else {
                $(this).closest("ul").closest("li").addClass("active")
            }
        }
    })
});
