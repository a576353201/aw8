(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-order-addorder"],{"0fec1":function(t,e,s){"use strict";var i;s.d(e,"b",(function(){return a})),s.d(e,"c",(function(){return n})),s.d(e,"a",(function(){return i}));var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("v-uni-view",[s("v-uni-view",{staticClass:"edgeInsetTop"}),s("v-uni-view",{staticClass:"wanl-order"},[s("v-uni-view",{staticClass:"address cu-list menu-avatar margin-bj radius-bock"},[s("v-uni-view",{staticClass:"cu-item"},[s("v-uni-view",{staticClass:"cu-avatar round wanl-bg-orange"},[s("v-uni-text",{staticClass:"wlIcon-weizhi1"})],1),t.addressData.address?s("v-uni-view",{staticClass:"content",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.userAddress()}}},[s("v-uni-view",[s("v-uni-text",{staticClass:"wanl-pip margin-right-sm"},[t._v(t._s(t.addressData.name))]),s("v-uni-text",{staticClass:"wanl-gray-light text-sm"},[t._v(t._s(t.addressData.mobile))])],1),s("v-uni-view",{staticClass:"text-sm wanl-pip text-cut"},[t._v(t._s(t.addressData.province)+" "+t._s(t.addressData.city)+" "+t._s(t.addressData.district)+" "+t._s(t.addressData.address))])],1):s("v-uni-view",{staticClass:"content",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.addAddress("newadd")}}},[s("v-uni-view",{staticClass:"text-sm wanl-pip text-cut"},[t._v("点击此处填写收货地址")])],1),s("v-uni-view",{staticClass:"action"},[s("v-uni-text",{staticClass:"wlIcon-fanhui2 text-lg"})],1)],1)],1),t._l(t.orderData.lists,(function(e,i){return s("v-uni-view",{key:i,staticClass:"lists bg-white margin-bj radius-bock"},[s("v-uni-view",{staticClass:"shopname"},[s("v-uni-text",{staticClass:"wlIcon-dianpu2 text-orange margin-right-sm"}),s("v-uni-text",{staticClass:"wanl-pip text-df"},[t._v(t._s(e.shop_name))])],1),s("v-uni-view",{staticClass:"cu-list menu-avatar"},t._l(e.products,(function(e,i){return s("v-uni-view",{key:i,staticClass:"cu-item margin-bottom"},[s("v-uni-view",{staticClass:"cu-avatar radius-bock",style:{backgroundImage:"url("+t.$wanlshop.oss(e.image,77,77)+")"}}),s("v-uni-view",{staticClass:"content"},[s("v-uni-view",{staticClass:"text-sm text-cut-2"},[t._v(t._s(e.title))]),s("v-uni-view",{staticClass:"wanl_sku text-sm"},t._l(e.sku.difference,(function(e,i){return s("v-uni-text",{key:i},[0!=i?[t._v("-")]:t._e(),t._v(t._s(e))],2)})),1)],1),s("v-uni-view",{staticClass:"action"},[s("v-uni-view",{staticClass:"wanl-pip text-sm text-price"},[t._v(t._s(e.sku.price))]),s("v-uni-view",{staticClass:"wanl-gray-light text-sm"},[t._v("x"+t._s(e.number))])],1)],1)})),1),s("v-uni-form",[s("v-uni-view",{staticClass:"cu-form-group"},[s("v-uni-view",{staticClass:"wanl-gray-light title"},[t._v("快遞運費")]),s("v-uni-view",{staticClass:"picker"},[t._v(t._s(e.freight.name)),s("v-uni-text",{staticClass:"text-price margin-left-xs"},[t._v(t._s(e.freight.price))])],1)],1),s("v-uni-view",{staticClass:"cu-form-group",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.queryCoupon(i)}}},[s("v-uni-view",{staticClass:"wanl-gray-light title"},[t._v("优惠折扣")]),s("v-uni-view",{staticClass:"picker"},[t.couponData[i]?[s("v-uni-text",{staticClass:"wlIcon-youhuiquantuangou text-red margin-right-xs"}),"reduction"==t.couponData[i].type||"vip"==t.couponData[i].type&&"reduction"==t.couponData[i].usertype?[s("v-uni-text",[t._v("滿"+t._s(Number(t.couponData[i].limit))+"减")]),t._v("￥"+t._s(Number(t.couponData[i].price)))]:t._e(),"discount"==t.couponData[i].type||"vip"==t.couponData[i].type&&"discount"==t.couponData[i].usertype?[s("v-uni-text",[t._v("滿"+t._s(Number(t.couponData[i].limit))+"打")]),t._v(t._s(Number(t.couponData[i].discount))+" 折")]:t._e(),"shipping"==t.couponData[i].type?[s("v-uni-text",[t._v("滿"+t._s(Number(t.couponData[i].limit)))]),t._v("包邮")]:t._e()]:[s("v-uni-text",{staticClass:"text-gray"},[t._v("请选择")])],s("v-uni-text",{staticClass:"wlIcon-fanhui2 margin-left"})],2)],1),s("v-uni-view",{staticClass:"cu-form-group align-start"},[s("v-uni-view",{staticClass:"wanl-gray-light title"},[t._v("備注")]),s("v-uni-textarea",{attrs:{maxlength:"-1",placeholder:"订单備注可选"},model:{value:e.remarks,callback:function(s){t.$set(e,"remarks",s)},expression:"shop.remarks"}})],1)],1),s("v-uni-view",{staticClass:"text-right margin-bj text-sm"},[s("v-uni-text",{staticClass:"wanl-gray"},[t._v("共"+t._s(e.number)+"件，")]),t._v("小计："),s("v-uni-text",{staticClass:"text-price text-orange"},[t._v(t._s(e.sub_price))])],1)],1)})),s("v-uni-view",{staticClass:"safeAreaBottom"}),s("v-uni-view",{staticClass:"WANL-MODAL text-sm",on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.moveHandle.apply(void 0,arguments)}}},[s("v-uni-view",{staticClass:"cu-modal bottom-modal",class:"coupon"==t.modalName?"show":"",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.hideModal.apply(void 0,arguments)}}},[s("v-uni-view",{staticClass:"cu-dialog bg-bgcolor",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e)}}},[s("v-uni-view",{staticClass:"wanl-modal"},[s("v-uni-view",{staticClass:"head padding-bj"},[s("v-uni-view",{staticClass:"content"},[s("v-uni-view",{staticClass:"text-lg"},[t._v("优惠券")])],1),s("v-uni-view",{staticClass:"close wlIcon-31guanbi",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.hideModal.apply(void 0,arguments)}}})],1),null!=t.couponIndex?s("v-uni-scroll-view",{staticClass:"wanl-coupon scroll-y",attrs:{"scroll-y":"true"}},t._l(t.orderData.lists[t.couponIndex].coupon,(function(e,i){return s("v-uni-view",{key:i,staticClass:"item margin-bottom-bj radius-bock",class:e.type},[s("v-uni-image",{staticClass:"coupon-bg",attrs:{src:t.$wanlshop.appstc("/coupon/bg_coupon_3x.png")}}),e.state?s("v-uni-image",{staticClass:"coupon-sign",attrs:{src:t.$wanlshop.appstc("/coupon/img_couponcentre_received_3x.png")}}):t._e(),s("v-uni-view",{staticClass:"item-left"},["reduction"==e.type||"vip"==e.type&&"reduction"==e.usertype?[s("v-uni-view",{staticClass:"colour"},[s("v-uni-text",{staticClass:"text-price"}),s("v-uni-text",{staticClass:"prices"},[t._v(t._s(Number(e.price)))])],1),s("v-uni-view",{staticClass:"cu-tag wanl-gray-dark radius text-sm bg-white"},[t._v("滿"+t._s(Number(e.limit))+"减"+t._s(Number(e.price)))])]:t._e(),"discount"==e.type||"vip"==e.type&&"discount"==e.usertype?[s("v-uni-view",{staticClass:"colour"},[s("v-uni-text",{staticClass:"prices"},[t._v(t._s(Number(e.discount)))]),s("v-uni-text",{staticClass:"discount"},[t._v("折")])],1),s("v-uni-view",{staticClass:"cu-tag wanl-gray-dark radius text-sm bg-white"},[t._v("滿"+t._s(Number(e.limit))+"打"+t._s(Number(e.discount))+"折")])]:t._e(),"shipping"==e.type?[s("v-uni-view",{staticClass:"colour"},[s("v-uni-text",{staticClass:"prices"},[t._v("包邮")])],1),s("v-uni-view",{staticClass:"cu-tag wanl-gray-dark radius text-sm bg-white"},[t._v("滿"+t._s(Number(e.limit))+"NT$包邮")])]:t._e()],2),s("v-uni-view",{staticClass:"item-right padding-bj"},[s("v-uni-view",{staticClass:"title"},[s("v-uni-view",{staticClass:"cu-tag sm radius margin-right-xs tagstyle"},[t._v(t._s(e.type_text))]),s("v-uni-text",{staticClass:"text-cut wanl-gray text-min"},[t._v(t._s(e.name))])],1),s("v-uni-view",{staticClass:"content text-min"},[s("v-uni-view",{staticClass:"wanl-gray"},["-1"!=e.grant?s("v-uni-view",[s("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("现時僅剩餘 "+t._s(e.surplus)+" 張")],1):t._e(),0!=e.drawlimit?s("v-uni-view",[s("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("每人僅限領取 "+t._s(e.drawlimit)+" 張")],1):t._e(),"fixed"==e.pretype?[s("v-uni-view",[s("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("生效 "+t._s(e.startdate))],1),s("v-uni-view",[s("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("结束 "+t._s(e.enddate))],1)]:t._e(),"appoint"==e.pretype?[0==e.validity?s("v-uni-view",[s("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("未使用前 永久 有效")],1):s("v-uni-view",[s("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("領取后 "+t._s(e.validity)+" 天有效")],1)]:t._e()],2),e.state?s("v-uni-view",{staticClass:"cu-btn sm round line-colour",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.onCoupons(i)}}},[e.choice?s("v-uni-text",[t._v("已选择")]):s("v-uni-text",[t._v("立即使用")])],1):s("v-uni-view",{staticClass:"cu-btn sm round",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.onReceive(i)}}},[t._v("立即領取")])],1)],1)],1)})),1):t._e(),s("v-uni-view",{staticClass:"foot padding-lr-bj"},[s("v-uni-button",{staticClass:"cu-btn bg-gradual-orange round text-bold complete",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.hideModal.apply(void 0,arguments)}}},[t._v("完成")])],1)],1)],1)],1)],1),s("v-uni-view",{staticClass:"wanlian cu-bar tabbar solid-top foot text-df"},[s("v-uni-view",[s("v-uni-text",{staticClass:"wanl-gray"},[t._v("共"+t._s(t.orderData.statis.allnum)+"件，")]),t._v("合计："),s("v-uni-text",{staticClass:"text-price text-orange"},[t._v(t._s(t.orderData.statis.allsub))])],1),s("v-uni-button",{staticClass:"cu-btn round lg bg-gradual-orange margin-lr-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.addOrder.apply(void 0,arguments)}}},[t._v("提交订单")])],1)],2)],1)},n=[]},"47e8":function(t,e,s){"use strict";s.r(e);var i=s("98cb"),a=s.n(i);for(var n in i)"default"!==n&&function(t){s.d(e,t,(function(){return i[t]}))}(n);e["default"]=a.a},6062:function(t,e,s){"use strict";var i=s("6d61"),a=s("6566");t.exports=i("Set",(function(t){return function(){return t(this,arguments.length?arguments[0]:void 0)}}),a)},6566:function(t,e,s){"use strict";var i=s("9bf2").f,a=s("7c73"),n=s("e2cc"),r=s("0366"),o=s("19aa"),u=s("2266"),c=s("7dd0"),l=s("2626"),d=s("83ab"),v=s("f183").fastKey,p=s("69f3"),h=p.set,f=p.getterFor;t.exports={getConstructor:function(t,e,s,c){var l=t((function(t,i){o(t,l,e),h(t,{type:e,index:a(null),first:void 0,last:void 0,size:0}),d||(t.size=0),void 0!=i&&u(i,t[c],t,s)})),p=f(e),w=function(t,e,s){var i,a,n=p(t),r=m(t,e);return r?r.value=s:(n.last=r={index:a=v(e,!0),key:e,value:s,previous:i=n.last,next:void 0,removed:!1},n.first||(n.first=r),i&&(i.next=r),d?n.size++:t.size++,"F"!==a&&(n.index[a]=r)),t},m=function(t,e){var s,i=p(t),a=v(e);if("F"!==a)return i.index[a];for(s=i.first;s;s=s.next)if(s.key==e)return s};return n(l.prototype,{clear:function(){var t=this,e=p(t),s=e.index,i=e.first;while(i)i.removed=!0,i.previous&&(i.previous=i.previous.next=void 0),delete s[i.index],i=i.next;e.first=e.last=void 0,d?e.size=0:t.size=0},delete:function(t){var e=this,s=p(e),i=m(e,t);if(i){var a=i.next,n=i.previous;delete s.index[i.index],i.removed=!0,n&&(n.next=a),a&&(a.previous=n),s.first==i&&(s.first=a),s.last==i&&(s.last=n),d?s.size--:e.size--}return!!i},forEach:function(t){var e,s=p(this),i=r(t,arguments.length>1?arguments[1]:void 0,3);while(e=e?e.next:s.first){i(e.value,e.key,this);while(e&&e.removed)e=e.previous}},has:function(t){return!!m(this,t)}}),n(l.prototype,s?{get:function(t){var e=m(this,t);return e&&e.value},set:function(t,e){return w(this,0===t?0:t,e)}}:{add:function(t){return w(this,t=0===t?0:t,t)}}),d&&i(l.prototype,"size",{get:function(){return p(this).size}}),l},setStrong:function(t,e,s){var i=e+" Iterator",a=f(e),n=f(i);c(t,e,(function(t,e){h(this,{type:i,target:t,state:a(t),kind:e,last:void 0})}),(function(){var t=n(this),e=t.kind,s=t.last;while(s&&s.removed)s=s.previous;return t.target&&(t.last=s=s?s.next:t.state.first)?"keys"==e?{value:s.key,done:!1}:"values"==e?{value:s.value,done:!1}:{value:[s.key,s.value],done:!1}:(t.target=void 0,{value:void 0,done:!0})}),s?"entries":"values",!s,!0),l(e)}}},"98cb":function(t,e,s){"use strict";var i=s("4ea4");s("4160"),s("a630"),s("a15b"),s("b64b"),s("d3b7"),s("6062"),s("3ca3"),s("159b"),s("ddb0"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,s("96cf");var a=i(s("1da1")),n={data:function(){return{addressData:{},modalName:null,cartType:null,couponData:{},couponIndex:null,orderData:{lists:[],statis:{allnum:1,allsub:0}}}},onLoad:function(t){this.loadData(t.data),this.cartType=t.type},methods:{loadData:function(t){var e=this;return(0,a.default)(regeneratorRuntime.mark((function s(){return regeneratorRuntime.wrap((function(s){while(1)switch(s.prev=s.next){case 0:e.$api.post({url:"/wanlshop/order/getOrderGoodsList",loadingTip:"加载中",data:t,success:function(t){e.orderData=t.orderData,t.addressData?e.addressData=t.addressData:e.addAddress("newadd")}});case 1:case"end":return s.stop()}}),s)})))()},addOrder:function(){var t=this;return(0,a.default)(regeneratorRuntime.mark((function e(){var s,i,a;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(0!==t.orderData.statis.allnum){e.next=3;break}return t.$wanlshop.msg("订单异常"),e.abrupt("return");case 3:if(s=t.addressData.id,0!==s){e.next=7;break}return t.$wanlshop.msg("请填写地址"),e.abrupt("return");case 7:i={lists:[],address_id:s},a=[],t.orderData.lists.forEach((function(e,s){i.lists.push({shop_id:e.shop_id,wholesale_id:e.wholesale_id,remarks:e.remarks,products:[],coupon_id:t.couponData[s]?t.couponData[s].id:0}),e.products.forEach((function(t){a.push({goods_id:t.id,sku_id:t.sku.id}),i.lists[s].products.push({goods_id:t.id,number:t.number,sku_id:t.sku.id,freight_id:t.freight_id})}))})),t.$api.post({url:"/wanlshop/order/addOrder",data:{order:i},loadingTip:"提交订单中...",success:function(e){t.$store.commit("statistics/order",{pay:t.$store.state.statistics.order.pay+a.length});var s=Object.keys(t.couponData).length;0!=s&&t.$store.commit("statistics/dynamic",{coupon:t.$store.state.statistics.dynamic.coupon-s}),"cart"==t.cartType&&t.$store.dispatch("cart/del"),t.$wanlshop.to("/pages/user/money/pay?data=".concat(JSON.stringify(e)))}});case 10:case"end":return e.stop()}}),e)})))()},refreshList:function(t,e){var s=this;return(0,a.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:s.$api.post({url:"/wanlshop/address/address",data:{data:t,type:"add"},success:function(t){s.addressData=t}});case 1:case"end":return e.stop()}}),e)})))()},queryCoupon:function(t){var e=this;return(0,a.default)(regeneratorRuntime.mark((function s(){var i,a,n,r;return regeneratorRuntime.wrap((function(s){while(1)switch(s.prev=s.next){case 0:if(i=e.orderData.lists[t],0==i.coupon.length){for(a=[],n=[],r=0;r<i.products.length;r++)a.push(i.products[r]["id"]),n.push(i.products[r]["shop_category_id"]);e.$api.post({url:"/wanlshop/coupon/query",data:{shop_id:i.shop_id,goods_id:e.unique(a),shop_category_id:e.unique(n),price:i.order_price},success:function(t){i.coupon=t}})}e.couponIndex=t,e.modalName="coupon";case 4:case"end":return s.stop()}}),s)})))()},onReceive:function(t){var e=this;return(0,a.default)(regeneratorRuntime.mark((function s(){var i;return regeneratorRuntime.wrap((function(s){while(1)switch(s.prev=s.next){case 0:i=e.orderData.lists[e.couponIndex].coupon[t],e.$api.post({url:"/wanlshop/coupon/receive",loadingTip:"領取中",data:{id:i.id},success:function(t){i.id=t.id,i.state=!0,e.$wanlshop.msg(t.msg),e.$store.commit("statistics/dynamic",{coupon:e.$store.state.statistics.dynamic.coupon+1})}});case 2:case"end":return s.stop()}}),s)})))()},onCoupons:function(t){var e=this.orderData.lists[this.couponIndex],s=this.orderData.lists[this.couponIndex].coupon;if(s[t].choice=!s[t].choice,s[t].choice){for(var i=0;i<s.length;i++)i!=t&&(s[i].choice=!1);if(this.couponData[this.couponIndex]=s[t],("reduction"==s[t].type||"vip"==s[t].type&&"reduction"==s[t].usertype)&&(e.freight.price=e.freight_price_bak,e.sub_price=this.$wanlshop.bcsub(this.$wanlshop.bcadd(e.order_price,e.freight.price),s[t].price),e.sub_price<0&&(e.sub_price=.01)),"discount"==s[t].type||"vip"==s[t].type&&"discount"==s[t].usertype){var a=s[t].discount>10?this.$wanlshop.bcdiv(s[t].discount,100):this.$wanlshop.bcdiv(s[t].discount,10);e.freight.price=e.freight_price_bak,e.sub_price=this.$wanlshop.bcadd(this.$wanlshop.bcmul(e.order_price,a),e.freight.price)}"shipping"==s[t].type&&(e.freight.price=0,e.sub_price=e.order_price)}else this.couponData={},"shipping"==s[t].type&&(e.freight.price=e.freight_price_bak),e.sub_price=this.$wanlshop.bcadd(e.order_price,e.freight.price);this.orderData.statis.allsub=0;for(i=0;i<this.orderData.lists.length;i++)this.orderData.statis.allsub=this.$wanlshop.bcadd(this.orderData.statis.allsub,this.orderData.lists[i].sub_price);this.modalName=null},changeNum:function(t){t=0==t?1:t,this.orderData.lists[0].number=t,this.orderData.lists[0].products[0].number=t,this.orderData.statis.allnum=t,this.orderData.lists[0].sub_price=this.$wanlshop.bcmul(this.orderData.lists[0].products[0].sku.price,t),this.orderData.statis.allsub=this.$wanlshop.bcmul(this.orderData.lists[0].products[0].sku.price,t)},addAddress:function(t){this.$wanlshop.to("/pages/user/address/addressManage?type=".concat(t))},userAddress:function(){this.$wanlshop.to("/pages/user/address/address?source=1")},showModal:function(t){this.modalName=t},hideModal:function(){this.modalName=null},unique:function(t){return Array.from(new Set(t)).join(",")},moveHandle:function(){}}};e.default=n},"9e7b":function(t,e,s){"use strict";s.r(e);var i=s("0fec1"),a=s("47e8");for(var n in a)"default"!==n&&function(t){s.d(e,t,(function(){return a[t]}))}(n);var r,o=s("f0c5"),u=Object(o["a"])(a["default"],i["b"],i["c"],!1,null,"0a8765ea",null,!1,i["a"],r);e["default"]=u.exports}}]);