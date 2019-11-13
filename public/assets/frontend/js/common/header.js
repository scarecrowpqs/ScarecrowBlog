$(function () {
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13 && !e.ctrlKey){
            search();
        }
    };

    function search() {
        var searchText = $("#searchInput").val();
        var url = $("#basePath").val() + "classview?page=1&limit=8&cid=0&sc="+searchText;
        var aObj = document.createElement('a');
        aObj.href = url;
        aObj.id = "ScarecrowSearchBtnId";
        document.body.appendChild(aObj);
        var obj = document.getElementById(aObj.id);
        obj.click();
        document.body.removeChild(obj);
    }

    //鼠标点击出现爱心特效
    (function(window,document) {
        var hearts = [];
        window.requestAnimationFrame = (function () {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimationFrame ||
                function (callback) {
                    setTimeout(callback, 1000 / 60);
                }
        })();
        init();

        function init() {
            css(".heart{width: 10px;height: 10px;position: fixed;background: #f00;transform: rotate(45deg);-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);}.heart:after,.heart:before{content: '';width: inherit;height: inherit;background: inherit;border-radius: 50%;-webkit-border-radius: 50%;-moz-border-radius: 50%;position: absolute;}.heart:after{top: -5px;}.heart:before{left: -5px;}");
            attachEvent();
            gameloop();
        }

        function gameloop() {
            for (var i = 0; i < hearts.length; i++) {
                if (hearts[i].alpha <= 0) {
                    document.body.removeChild(hearts[i].el);
                    hearts.splice(i, 1);
                    continue;
                }
                hearts[i].y--;
                hearts[i].scale += 0.004;
                hearts[i].alpha -= 0.013;
                hearts[i].el.style.cssText = "left:" + hearts[i].x + "px;top:" + hearts[i].y + "px;opacity:" + hearts[i].alpha + ";transform:scale(" + hearts[i].scale + "," + hearts[i].scale + ") rotate(45deg);background:" + hearts[i].color;
            }
            requestAnimationFrame(gameloop);
        }

        function attachEvent() {
            var old = typeof window.οnclick === "function" && window.onclick;
            window.onclick = function (event) {
                old && old();
                createHeart(event);
            }
        }

        function createHeart(event) {
            var d = document.createElement("div");
            d.className = "heart";
            hearts.push({
                el: d,
                x: event.clientX - 5,
                y: event.clientY - 5,
                scale: 1,
                alpha: 1,
                color: randomColor()
            });
            document.body.appendChild(d);
        }

        function css(css) {
            var style = document.createElement("style");
            style.type = "text/css";
            try {
                style.appendChild(document.createTextNode(css));
            } catch (ex) {
                style.styleSheet.cssText = css;
            }
            document.getElementsByTagName('head')[0].appendChild(style);
        }

        function randomColor() {
            return "rgb(" + (~~(Math.random() * 255)) + "," + (~~(Math.random() * 255)) + "," + (~~(Math.random() * 255)) + ")";
        }
    })(window,document);

    //浏览器加入版权标识
    $(document.body).bind({
        copy: function(e) {//copy事件
            var selecter=window.getSelection();
            cpTxt = selecter.toString();
            cpTxt = cpTxt + "\r\n---------------------------------\r\n版权声明:Scarecrow 本篇文章来源于 http://blog.scarecrow.top 原文链接："+location.href;
            var clipboardData = window.clipboardData; //for IE
            if (!clipboardData) { // for chrome
                clipboardData = e.originalEvent.clipboardData;
            }
            clipboardData.setData('Text', cpTxt);
            return false;
        }
    });
});