(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-twshop-no_network"],{"0154":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var o={data:function(){return{number:0}},methods:{refresh:function(){var t=this;this.number+=1,uni.getNetworkType({success:function(n){"none"==n.networkType?5==t.number?uni.showModal({title:"提示",content:"哎呀，重繪了好多次還是沒有網絡，是否要直接進入系統",success:function(n){n.confirm?(t.$wanlshop.on("/pages/twshop/index"),t.$store.dispatch("common/init")):n.cancel&&(t.number=0)}}):t.$wanlshop.msg("正在檢測網絡，请稍等"):(t.$wanlshop.on("/pages/twshop/index"),t.$store.dispatch("common/init"))}})}}};n.default=o},"15f5":function(t,n,e){var o=e("24fb");n=o(!1),n.push([t.i,"uni-page-body[data-v-753c45c4]{background-color:#fff}.no_network[data-v-753c45c4]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;position:fixed;left:0;top:0;right:0;bottom:0;margin-bottom:%?200?%}.no_network uni-image[data-v-753c45c4]{width:%?360?%}.no_network .cu-btn.lg[data-v-753c45c4]{padding:0 %?50?%;font-size:%?28?%;height:%?70?%}body.?%PAGE?%[data-v-753c45c4]{background-color:#fff}",""]),t.exports=n},"3f68":function(t,n,e){"use strict";var o=e("8d5e"),i=e.n(o);i.a},"77bb":function(t,n,e){"use strict";e.r(n);var o=e("af22"),i=e("d2bc");for(var a in i)"default"!==a&&function(t){e.d(n,t,(function(){return i[t]}))}(a);e("3f68");var c,r=e("f0c5"),u=Object(r["a"])(i["default"],o["b"],o["c"],!1,null,"753c45c4",null,!1,o["a"],c);n["default"]=u.exports},"8d5e":function(t,n,e){var o=e("15f5");"string"===typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);var i=e("4f06").default;i("2a72e478",o,!0,{sourceMap:!1,shadowMode:!1})},af22:function(t,n,e){"use strict";var o;e.d(n,"b",(function(){return i})),e.d(n,"c",(function(){return a})),e.d(n,"a",(function(){return o}));var i=function(){var t=this,n=t.$createElement,o=t._self._c||n;return o("v-uni-view",[o("v-uni-view",{staticClass:"no_network"},[o("v-uni-image",{attrs:{src:e("e44a"),mode:"widthFix"}}),o("v-uni-view",{staticClass:"text-30 text-gray margin-bottom margin-top-lg"},[t._v("没有網络，请打开3G、4G或WIFI")]),o("v-uni-button",{staticClass:"cu-btn round lg line-gray",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.refresh.apply(void 0,arguments)}}},[t._v("刷新页面")])],1)],1)},a=[]},d2bc:function(t,n,e){"use strict";e.r(n);var o=e("0154"),i=e.n(o);for(var a in o)"default"!==a&&function(t){e.d(n,t,(function(){return o[t]}))}(a);n["default"]=i.a},e44a:function(t,n,e){t.exports=e.p+"static/img/network_default3x.021d3141.png"}}]);