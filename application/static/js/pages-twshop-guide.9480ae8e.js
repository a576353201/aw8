(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-twshop-guide"],{"324d":function(t,n,e){"use strict";e.r(n);var i=e("950c"),a=e("84c7");for(var s in a)"default"!==s&&function(t){e.d(n,t,(function(){return a[t]}))}(s);e("6b6c");var c,o=e("f0c5"),u=Object(o["a"])(a["default"],i["b"],i["c"],!1,null,"31fcbcb4",null,!1,i["a"],c);n["default"]=u.exports},"6b6c":function(t,n,e){"use strict";var i=e("8fbf"),a=e.n(i);a.a},"84c7":function(t,n,e){"use strict";e.r(n);var i=e("8a25"),a=e.n(i);for(var s in i)"default"!==s&&function(t){e.d(n,t,(function(){return i[t]}))}(s);n["default"]=a.a},"8a25":function(t,n,e){"use strict";var i=e("4ea4");Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var a=i(e("5530")),s=e("2f62"),c={data:function(){return{wanlsys:this.$wanlshop.wanlsys(),height:0,statusBar:0,current:0,duration:500,jumpover:"跳过",experience:"立即体验"}},computed:(0,a.default)({},(0,s.mapState)(["common"])),onReady:function(){this.height=this.wanlsys.height,this.statusBar=15},methods:{swiperChange:function(t){this.current=t.detail.current},launchFlag:function(){uni.setStorage({key:"wanlshop:launch",data:!0}),this.$wanlshop.to("/pages/twshop/twshop","none",0)}}};n.default=c},"8fbf":function(t,n,e){var i=e("e2a5");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var a=e("4f06").default;a("c1b31a68",i,!0,{sourceMap:!1,shadowMode:!1})},"950c":function(t,n,e){"use strict";var i;e.d(n,"b",(function(){return a})),e.d(n,"c",(function(){return s})),e.d(n,"a",(function(){return i}));var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",{staticClass:"wanl-guide"},[e("v-uni-swiper",{style:{height:t.wanlsys.windowHeight+"px"},attrs:{circular:"true",duration:t.duration},on:{change:function(n){arguments[0]=n=t.$handleEvent(n),t.swiperChange.apply(void 0,arguments)}}},t._l(t.common.adData.firstAdverts,(function(n,i){return e("v-uni-swiper-item",{key:i,staticClass:"item text-center",style:{backgroundColor:n.url.split("/")[2]}},[e("v-uni-view",{staticClass:"title",style:{marginTop:t.height+"px"}},[e("v-uni-view",{},[t._v(t._s(n.url.split("/")[0]))]),e("v-uni-text",[t._v(t._s(n.url.split("/")[1]))])],1),e("v-uni-image",{attrs:{src:t.$wanlshop.oss(n.media,280,0,1,"transparent","png"),mode:"aspectFit"}})],1)})),1),e("v-uni-view",{staticClass:"button",style:{top:t.statusBar+"px"}},[e("v-uni-button",{staticClass:"cu-btn round",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.launchFlag.apply(void 0,arguments)}}},[t._v(t._s(t.jumpover))])],1),t.current!=t.common.adData.firstAdverts.length-1?e("v-uni-view",{staticClass:"indicator text-df"},t._l(t.common.adData.firstAdverts,(function(n,i){return e("v-uni-view",{key:i,staticClass:"margin-lr-xs"},[t.current==i?e("v-uni-text",{staticClass:"wlIcon-xuanzeanniudian"}):e("v-uni-text",{staticClass:"wlIcon-xuanze"})],1)})),1):e("v-uni-view",{staticClass:"experience animation-scale-down"},[e("v-uni-button",{staticClass:"cu-btn round lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.launchFlag.apply(void 0,arguments)}}},[t._v(t._s(t.experience))])],1)],1)},s=[]},e2a5:function(t,n,e){var i=e("24fb");n=i(!1),n.push([t.i,'.wanl-guide[data-v-31fcbcb4]{position:relative}.wanl-guide uni-swiper-item .title[data-v-31fcbcb4]{margin-bottom:%?40?%;line-height:1.4;color:hsla(0,0%,100%,.8)}.wanl-guide uni-swiper-item .title > uni-view[data-v-31fcbcb4]{font-size:%?62?%}.wanl-guide uni-swiper-item .title > uni-text[data-v-31fcbcb4]{font-size:%?32?%;font-weight:300}.wanl-guide uni-swiper-item uni-image[data-v-31fcbcb4]{height:71%}.wanl-guide .button[data-v-31fcbcb4]{position:absolute;\r\n\r\n\r\nright:%?25?%\n}.wanl-guide .button .cu-btn[data-v-31fcbcb4]{padding:0 %?25?%;font-size:%?28?%;height:%?56?%;background-color:rgba(0,0,0,.2);color:hsla(0,0%,100%,.6)}.wanl-guide .experience[data-v-31fcbcb4]{position:absolute;left:0;right:0;bottom:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.wanl-guide .indicator[data-v-31fcbcb4]{position:absolute;left:0;right:0;bottom:%?120?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;color:hsla(0,0%,100%,.8)}.cu-btn.lg[data-v-31fcbcb4]{font-size:%?30?%}.cu-btn[data-v-31fcbcb4]:not([class*="bg-"]){background-color:hsla(0,0%,100%,.5)}',""]),t.exports=n}}]);