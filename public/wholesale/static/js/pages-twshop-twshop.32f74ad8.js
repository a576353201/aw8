(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-twshop-twshop"],{"39d4":function(t,e,n){"use strict";n.r(e);var a=n("9308"),i=n("93fc");for(var o in i)"default"!==o&&function(t){n.d(e,t,(function(){return i[t]}))}(o);var s,r=n("f0c5"),c=Object(r["a"])(i["default"],a["b"],a["c"],!1,null,"3f046820",null,!1,a["a"],s);e["default"]=c.exports},"50d8":function(t,e,n){"use strict";(function(t){var a=n("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=a(n("5530")),o=n("2f62"),s={data:function(){return{windowHeight:0,statusBar:0,countdown:5,cTimer:null}},computed:(0,i.default)({},(0,o.mapState)(["common"])),onReady:function(){var t=this.$wanlshop.wanlsys();this.windowHeight=t.windowHeight,this.statusBar=15,uni.createVideoContext("advertVideo").hideStatusBar()},onLoad:function(){var t=this;uni.getNetworkType({success:function(e){"none"==e.networkType?uni.redirectTo({url:"/pages/twshop/no_network",animationType:"fade-in",animationDuration:200}):t.loadExecution()}})},methods:{loadExecution:function(){try{var e=uni.getStorageSync("wanlshop:launch");e||0==this.$store.state.common.adData.firstAdverts.length?1==e?this.startTimer():this.clearTimerGuide():(uni.setStorage({key:"wanlshop:launch",data:!0,success:function(e){t.log("存储launchFlag")}}),this.clearTimerGuide())}catch(n){uni.setStorage({key:"wanlshop:launch",data:!0,success:function(e){t.log("error时存储launchFlag")}}),this.clearTimerGuide()}},outBtn:function(){this.clearTimerIndex()},outImage:function(){this.clearTimerIndex()},startTimer:function(){var t=this;null==this.cTimer&&(this.cTimer=setInterval((function(){t.countdown--,0==t.countdown&&t.clearTimerIndex()}),1e3))},clearTimerIndex:function(){clearInterval(this.cTimer),this.cTimer=null,uni.switchTab({url:"/pages/twshop/index"})},clearTimerGuide:function(){uni.redirectTo({url:"/pages/twshop/guide"}),clearInterval(this.cTimer),this.cTimer=null}}};e.default=s}).call(this,n("5a52")["default"])},9308:function(t,e,n){"use strict";var a;n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return o})),n.d(e,"a",(function(){return a}));var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",{staticClass:"wanl-advert",style:{height:t.windowHeight+"px"}},["video"==t.common.adData.openAdverts.type?n("v-uni-video",{ref:"advertVideo",style:{height:t.windowHeight+"px",width:"100%"},attrs:{id:"advertVideo",src:t.common.adData.openAdverts.media?t.common.adData.openAdverts.media:"",direction:0,objectFit:"fill",controls:!1,autoplay:!0,muted:!0,loop:!0}},[n("v-uni-cover-view",{staticClass:"advert-info",style:{top:t.statusBar+"px"}},[t._v("预加载系统中...")]),n("v-uni-cover-view",{staticClass:"advert-btn",style:{top:t.statusBar+"px"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.outBtn.apply(void 0,arguments)}}},[t._v("跳过 "+t._s(t.countdown))]),n("v-uni-cover-image",{staticClass:"advert-logo",style:{top:t.statusBar+"px"},attrs:{src:t.$wanlshop.appstc("/common/wanlian4@2x.png")}})],1):n("v-uni-view",[n("v-uni-image",{style:{height:t.windowHeight+"px",width:"100%"},attrs:{src:t.common.adData.openAdverts.media?t.$wanlshop.oss(t.common.adData.openAdverts.media,414,0,2,"transparent","png"):"",mode:"aspectFill"}}),n("v-uni-view",{staticClass:"advert-info",style:{top:t.statusBar+"px"}},[t._v("预加载系统中...")]),n("v-uni-view",{staticClass:"advert-btn",style:{top:t.statusBar+"px"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.outBtn.apply(void 0,arguments)}}},[t._v("跳过 "+t._s(t.countdown))]),n("v-uni-image",{staticClass:"advert-logo",style:{top:t.statusBar+"px"},attrs:{src:t.$wanlshop.appstc("/common/wanlian4@2x.png"),mode:""}})],1)],1)},o=[]},"93fc":function(t,e,n){"use strict";n.r(e);var a=n("50d8"),i=n.n(a);for(var o in a)"default"!==o&&function(t){n.d(e,t,(function(){return a[t]}))}(o);e["default"]=i.a}}]);