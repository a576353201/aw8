/*********************************
 * Themes, rules, and i18n support
 * Locale: Chinese; 中文
 *********************************/
(function(factory) {
    typeof module === "object" && module.exports ? module.exports = factory( require( "jquery" ) ) :
    typeof define === 'function' && define.amd ? define(['jquery'], factory) :
    factory(jQuery);
}(function($) {

    /* Global configuration
     */
    $.validator.config({
        //stopOnError: true,
        //focusCleanup: true,
        //theme: 'yellow_right',
        //timely: 2,

        // Custom rules
        rules: {
            digits: [/^\d+$/, "请填写数字"]
            ,letters: [/^[a-z]+$/i, "请填写字母"]
            ,date: [/^\d{4}-\d{2}-\d{2}$/, "请填写有效的日期，格式:yyyy-mm-dd"]
            ,time: [/^([01]\d|2[0-3])(:[0-5]\d){1,2}$/, "请填写有效的時間，00:00到23:59之間"]
            ,email: [/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i, "请填写有效的邮箱"]
            ,url: [/^(https?|s?ftp):\/\/\S+$/i, "请填写有效的網址"]
            ,qq: [/^[1-9]\d{4,}$/, "请填写有效的QQ号"]
            ,IDcard: [/^\d{6}(19|2\d)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)?$/, "请填写正确的身份证号码"]
            ,tel: [/^(?:(?:0\d{2,3}[\- ]?[1-9]\d{6,7})|(?:[48]00[\- ]?[1-9]\d{6}))$/, "请填写有效的电话号码"]
            ,mobile: [/^1[3-9]\d{9}$/, "请填写有效的手机号"]
            ,zipcode: [/^\d{6}$/, "请檢查邮政编码格式"]
            ,chinese: [/^[\u0391-\uFFE5]+$/, "请填写中文字符"]
            ,username: [/^\w{3,12}$/, "请填写3-12位数字、字母、下劃线"]
            ,password: [/^[\S]{6,16}$/, "请填写6-16位字符，不能包含空格"]
            ,accept: function (element, params){
                if (!params) return true;
                var ext = params[0],
                    value = $(element).val();
                return (ext === '*') ||
                       (new RegExp(".(?:" + ext + ")$", "i")).test(value) ||
                       this.renderMsg("只接受{1}后綴的文件", ext.replace(/\|/g, ','));
            }
            
        },

        // Default error messages
        messages: {
            0: "此处",
            fallback: "{0}格式不正确",
            loading: "正在验证...",
            error: "網絡异常",
            timeout: "请求超時",
            required: "{0}不能为空",
            remote: "{0}已被使用",
            integer: {
                '*': "请填写整数",
                '+': "请填写正整数",
                '+0': "请填写正整数或0",
                '-': "请填写负整数",
                '-0': "请填写负整数或0"
            },
            match: {
                eq: "{0}与{1}不壹致",
                neq: "{0}与{1}不能相同",
                lt: "{0}必须小於{1}",
                gt: "{0}必须大於{1}",
                lte: "{0}不能大於{1}",
                gte: "{0}不能小於{1}"
            },
            range: {
                rg: "请填写{1}到{2}的数",
                gte: "请填写不小於{1}的数",
                lte: "请填写最大{1}的数",
                gtlt: "请填写{1}到{2}之間的数",
                gt: "请填写大於{1}的数",
                lt: "请填写小於{1}的数"
            },
            checked: {
                eq: "请选择{1}項",
                rg: "请选择{1}到{2}項",
                gte: "请至少选择{1}項",
                lte: "请最多选择{1}項"
            },
            length: {
                eq: "请填写{1}个字符",
                rg: "请填写{1}到{2}个字符",
                gte: "请至少填写{1}个字符",
                lte: "请最多填写{1}个字符",
                eq_2: "",
                rg_2: "",
                gte_2: "",
                lte_2: ""
            }
        }
    });

    /* Themes
     */
    var TPL_ARROW = '<span class="n-arrow"><b>◆</b><i>◆</i></span>';
    $.validator.setTheme({
        'simple_right': {
            formClass: 'n-simple',
            msgClass: 'n-right'
        },
        'simple_bottom': {
            formClass: 'n-simple',
            msgClass: 'n-bottom'
        },
        'yellow_top': {
            formClass: 'n-yellow',
            msgClass: 'n-top',
            msgArrow: TPL_ARROW
        },
        'yellow_right': {
            formClass: 'n-yellow',
            msgClass: 'n-right',
            msgArrow: TPL_ARROW
        },
        'yellow_right_effect': {
            formClass: 'n-yellow',
            msgClass: 'n-right',
            msgArrow: TPL_ARROW,
            msgShow: function($msgbox, type){
                var $el = $msgbox.children();
                if ($el.is(':animated')) return;
                if (type === 'error') {
                    $el.css({left: '20px', opacity: 0})
                        .delay(100).show().stop()
                        .animate({left: '-4px', opacity: 1}, 150)
                        .animate({left: '3px'}, 80)
                        .animate({left: 0}, 80);
                } else {
                    $el.css({left: 0, opacity: 1}).fadeIn(200);
                }
            },
            msgHide: function($msgbox, type){
                var $el = $msgbox.children();
                $el.stop().delay(100).show()
                    .animate({left: '20px', opacity: 0}, 300, function(){
                        $msgbox.hide();
                    });
            }
        }
    });
}));
