(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-order-logistics"],{"0311":function(t,e,n){"use strict";var i;n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return o})),n.d(e,"a",(function(){return i}));var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),t.isLoad?n("v-uni-view",{staticClass:"margin-bj bg-white radius-bock"},[n("v-uni-view",{staticClass:"flex align-center margin-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.phoneCall(t.data.kuaidi.tel)}}},[n("v-uni-view",{staticClass:"cu-avatar lg radius-bock bg-white",style:{backgroundImage:"url("+t.$wanlshop.oss(t.data.kuaidi.logo,40,40)+")"}}),n("v-uni-view",{staticClass:"margin-left-bj"},[n("v-uni-view",[t._v(t._s(t.data.kuaidi.name))]),n("v-uni-view",{staticClass:"text-min"},[t._v("官方电话"),n("v-uni-text",{staticClass:"margin-lr-xs"},[t._v(t._s(t.data.kuaidi.tel))]),n("v-uni-text",{staticClass:"wlIcon-fanhuigengduo"})],1)],1)],1),n("v-uni-view",{staticClass:"courier-number",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.onCopy(t.data.express_no)}}},[t._v(t._s(t.data.kuaidi.name)),n("v-uni-text",{staticClass:"margin-lr-xs"},[t._v(t._s(t.data.express_no))]),n("v-uni-text",{staticClass:"wlIcon-lianjie"})],1)],1):t._e(),t.isLoad?n("v-uni-view",{staticClass:"margin-bj bg-white radius-bock"},[n("v-uni-view",{staticClass:"padding-left-bj padding-top-bj text-sm"},[t._v("运单详情")]),n("v-uni-view",{staticClass:"order-tracking"},[n("v-uni-view",{staticClass:"time-axis wanl-gray"},[t._l(t.data.express,(function(e,i){return n("v-uni-view",{key:e.id,staticClass:"timeaxis-item"},[0==i?[n("v-uni-view",{staticClass:"wanl-black"},[n("v-uni-view",[t._v(t._s(e.status))]),n("v-uni-view",{staticClass:"text-min"},[t._v(t._s(e.context))]),n("v-uni-view",{staticClass:"text-min margin-top-xs"},[t._v(t._s(e.time))])],1),n("v-uni-view",{staticClass:"timeaxis-node"},[n("v-uni-view",{staticClass:"cu-tag round wanl-bg-orange"},["在途"==e.status?n("v-uni-text",{staticClass:"wlIcon-dot"}):"揽收"==e.status?n("v-uni-text",{staticClass:"wlIcon-wuliuqiache2"}):"签收"==e.status?n("v-uni-text",{staticClass:"wlIcon-31xuanze"}):"派件"==e.status?n("v-uni-text",{staticClass:"wlIcon-paisongtixing"}):"疑难"==e.status?n("v-uni-text",{staticClass:"wlIcon-shiyongbangzhu1"}):"退签"==e.status?n("v-uni-text",{staticClass:"wlIcon-daifahuo"}):"退回"==e.status?n("v-uni-text",{staticClass:"wlIcon-guanbi"}):"转投"==e.status?n("v-uni-text",{staticClass:"wlIcon-jiangjia"}):"尚未付款"==e.status?n("v-uni-text",{staticClass:"wlIcon-31daifukuan"}):"已下单"==e.status?n("v-uni-text",{staticClass:"wlIcon-chanpincanshu"}):"仓库处理中"==e.status?n("v-uni-text",{staticClass:"wlIcon-shijian"}):t._e()],1)],1)]:[n("v-uni-view",["在途"!=e.status?n("v-uni-view",[t._v(t._s(e.status))]):t._e(),n("v-uni-view",{staticClass:"text-min"},[t._v(t._s(e.context))]),n("v-uni-view",{staticClass:"text-min margin-top-xs"},[t._v(t._s(e.time))])],1),n("v-uni-view",{staticClass:"timeaxis-node"},["在途"==e.status?n("v-uni-text",{staticClass:"wlIcon-dot"}):"揽收"==e.status?n("v-uni-view",{staticClass:"cu-tag round"},[n("v-uni-text",{staticClass:"wlIcon-wuliuqiache2"})],1):"疑难"==e.status?n("v-uni-text",{staticClass:"wlIcon-shiyongbangzhu1"}):"退签"==e.status?n("v-uni-text",{staticClass:"wlIcon-daifahuo"}):"派件"==e.status?n("v-uni-view",{staticClass:"cu-tag round"},[n("v-uni-text",{staticClass:"wlIcon-paisongtixing"})],1):"退回"==e.status?n("v-uni-text",{staticClass:"wlIcon-guanbi"}):"转投"==e.status?n("v-uni-text",{staticClass:"wlIcon-jiangjia"}):"尚未付款"==e.status?n("v-uni-text",{staticClass:"wlIcon-31daifukuan"}):"已下单"==e.status?n("v-uni-text",{staticClass:"wlIcon-chanpincanshu"}):"仓库处理中"==e.status?n("v-uni-text",{staticClass:"wlIcon-shijian"}):t._e()],1)]],2)})),n("v-uni-view",{staticClass:"timeaxis-item"},[n("v-uni-view",{staticClass:"text-min"},[t._v("包裹等待揽收")]),n("v-uni-view",{staticClass:"timeaxis-node"},[n("v-uni-text",{staticClass:"wlIcon-dot"})],1)],1)],2)],1)],1):t._e()],1)},o=[]},"0c47":function(t,e,n){var i=n("da84"),a=n("d44e");a(i.JSON,"JSON",!0)},"0f7d":function(t,e,n){"use strict";var i=n("efc6"),a=n.n(i);a.a},"131a":function(t,e,n){var i=n("23e7"),a=n("d2bb");i({target:"Object",stat:!0},{setPrototypeOf:a})},"23dc":function(t,e,n){var i=n("d44e");i(Math,"Math",!0)},"240e":function(t,e,n){"use strict";n.r(e);var i=n("37f2"),a=n.n(i);for(var o in i)"default"!==o&&function(t){n.d(e,t,(function(){return i[t]}))}(o);e["default"]=a.a},3410:function(t,e,n){var i=n("23e7"),a=n("d039"),o=n("7b0b"),r=n("e163"),s=n("e177"),c=a((function(){r(1)}));i({target:"Object",stat:!0,forced:c,sham:!s},{getPrototypeOf:function(t){return r(o(t))}})},"37f2":function(t,e,n){"use strict";var i=n("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,n("96cf");var a=i(n("1da1")),o=n("8592"),r={data:function(){return{data:{order_no:"加载中...",goods:[]},isLoad:!1}},onLoad:function(t){this.loadData({id:t.id})},methods:{loadData:function(t){var e=this;return(0,a.default)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:e.$api.post({url:"/wanlshop/order/getLogistics",loadingTip:"加载中",data:t,success:function(t){e.data=t,e.isLoad=!0}});case 1:case"end":return n.stop()}}),n)})))()},phoneCall:function(t){uni.makePhoneCall({phoneNumber:t})},onCopy:function(t){var e=this;o.getClipboardData(t,(function(t){t?e.$wanlshop.msg("单号複制成功"):e.$wanlshop.msg("单号複制失败")}))}}};e.default=r},5395:function(t,e,n){var i=n("24fb");e=i(!1),e.push([t.i,'.wanl-order-goods .scroll-view[data-v-5fdbb230]{white-space:nowrap;width:100%;display:-webkit-box;display:-webkit-flex;display:flex}.wanl-order-goods .scroll-view .list[data-v-5fdbb230]{display:-webkit-box;display:-webkit-flex;display:flex}.wanl-order-goods .scroll-view .list .item[data-v-5fdbb230]{margin-right:%?10?%}.wanl-order-goods .scroll-view .list .item .cu-avatar[data-v-5fdbb230]{width:%?150?%;height:%?150?%}.courier-number[data-v-5fdbb230]{font-size:%?22?%;padding:%?20?% %?25?%;background-color:#fbfbfb}.order-tracking[data-v-5fdbb230]{-webkit-box-sizing:border-box;box-sizing:border-box;padding:%?25?%;padding-left:%?50?%;padding-top:%?25?%}.order-tracking .cu-tag[data-v-5fdbb230]{font-size:%?22?%;padding:0 %?10?%;height:%?40?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;justify-items:center}.order-tracking .time-axis[data-v-5fdbb230]{padding-left:20px;-webkit-box-sizing:border-box;box-sizing:border-box;position:relative}.order-tracking .time-axis[data-v-5fdbb230]::before{content:" ";position:absolute;left:0;top:0;width:1px;bottom:0;border-left:1px solid #ddd;-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:scaleX(.5);transform:scaleX(.5)}.order-tracking .time-axis .timeaxis-item[data-v-5fdbb230]{position:relative;width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;margin-bottom:25px}.order-tracking .time-axis .timeaxis-item .timeaxis-node[data-v-5fdbb230]{position:absolute;top:0;left:-20px;-webkit-transform-origin:0;transform-origin:0;-webkit-transform:translateX(-50%);transform:translateX(-50%);display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;z-index:99}',""]),t.exports=e},8592:function(t,e,n){"use strict";var i=n("4ea4"),a=i(n("90c4")),o={getClipboardData:function(t,e){var n=window.event||{},i=new a.default("",{text:function(){return t}});i.on("success",(function(t){"function"==typeof e&&e(!0),i.off("success"),i.off("error"),i.destroy()})),i.on("error",(function(t){"function"==typeof e&&e(!1),i.off("success"),i.off("error"),i.destroy()})),i.onClick(n)}};t.exports={getClipboardData:o.getClipboardData}},"90c4":function(t,e,n){n("a4d3"),n("e01a"),n("d28b"),n("944a"),n("4160"),n("d81d"),n("fb6a"),n("0c47"),n("23dc"),n("3410"),n("131a"),n("d3b7"),n("25f0"),n("3ca3"),n("159b"),n("ddb0"),function(e,n){t.exports=n()}(0,(function(){return function(t){var e={};function n(i){if(e[i])return e[i].exports;var a=e[i]={i:i,l:!1,exports:{}};return t[i].call(a.exports,a,a.exports,n),a.l=!0,a.exports}return n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)n.d(i,a,function(e){return t[e]}.bind(null,a));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=0)}([function(t,e,n){"use strict";var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},a=function(){function t(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,n,i){return n&&t(e.prototype,n),i&&t(e,i),e}}(),o=c(n(1)),r=c(n(3)),s=c(n(4));function c(t){return t&&t.__esModule?t:{default:t}}var u=function(t){function e(t,n){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e);var i=function(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}(this,(e.__proto__||Object.getPrototypeOf(e)).call(this));return i.resolveOptions(n),i.listenClick(t),i}return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}(e,r.default),a(e,[{key:"resolveOptions",value:function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};this.action="function"==typeof t.action?t.action:this.defaultAction,this.target="function"==typeof t.target?t.target:this.defaultTarget,this.text="function"==typeof t.text?t.text:this.defaultText,this.container="object"===i(t.container)?t.container:document.body}},{key:"listenClick",value:function(t){var e=this;this.listener=(0,s.default)(t,"click",(function(t){return e.onClick(t)}))}},{key:"onClick",value:function(t){var e=t.delegateTarget||t.currentTarget;this.clipboardAction&&(this.clipboardAction=null),this.clipboardAction=new o.default({action:this.action(e),target:this.target(e),text:this.text(e),container:this.container,trigger:e,emitter:this})}},{key:"defaultAction",value:function(t){return l("action",t)}},{key:"defaultTarget",value:function(t){var e=l("target",t);if(e)return document.querySelector(e)}},{key:"defaultText",value:function(t){return l("text",t)}},{key:"destroy",value:function(){this.listener.destroy(),this.clipboardAction&&(this.clipboardAction.destroy(),this.clipboardAction=null)}}],[{key:"isSupported",value:function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:["copy","cut"],e="string"==typeof t?[t]:t,n=!!document.queryCommandSupported;return e.forEach((function(t){n=n&&!!document.queryCommandSupported(t)})),n}}]),e}();function l(t,e){var n="data-clipboard-"+t;if(e.hasAttribute(n))return e.getAttribute(n)}t.exports=u},function(t,e,n){"use strict";var i,a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o=function(){function t(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,n,i){return n&&t(e.prototype,n),i&&t(e,i),e}}(),r=n(2),s=(i=r)&&i.__esModule?i:{default:i},c=function(){function e(t){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e),this.resolveOptions(t),this.initSelection()}return o(e,[{key:"resolveOptions",value:function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};this.action=t.action,this.container=t.container,this.emitter=t.emitter,this.target=t.target,this.text=t.text,this.trigger=t.trigger,this.selectedText=""}},{key:"initSelection",value:function(){this.text?this.selectFake():this.target&&this.selectTarget()}},{key:"selectFake",value:function(){var t=this,e="rtl"==document.documentElement.getAttribute("dir");this.removeFake(),this.fakeHandlerCallback=function(){return t.removeFake()},this.fakeHandler=this.container.addEventListener("click",this.fakeHandlerCallback)||!0,this.fakeElem=document.createElement("textarea"),this.fakeElem.style.fontSize="12pt",this.fakeElem.style.border="0",this.fakeElem.style.padding="0",this.fakeElem.style.margin="0",this.fakeElem.style.position="absolute",this.fakeElem.style[e?"right":"left"]="-9999px";var n=window.pageYOffset||document.documentElement.scrollTop;this.fakeElem.style.top=n+"px",this.fakeElem.setAttribute("readonly",""),this.fakeElem.value=this.text,this.container.appendChild(this.fakeElem),this.selectedText=(0,s.default)(this.fakeElem),this.copyText()}},{key:"removeFake",value:function(){this.fakeHandler&&(this.container.removeEventListener("click",this.fakeHandlerCallback),this.fakeHandler=null,this.fakeHandlerCallback=null),this.fakeElem&&(this.container.removeChild(this.fakeElem),this.fakeElem=null)}},{key:"selectTarget",value:function(){this.selectedText=(0,s.default)(this.target),this.copyText()}},{key:"copyText",value:function(){var e=void 0;try{e=document.execCommand(this.action)}catch(t){e=!1}this.handleResult(e)}},{key:"handleResult",value:function(t){this.emitter.emit(t?"success":"error",{action:this.action,text:this.selectedText,trigger:this.trigger,clearSelection:this.clearSelection.bind(this)})}},{key:"clearSelection",value:function(){this.trigger&&this.trigger.focus(),window.getSelection().removeAllRanges()}},{key:"destroy",value:function(){this.removeFake()}},{key:"action",set:function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:"copy";if(this._action=t,"copy"!==this._action&&"cut"!==this._action)throw new Error('Invalid "action" value, use either "copy" or "cut"')},get:function(){return this._action}},{key:"target",set:function(t){if(void 0!==t){if(!t||"object"!==(void 0===t?"undefined":a(t))||1!==t.nodeType)throw new Error('Invalid "target" value, use a valid Element');if("copy"===this.action&&t.hasAttribute("disabled"))throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute');if("cut"===this.action&&(t.hasAttribute("readonly")||t.hasAttribute("disabled")))throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes');this._target=t}},get:function(){return this._target}}]),e}();t.exports=c},function(t,e){t.exports=function(t){var e;if("SELECT"===t.nodeName)t.focus(),e=t.value;else if("INPUT"===t.nodeName||"TEXTAREA"===t.nodeName){var n=t.hasAttribute("readonly");n||t.setAttribute("readonly",""),t.select(),t.setSelectionRange(0,t.value.length),n||t.removeAttribute("readonly"),e=t.value}else{t.hasAttribute("contenteditable")&&t.focus();var i=window.getSelection(),a=document.createRange();a.selectNodeContents(t),i.removeAllRanges(),i.addRange(a),e=i.toString()}return e}},function(t,e){function n(){}n.prototype={on:function(t,e,n){var i=this.e||(this.e={});return(i[t]||(i[t]=[])).push({fn:e,ctx:n}),this},once:function(t,e,n){var i=this;function a(){i.off(t,a),e.apply(n,arguments)}return a._=e,this.on(t,a,n)},emit:function(t){for(var e=[].slice.call(arguments,1),n=((this.e||(this.e={}))[t]||[]).slice(),i=0,a=n.length;i<a;i++)n[i].fn.apply(n[i].ctx,e);return this},off:function(t,e){var n=this.e||(this.e={}),i=n[t],a=[];if(i&&e)for(var o=0,r=i.length;o<r;o++)i[o].fn!==e&&i[o].fn._!==e&&a.push(i[o]);return a.length?n[t]=a:delete n[t],this}},t.exports=n},function(t,e,n){var i=n(5),a=n(6);t.exports=function(t,e,n){if(!t&&!e&&!n)throw new Error("Missing required arguments");if(!i.string(e))throw new TypeError("Second argument must be a String");if(!i.fn(n))throw new TypeError("Third argument must be a Function");if(i.node(t))return d=e,v=n,(f=t).addEventListener(d,v),{destroy:function(){f.removeEventListener(d,v)}};if(i.nodeList(t))return c=t,u=e,l=n,Array.prototype.forEach.call(c,(function(t){t.addEventListener(u,l)})),{destroy:function(){Array.prototype.forEach.call(c,(function(t){t.removeEventListener(u,l)}))}};if(i.string(t))return o=t,r=e,s=n,a(document.body,o,r,s);throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList");var o,r,s,c,u,l,f,d,v}},function(t,e){e.node=function(t){return void 0!==t&&t instanceof HTMLElement&&1===t.nodeType},e.nodeList=function(t){var n=Object.prototype.toString.call(t);return void 0!==t&&("[object NodeList]"===n||"[object HTMLCollection]"===n)&&"length"in t&&(0===t.length||e.node(t[0]))},e.string=function(t){return"string"==typeof t||t instanceof String},e.fn=function(t){return"[object Function]"===Object.prototype.toString.call(t)}},function(t,e,n){var i=n(7);function a(t,e,n,a,o){var r=function(t,e,n,a){return function(n){n.delegateTarget=i(n.target,e),n.delegateTarget&&a.call(t,n)}}.apply(this,arguments);return t.addEventListener(n,r,o),{destroy:function(){t.removeEventListener(n,r,o)}}}t.exports=function(t,e,n,i,o){return"function"==typeof t.addEventListener?a.apply(null,arguments):"function"==typeof n?a.bind(null,document).apply(null,arguments):("string"==typeof t&&(t=document.querySelectorAll(t)),Array.prototype.map.call(t,(function(t){return a(t,e,n,i,o)})))}},function(t,e){if("undefined"!=typeof Element&&!Element.prototype.matches){var n=Element.prototype;n.matches=n.matchesSelector||n.mozMatchesSelector||n.msMatchesSelector||n.oMatchesSelector||n.webkitMatchesSelector}t.exports=function(t,e){for(;t&&9!==t.nodeType;){if("function"==typeof t.matches&&t.matches(e))return t;t=t.parentNode}}}])}))},"944a":function(t,e,n){var i=n("746f");i("toStringTag")},c614:function(t,e,n){"use strict";n.r(e);var i=n("0311"),a=n("240e");for(var o in a)"default"!==o&&function(t){n.d(e,t,(function(){return a[t]}))}(o);n("0f7d");var r,s=n("f0c5"),c=Object(s["a"])(a["default"],i["b"],i["c"],!1,null,"5fdbb230",null,!1,i["a"],r);e["default"]=c.exports},efc6:function(t,e,n){var i=n("5395");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var a=n("4f06").default;a("32070662",i,!0,{sourceMap:!1,shadowMode:!1})}}]);