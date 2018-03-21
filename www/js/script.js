
// Get canvas

function damn() {

    var scale = document.getElementById("meter"),
        clock = document.getElementById("clock"),
        ticks, slots;

// Create ticks
    _.each(ticks = _.map(_.range(60), createTick), _.bind(scale.appendChild, scale));

// Create slots
    _.each(slots = _.map(_.range(8), createSlot), _.bind(clock.appendChild, clock));

    var center = (scale.offsetWidth / 2) | 0,
        pixelsPerTick = (scale.offsetWidth / 20) | 0;

    var update = (function (lastT) {
        return function update(t) {
            var d = t - lastT;
            currentTime = currentTime - (d / 1000);
            if (currentTime < 0) {
                currentTime = 86400;
            }

            for (var i = 0; i < ticks.length; i++) {
                var tick = ticks[i];
                var tickCenter = tick.offsetWidth / 2;
                var offset = (i - currentTime % 3600 / 60) * pixelsPerTick;
                var percent = 1 - (Math.abs(i - currentTime % 3600 / 60) / 10);

                tick.style.left = ((offset + center - tickCenter) | 0) + "px";
                tick.style.opacity = percent;
                tick.style.WebkitTransform = "scale(" + Math.cos((Math.abs(i - currentTime % 3600 / 60) / 15) * Math.PI / 2) + ",1)"
            }

            slots[0].innerHTML = (currentTime / 3600 / 10) | 0;
            slots[1].innerHTML = ((currentTime / 3600) % 10) | 0;
            slots[3].innerHTML = (currentTime % 3600 / 60 / 10) | 0;
            slots[4].innerHTML = (currentTime % 3600 / 60 % 10) | 0;
            slots[6].innerHTML = (currentTime % 60 / 10) | 0;
            slots[7].innerHTML = (currentTime % 60 % 10) | 0;

            lastT = t;
            requestAnimationFrame(update);
        }
    })(0);

    requestAnimationFrame(update);

// extras

    function createTick(i) {
        var tick = document.createElement("span");
        var tickStyle = ((i % 5) == 0) ? "big" : "small";
        tick.dataset.label = i;
        tick.className = "tick " + tickStyle;
        return tick;
    }

    function createSlot(i) {
        var slot = document.createElement("span");
        if (i == 2 || i == 5) slot.appendChild(document.createTextNode(":"));
        return slot;
    }

    setInterval(function () {
        function toggleActive(cls) {
            if (/\bactive\b/.test(cls))
                return cls.replace(/\bactive\b/, '');
            else
                return cls + " active";
        }

        _.each(document.querySelectorAll(".up"), function (elem) {
            elem.className = toggleActive(elem.className);
        });

    }, 10000);

}


// Zones

$('.zone-bar').click(function() {
    $('.zone-bar').removeClass('active');
    $(this).addClass('active');
    var index = $(this).parent().index();
    $('#secondCarousel').carousel(index);
    $('.activities-container').show();
    //$('.child-holder.item').removeClass('active');
    $($('.child-holder.item').get(index)).addClass('active');
    setTimeout(function() {
        $("#height-row .pop-up").css('height', 'auto');
        $("#height-row .pop-up").height($("#height-row .pop-up").height() + 300);
    }, 500);
});

//Scroll to zone-activity slider
$(function(){
    $(".to-zone").click(function (e) {
        e.preventDefault();
        var id  = $(this).attr('href'),
        top = $(id).offset().top;
        $('body').animate({scrollTop: top}, 800);
    });
});

//Active elem "news"
$(function(){
    $('body').on('click', ".to-news", function (e) {
        e.preventDefault();
        var id = $(this).attr('href');
        $('.show-news').removeClass('show-news');
        $(id).addClass('show-news');
        var top = $(id).offset().top;
        $('body').animate({scrollTop: top}, 800);
    });
});



//Text after logo
$(function(){
    var phrases = $('.up');

    function change() {
        var active = $('.up.active');
        var next = active.next();
        active.removeClass('active');

        if (!next.length) {
            next = $(phrases[0]);
        }

        next.addClass('active');
    }

    setInterval(function() {
        change();
    }, 3000);

    $('#fourthCarousel').on('slid.bs.carousel', function(e) {
        var top = $('#fourthCarousel').offset().top;
        $('body').animate({scrollTop: top}, 800);
    })
});