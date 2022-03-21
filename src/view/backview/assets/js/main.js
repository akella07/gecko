$(".copythis").each(function() {
    $(this).click(function() {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).next().text("Copied!");
        $(".copythis").not(this).next().text("<--- Click to copy");
    });
});