(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-shop-apply-details"],{3132:function(t,i,e){"use strict";var a=e("3820"),n=e.n(a);n.a},3820:function(t,i,e){var a=e("5704");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("4f3ead84",a,!0,{sourceMap:!1,shadowMode:!1})},4404:function(t,i,e){"use strict";e.r(i);var a=e("50fb"),n=e.n(a);for(var s in a)"default"!==s&&function(t){e.d(i,t,(function(){return a[t]}))}(s);i["default"]=n.a},"50fb":function(t,i,e){"use strict";var a=e("4ea4");Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0,e("96cf");var n=a(e("1da1")),s={data:function(){return{shopdata:{verify:0},verify_text:["立即入驻","入驻审核中","入驻审核中","已入驻 查看","未通过审核 修改"]}},onLoad:function(){this.loadData(),this.$store.state.user.isLogin&&this.loadData()},methods:{loadData:function(){var t=this;return(0,n.default)(regeneratorRuntime.mark((function i(){return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:t.$api.get({url:"/wanlshop/shop/apply",success:function(i){i&&(t.shopdata=i)}});case 1:case"end":return i.stop()}}),i)})))()},onApply:function(){this.$wanlshop.auth("/pages/shop/apply/apply?data=".concat(JSON.stringify(this.shopdata)))}}};i.default=s},5704:function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,".cu-bar[data-v-c9756450]{-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.wanlian.cu-bar.tabbar[data-v-c9756450]{background-color:#fff}.wanlian.cu-bar.tabbar .cu-btn[data-v-c9756450]{width:calc(100% - %?50?%)}.wanlian.cu-bar.tabbar .cu-btn.lg[data-v-c9756450]{font-size:%?32?%;height:%?86?%}.cu-form-group .title[data-v-c9756450], .cu-form-group uni-input[data-v-c9756450]{font-size:%?28?%}.wanl-apply .flow[data-v-c9756450]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.wanl-apply .flow .item[data-v-c9756450]{width:46%;height:%?590?%;position:relative}.wanl-apply .flow .item[data-v-c9756450]:last-child{height:%?400?%}.wanl-apply .flow .item .project[data-v-c9756450]{line-height:2.2}.wanl-apply .flow .item .point[data-v-c9756450]{display:-webkit-box;display:-webkit-flex;display:flex}.wanl-apply .flow .item .point .line[data-v-c9756450]{width:%?120?%;height:%?4?%;background-color:#ccc}.wanl-apply .flow .item .point .arrow[data-v-c9756450]{border:%?14?% solid transparent;border-left:%?30?% solid #ccc}\n/* 指向右 */.wanl-apply .flow .item .point.right[data-v-c9756450]{position:absolute;-webkit-box-align:center;-webkit-align-items:center;align-items:center;right:%?-110?%;top:%?76?%}\n/* 指向左 */.wanl-apply .flow .item .point.left[data-v-c9756450]{position:absolute;-webkit-box-align:center;-webkit-align-items:center;align-items:center;right:%?-96?%;top:%?76?%}.wanl-apply .flow .item .point.left .arrow[data-v-c9756450]{border:%?14?% solid transparent;border-right:%?30?% solid #ccc}\n/* 指向下 */.wanl-apply .flow .item .point.bottom[data-v-c9756450]{position:absolute;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;bottom:0;right:0;left:0}.wanl-apply .flow .item .point.bottom .line[data-v-c9756450]{width:%?4?%;height:%?120?%;margin-bottom:%?45?%}.wanl-apply .flow .item .point.bottom .arrow[data-v-c9756450]{position:absolute;bottom:0;border:%?14?% solid transparent;border-top:%?30?% solid #ccc}.wanl-apply .details[data-v-c9756450]{background-color:#f1efec;margin:%?50?% 0}.wanl-apply .details .details-item[data-v-c9756450]{display:-webkit-box;display:-webkit-flex;display:flex;border-bottom:%?2?% solid #fff}.wanl-apply .details .details-item .title[data-v-c9756450]{background-color:#e6e6e6;width:40%;padding:%?25?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.wanl-apply .details .details-item .center[data-v-c9756450]{width:100%;color:#474747}.wanl-apply .details .details-item .center>uni-view[data-v-c9756450]{border-bottom:%?2?% solid #fff;padding:%?25?%;line-height:1.5}.wanl-apply .details .details-item .center>uni-view[data-v-c9756450]:last-child{border:0}",""]),t.exports=i},"842f":function(t,i,e){"use strict";e.r(i);var a=e("cb81"),n=e("4404");for(var s in n)"default"!==s&&function(t){e.d(i,t,(function(){return n[t]}))}(s);e("3132");var l,v=e("f0c5"),c=Object(v["a"])(n["default"],a["b"],a["c"],!1,null,"c9756450",null,!1,a["a"],l);i["default"]=c.exports},cb81:function(t,i,e){"use strict";var a;e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return s})),e.d(i,"a",(function(){return a}));var n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",[e("v-uni-view",{staticClass:"edgeInsetTop"}),e("v-uni-view",{staticClass:"cu-bar"},[e("v-uni-view",{staticClass:"action sub-title"},[e("v-uni-text",{staticClass:"text-xl text-bold text-orange"},[t._v("商家入驻流程")]),e("v-uni-text",{staticClass:"text-ABC text-orange"},[t._v("Settled")])],1)],1),e("v-uni-view",{staticClass:"wanl-apply margin-xl"},[e("v-uni-view",{staticClass:"flow"},[e("v-uni-view",{staticClass:"item"},[e("v-uni-view",{staticClass:"project"},[e("v-uni-view",{staticClass:"text-center"},[e("v-uni-view",{staticClass:"cu-avatar xl round solid text-black margin-tb-sm"},[e("v-uni-text",{staticClass:"wlIcon-wo"})],1),e("v-uni-view",{staticClass:"text-lg text-bold "},[e("v-uni-text",[t._v("01 注冊登录")])],1)],1),e("v-uni-view",{staticClass:"text-min text-gray"},[e("v-uni-view",[e("v-uni-text",[t._v("1）进入系统注冊帳戶")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2）设置帳戶密码")])],1),e("v-uni-view",[e("v-uni-text",[t._v("3）进入PC用戶中心或在本业提交申请")])],1)],1)],1),e("v-uni-view",{staticClass:"point right"},[e("v-uni-view",{staticClass:"line"}),e("v-uni-view",{staticClass:"arrow"})],1)],1),e("v-uni-view",{staticClass:"item"},[e("v-uni-view",{staticClass:"project"},[e("v-uni-view",{staticClass:"text-center"},[e("v-uni-view",{staticClass:"cu-avatar xl round solid text-black margin-tb-sm"},[e("v-uni-text",{staticClass:"wlIcon-xiugaioryijian"})],1),e("v-uni-view",{staticClass:"text-lg text-bold "},[e("v-uni-text",[t._v("02 填写提交信息")])],1)],1),e("v-uni-view",{staticClass:"text-min text-gray"},[e("v-uni-view",[e("v-uni-text",[t._v("1）选择运营主体，填写与运营主体相关资质")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2）提交店铺资质审核")])],1)],1)],1),e("v-uni-view",{staticClass:"point bottom"},[e("v-uni-view",{staticClass:"line"}),e("v-uni-view",{staticClass:"arrow"})],1)],1),e("v-uni-view",{staticClass:"item"},[e("v-uni-view",{staticClass:"project"},[e("v-uni-view",{staticClass:"text-center"},[e("v-uni-view",{staticClass:"cu-avatar xl round solid text-black margin-tb-sm"},[e("v-uni-text",{staticClass:"wlIcon-guanzhu1"})],1),e("v-uni-view",{staticClass:"text-lg text-bold "},[e("v-uni-text",[t._v("04 签署入驻协议")])],1)],1),e("v-uni-view",{staticClass:"text-min text-gray"},[e("v-uni-view",[e("v-uni-text",[t._v("1）签署入驻协议")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2）进入PC端用戶中心点击商家控制台进入后台")])],1)],1)],1),e("v-uni-view",{staticClass:"point left"},[e("v-uni-view",{staticClass:"arrow"}),e("v-uni-view",{staticClass:"line"})],1),e("v-uni-view",{staticClass:"point bottom"},[e("v-uni-view",{staticClass:"line"}),e("v-uni-view",{staticClass:"arrow"})],1)],1),e("v-uni-view",{staticClass:"item"},[e("v-uni-view",{staticClass:"project"},[e("v-uni-view",{staticClass:"text-center"},[e("v-uni-view",{staticClass:"cu-avatar xl round solid text-black margin-tb-sm"},[e("v-uni-text",{staticClass:"wlIcon-shijian"})],1),e("v-uni-view",{staticClass:"text-lg text-bold "},[e("v-uni-text",[t._v("03 等待系统审核")])],1)],1),e("v-uni-view",{staticClass:"text-min text-gray"},[e("v-uni-view",[e("v-uni-text",[t._v("1）7个工作日内反饋审核")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2）查看审核结果，重新提交或进入下一步")])],1),e("v-uni-view",[e("v-uni-text",[t._v("3）联系平台或等客服联系")])],1)],1)],1)],1),e("v-uni-view",{staticClass:"item"},[e("v-uni-view",{staticClass:"project"},[e("v-uni-view",{staticClass:"text-center"},[e("v-uni-view",{staticClass:"cu-avatar xl round solid text-black margin-tb-sm"},[e("v-uni-text",{staticClass:"wlIcon-dianpu"})],1),e("v-uni-view",{staticClass:"text-lg text-bold "},[e("v-uni-text",[t._v("05 管理商家")])],1)],1),e("v-uni-view",{staticClass:"text-min text-gray"},[e("v-uni-view",[e("v-uni-text",[t._v("1）系统學習商家后台使用")])],1),e("v-uni-view",[e("v-uni-text",[t._v("1）恭喜您！入驻成功")])],1)],1)],1)],1)],1),e("v-uni-view",{staticClass:"cu-bar"},[e("v-uni-view",{staticClass:"action sub-title"},[e("v-uni-text",{staticClass:"text-xl text-bold text-orange"},[t._v("资质要求")]),e("v-uni-text",{staticClass:"text-ABC text-orange"},[t._v("dqizon")])],1)],1),e("v-uni-view",{staticClass:"details"},[e("v-uni-view",{staticClass:"details-item"},[e("v-uni-view",{staticClass:"title"},[e("v-uni-text",[t._v("个人店（公民身份证）")])],1),e("v-uni-view",{staticClass:"center text-sm"},[e("v-uni-view",[e("v-uni-text",[t._v("1.手持身份证照片")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2.姓名、手机号、微信号")])],1)],1)],1),e("v-uni-view",{staticClass:"details-item"},[e("v-uni-view",{staticClass:"title"},[e("v-uni-text",[t._v("企业店（企业资质）")])],1),e("v-uni-view",{staticClass:"center text-sm"},[e("v-uni-view",[e("v-uni-text",[t._v("1.企业营业执照複印件")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2.企业统一信用代码")])],1),e("v-uni-view",[e("v-uni-text",[t._v("3.法人身份证正反面")])],1)],1)],1),e("v-uni-view",{staticClass:"details-item"},[e("v-uni-view",{staticClass:"title"},[e("v-uni-text",[t._v("旗舰店（商标持有方或子公司）")])],1),e("v-uni-view",{staticClass:"center text-sm"},[e("v-uni-view",[e("v-uni-text",[t._v("1.企业营业执照複印件")])],1),e("v-uni-view",[e("v-uni-text",[t._v("2.企业统一信用代码")])],1),e("v-uni-view",[e("v-uni-text",[t._v("3.国家商标总局颁发的商标注冊证或商标受理通知书")])],1),e("v-uni-view",[e("v-uni-text",[t._v("4.法人身份证正反面")])],1)],1)],1)],1)],1),e("v-uni-view",{staticClass:"safeAreaBottom"}),e("v-uni-view",{staticClass:"wanlian cu-bar tabbar foot flex flex-direction"},[e("v-uni-button",{staticClass:"cu-btn wanl-bg-orange lg",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onApply()}}},[t._v(t._s(t.verify_text[t.shopdata.verify]))])],1)],1)},s=[]}}]);