$(function () {
    getMenuApiUrl = '/back/getmenulist';
    var menuList = [];
    // var menuList = [
    //     {name:'菜单一',icon:'&#xe6b8;',href:'',child:[
    //         {name:'菜单一一',icon:'&#xe6b8;',href:''},
    //         {name:'菜单一二',icon:'&#xe6b8;',href:''},
    //         {name:'菜单一三',icon:'&#xe6b8;',href:''}
    //     ]},
    //     {name:'菜单二',icon:'&#xe6b8;',href:'',child:[
    //         {name:'菜单二一',icon:'&#xe6b8;',href:''},
    //         {name:'菜单二二',icon:'&#xe6b8;',href:''},
    //         {name:'菜单二三',icon:'&#xe6b8;',href:''}
    //     ]},
    // ];

    //设置左边菜单
    function getLeftMenu(datas, index=0) {
        if (datas.length <= index) {
            return '';
        }

        var data = datas[index];
        var htmlStr = "";
        if (data['child'] == undefined) {
            htmlStr = '<li><a onclick="xadmin.add_tab(\''+ data['name'] +'\',\''+ data['href'] +'\')"><i class="iconfont">'+ data['icon'] +'</i><cite>'+ data['name'] +'</cite></a></li>';
        } else {
            htmlStr = '<li><a href="javascript:;"><i class="iconfont left-nav-li" lay-tips="'+ data['name'] +'">'+data['icon']+'</i><cite>'+ data['name'] +'</cite>' +
                '<i class="iconfont nav_right">&#xe697;</i></a><ul class="sub-menu">' + getLeftMenu(data['child'], 0) + '</ul></li>';
        }
        return htmlStr + getLeftMenu(datas, index+1);
    }

    function setMenu() {
        if (getMenuApiUrl != "") {
            $.get(getMenuApiUrl, function (datas) {
                if (datas.status == "YES") {
                    menuList = datas.data;
                    var htmlStr = getLeftMenu(menuList);
                    $("#nav").empty().html(htmlStr);
                } else {
                    alert("菜单数据获取失败");
                    return false;
                }
            }, 'json');
        } else {
            var htmlStr = getLeftMenu(menuList);
            $("#nav").empty().html(htmlStr);
        }
    }

    setMenu();
});