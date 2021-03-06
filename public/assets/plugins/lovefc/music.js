var musicfc = document.createElement('audio');
musicfc.controls = false;
musicfc.src = '';
document.body.appendChild(musicfc);
var jsdom = document.scripts,
    js_path = jsdom[jsdom.length - 1].src.substring(0, jsdom[jsdom.length - 1].src.lastIndexOf("/") - 21);
css_path = jsdom[jsdom.length - 1].src.substring(0, jsdom[jsdom.length - 1].src.lastIndexOf("/") + 1);
function is_mobile() {
    var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
    var u = navigator.userAgent;
    if (null == u) {
        return true;
    }
    var result = regex_match.exec(u);
    if (null == result) {
        return false;
    } else {
        return true;
    }
}
function loadMusicList(list) {
    if (!list) {
        var url = js_path + 'getwymusicapi';
    } else {
        var url = js_path + 'getwymusicapi?list=' + list;
    }
    $.ajax({
        url: url,
        type: 'get',
        async: false,
        data: {},
        success: function success(data) {
            musicJsonToArray(data);
            if (playStatus == 1) {
                autoPlay();
            }
        },
        fail: function fail() {
            alert('歌单获取失败！');
        }
    });
}
function addFloatMusicDiv() {
    var parent = document.body;
    var div = document.createElement("div");
    var html = '<div class="float-music animated"><img class="cover" id="music-cover" src="' + css_path + 'scarecrow.jpg">';
    html += '<div class="animated-circles"><div class="circle c-1"></div><div class="circle c-2"></div><div class="circle c-3"></div></div></div>';
    div.innerHTML = html;
    div.addEventListener('click', function () {
        if (playStatus == 0) {
            autoPlay();
        } else {
            stopPlay();
        }
    });
    parent.appendChild(div);
}
function loadStyle(url) {
    var link = document.createElement('link');
    link.type = 'text/css';
    link.rel = 'stylesheet';
    link.href = url;
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(link);
}
function loadScript(url) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;
    document.getElementsByTagName('head')[0].appendChild(script);
}
var playStatus = 0,
    allTime = 0,
    arrMusic = new Array(),
    nowPlayNum = 0,
    arrMusicNum = 0,
    volume = 1;
function attrMusic(arr) {
    if (arr && arr.hasOwnProperty('url')) {
        musicfc.src = arr['url'];
        $('#music-cover').attr("src", arr['pic']);
    }
}
function musicJsonToArray(json) {
    arrMusic = new Array();
    if (json == null && json.toString() == '') {
        console.log('json error');
        return false;
    }
    for (var item in json) {
        arrMusic[item] = json[item];
    }
    attrMusic(arrMusic[nowPlayNum]);
    arrMusicNum = arrMusic.length;
}
function checkMusic() {
    var currentTime = musicfc.currentTime;
    if (!currentTime) {
        if (playStatus == 1) {
            nextMusic();
            autoPlay();
        }
    }
};
function autoPlay() {
    playStatus = 1;
    musicfc.play();
    $('#music-cover').addClass('play-circles');
}
function stopPlay() {
    playStatus = 0;
    musicfc.pause();
    $('#music-cover').removeClass('play-circles');
}
function prevMusic() {
    nowPlayNum--;
    if (nowPlayNum < 0) {
        nowPlayNum = arrMusicNum - 1;
    }
    attrMusic(arrMusic[nowPlayNum]);
}
function nextMusic() {
    nowPlayNum++;
    if (nowPlayNum > arrMusicNum) {
        nowPlayNum = 0;
    }
    attrMusic(arrMusic[nowPlayNum]);
}
musicfc.addEventListener('ended',
    function() {
        if (playStatus == 1) {
            nextMusic();
            autoPlay();
        } else {
            playStatus = 0;
            musicfc.pause();
            $('#music-cover').removeClass('play-circles');
        }
    },
    false);
document.onkeydown = function(event) {
    if (is_mobile()) {
        return false;
    }
    var values = false;
    var e = event || window.event || arguments.callee.caller.arguments[0];
    if (!e) {
        return false;
    }
    if (typeof e.path != "undefined") {
        values = e.path[0].value;
    }
    if (typeof e.target != "undefined") {
        values = e.target.value;
    }
    if (!values) {
        switch (e.keyCode) {
            case 38:
                volume += 0.05;
                if (volume > 1) {
                    volume = 1;
                }
                musicfc.volume = volume;
                break;
            case 37:
                prevMusic();
                if (playStatus == 1) {
                    autoPlay();
                }
                break;
            case 40:
                volume -= 0.05;
                if (volume <= 0) {
                    volume = 0;
                }
                musicfc.volume = volume;
                break;
            case 39:
                nextMusic();
                if (playStatus == 1) {
                    autoPlay();
                }
                break;
            case 13:
                if (e.ctrlKey) {
                    if (playStatus == 0) {
                        autoPlay();
                    } else {
                        stopPlay();
                    }
                }
                break;
            case 70:
                loadMusicList();
                break;
        }
    }
};
function musicPosition(position) {
    if (!position) {
        position = 'left-bottom';
    }
    switch (position) {
        case 'left-bottom':
            $('.float-music').css({
                "bottom":
                    "0",
                "left": "40px"
            });
            break;
        case 'right-bottom':
            $('.float-music').css({
                "bottom":
                    "0",
                "right": "40px"
            });
            break;
        case 'left-top':
            $('.float-music').css({
                "top":
                    "90px",
                "left": "40px"
            });
            break;
        case 'right-top':
            $('.float-music').css({
                "top":
                    "90px",
                "right": "40px"
            });
            break;
        default:
            $('.float-music').css({
                "bottom":
                    "0",
                "left": "40px"
            });
    }
}
if (is_mobile() == false) {
    $(document).ready(function() {
        loadStyle(css_path + 'css.css');
        addFloatMusicDiv();
        if (typeof musicConfig != "undefined") {
            var position = musicConfig.position,
                list = musicConfig.list;
            color = musicConfig.color;
            if (color) {
                $('.float-music .animated-circles .circle').css("background", color);
            }
            musicPosition(position);
            loadMusicList(list);
        } else {
            musicPosition();
            loadMusicList();
        }
        $(".animated-circles").addClass('animated');
        var pageStatus = 0;
        $('#music-cover').on('click',
            function(e) {
                if (pageStatus == 0) {
                    $('.fc-music-page').show();
                    pageStatus = 1;
                } else {
                    $('.fc-music-page').hide();
                    pageStatus = 0;
                }
            });
        $('.fc-music-page .close').on('click',
            function(e) {
                $('.fc-music-page').hide();
            });
        var music_task = window.setInterval("checkMusic()", 3000);
    });
}