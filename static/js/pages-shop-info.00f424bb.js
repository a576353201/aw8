(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-shop-info"],{8005:function(t,a,n){"use strict";var i=n("4ea4");n("ac1f"),n("5319"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,n("96cf");var e=i(n("1da1")),s={data:function(){return{shopData:{}}},onLoad:function(t){this.loadPageData(t.shop_id)},methods:{loadPageData:function(t){var a=this;return(0,e.default)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:a.$api.get({url:"/wanlshop/shop/page",data:{id:t},success:function(t){t.shop.bio=t.shop.bio.replace(/<img/g,"<img style='display: block;'"),a.shopData=t.shop}});case 1:case"end":return n.stop()}}),n)})))()},follow:function(){var t=this;return(0,e.default)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:t.shopData.follow=!t.shopData.follow,t.shopData.follow?t.shopData.like+=1:t.shopData.like-=1,t.$api.post({url:"/wanlshop/shop/follow",data:{id:t.shopData.id},success:function(a){t.shopData.follow=a}});case 3:case"end":return a.stop()}}),a)})))()}}};a.default=s},b096:function(t,a,n){"use strict";var i;n.d(a,"b",(function(){return e})),n.d(a,"c",(function(){return s})),n.d(a,"a",(function(){return i}));var e=function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("v-uni-view",{staticClass:"wanl-shop"},[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"shop_synopsis bg-white"},[n("v-uni-view",{staticClass:"margin-left-bj shopuser"},[n("v-uni-view",{staticClass:"cu-avatar round margin-right lg",style:{backgroundImage:"url("+t.$wanlshop.oss(t.shopData.avatar,52,52,2,"avatar")+")"}}),n("v-uni-view",{},[n("v-uni-view",{staticClass:"text-df"},[t._v(t._s(t.shopData.shopname||"加載中..."))]),n("v-uni-view",{staticClass:"wanl-gray text-min"},[t._v("粉丝數 "+t._s(t.shopData.like))]),n("v-uni-view",{staticClass:"wanl-gray text-min"},[t._v(t._s(t.shopData.city))])],1)],1),n("v-uni-view",{staticClass:"margin-right-bj cu-btn round wanl-bg-orange margin-top",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.follow.apply(void 0,arguments)}}},[t.shopData.follow?n("v-uni-text",[t._v("已關註")]):n("v-uni-view",[n("v-uni-text",{staticClass:"wlIcon-yiguanzhu1"}),t._v("關註")],1)],1)],1),n("v-uni-view",{staticClass:"shop_info bg-white margin-top-bj padding-lr-bj"},[n("v-uni-view",{staticClass:"padding-tb-bj solid-bottom"},[t._v("店鋪介紹")])],1),n("v-uni-view",{staticClass:"bg-white padding-bj"},[n("v-uni-rich-text",{attrs:{nodes:t.shopData.bio}})],1)],1)},s=[]},bea4:function(t,a,n){"use strict";n.r(a);var i=n("8005"),e=n.n(i);for(var s in i)"default"!==s&&function(t){n.d(a,t,(function(){return i[t]}))}(s);a["default"]=e.a},e56c:function(t,a,n){"use strict";n.r(a);var i=n("b096"),e=n("bea4");for(var s in e)"default"!==s&&function(t){n.d(a,t,(function(){return e[t]}))}(s);var o,r=n("f0c5"),u=Object(r["a"])(e["default"],i["b"],i["c"],!1,null,"0317247c",null,!1,i["a"],o);a["default"]=u.exports}}]);