;(function ($) {
    $(document).ready(function () {
        $(".audio").mb_miniPlayer({
            width: 600,
            inLine: false,
            id3: true,
            addShadow: false,
            pauseOnWindowBlur: false,
            downloadPage: null,
        });
        $("#play").click(function () { 
            $('#m1').mb_miniPlayer_play()
        });
        $("#stop").click(function () { 
            $('#m1').mb_miniPlayer_stop()
        });
    })
})(jQuery);