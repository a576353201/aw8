(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-bank-add"],{"014f":function(a,e,n){var t=n("24fb");e=t(!1),e.push([a.i,".picker .flex uni-image[data-v-7bcd0564]{width:%?40?%;height:%?40?%}",""]),a.exports=e},"261e":function(a,e,n){"use strict";var t;n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return s})),n.d(e,"a",(function(){return t}));var i=function(){var a=this,e=a.$createElement,n=a._self._c||e;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("选择銀行")]),n("v-uni-picker",{attrs:{value:a.index,range:a.bankList,"range-key":"bankName"},on:{change:function(e){arguments[0]=e=a.$handleEvent(e),a.bankChange.apply(void 0,arguments)}}},[n("v-uni-view",{staticClass:"picker"},[a.index>-1?n("v-uni-view",{staticClass:"flex justify-end align-center"},[n("v-uni-image",{attrs:{src:"/static/images/bank/"+a.bankList[a.index].bankCode+".png"}}),n("v-uni-view",{staticClass:"margin-left-xs"},[a._v(a._s(a.bankList[a.index].bankName))])],1):n("v-uni-view",[a._v("请选择")])],1)],1)],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("銀行账号")]),n("v-uni-input",{attrs:{type:"text",placeholder:"填写銀行帳戶账号"},model:{value:a.bankData.cardCode,callback:function(e){a.$set(a.bankData,"cardCode",e)},expression:"bankData.cardCode"}})],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("銀行分行")]),n("v-uni-input",{attrs:{type:"text",placeholder:"填写銀行分行名称"},model:{value:a.bankData.bankName2,callback:function(e){a.$set(a.bankData,"bankName2",e)},expression:"bankData.bankName2"}})],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("开戶姓名")]),n("v-uni-input",{attrs:{type:"text",maxlength:"4",placeholder:"持帳戶人姓名"},model:{value:a.bankData.username,callback:function(e){a.$set(a.bankData,"username",e)},expression:"bankData.username"}})],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("行动电话号码")]),n("v-uni-input",{attrs:{type:"number",maxlength:"10",placeholder:"持帳戶人行动电话号码"},model:{value:a.bankData.mobile,callback:function(e){a.$set(a.bankData,"mobile",e)},expression:"bankData.mobile"}})],1),n("v-uni-view",{staticClass:"padding-bj flex flex-direction margin-top"},[n("v-uni-button",{staticClass:"cu-btn wanl-bg-orange lg",on:{click:function(e){arguments[0]=e=a.$handleEvent(e),a.confirm.apply(void 0,arguments)}}},[a._v("完成")])],1)],1)},s=[]},"46ae":function(a,e,n){var t=n("014f");"string"===typeof t&&(t=[[a.i,t,""]]),t.locals&&(a.exports=t.locals);var i=n("4f06").default;i("1328eeae",t,!0,{sourceMap:!1,shadowMode:!1})},"50c47":function(a,e,n){"use strict";n.r(e);var t=n("261e"),i=n("b0df");for(var s in i)"default"!==s&&function(a){n.d(e,a,(function(){return i[a]}))}(s);n("c271");var b,o=n("f0c5"),k=Object(o["a"])(i["default"],t["b"],t["c"],!1,null,"7bcd0564",null,!1,t["a"],b);e["default"]=k.exports},b0df:function(a,e,n){"use strict";n.r(e);var t=n("d94d"),i=n.n(t);for(var s in t)"default"!==s&&function(a){n.d(e,a,(function(){return t[a]}))}(s);e["default"]=i.a},c271:function(a,e,n){"use strict";var t=n("46ae"),i=n.n(t);i.a},d94d:function(a,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var t={data:function(){return{bankData:{username:"",mobile:"",bankCode:"",bankName:"",bankName2:"",cardCode:""},index:-1,bankList:[{bankCode:"B700",bankName:"中華邮政"},{bankCode:"B004",bankName:"台灣銀行"},{bankCode:"B006",bankName:"合作金库"},{bankCode:"B007",bankName:"第壹銀行"},{bankCode:"B008",bankName:"華南銀行"},{bankCode:"B009",bankName:"彰化商業銀行"},{bankCode:"B011",bankName:"上海商業銀行"},{bankCode:"B013",bankName:"國泰世華商業銀行"},{bankCode:"B016",bankName:"高雄銀行"},{bankCode:"B017",bankName:"兆豐國際商業銀行"},{bankCode:"B050",bankName:"台灣中小企業銀行"},{bankCode:"B052",bankName:"渣打國際商業銀行"},{bankCode:"B053",bankName:"台中商業銀行"},{bankCode:"B102",bankName:"華泰商業銀行"},{bankCode:"B108",bankName:"陽信商業銀行"},{bankCode:"B118",bankName:"板信商業銀行"},{bankCode:"B805",bankName:"遠東商業國際銀行"},{bankCode:"B806",bankName:"元大銀行"},{bankCode:"B808",bankName:"玉山銀行"},{bankCode:"B810",bankName:"星展銀行"},{bankCode:"B815",bankName:"日盛商業銀行"},{bankCode:"B816",bankName:"安泰商業銀行"},{bankCode:"B822",bankName:"中國信託商業銀行"},{bankCode:"B054",bankName:"京城商業銀行"},{bankCode:"B809",bankName:"凱基商業銀行"},{bankCode:"B103",bankName:"台灣新光商業銀行"},{bankCode:"B081",bankName:"台灣匯豐商業銀行"},{bankCode:"B005",bankName:"土地銀行"},{bankCode:"B803",bankName:"联邦商業銀行"},{bankCode:"B812",bankName:"台新國際商業銀行"},{bankCode:"B807",bankName:"永豐商業銀行"},{bankCode:"B012",bankName:"台北富邦銀行"},{bankCode:"B147",bankName:"三信商業銀行"}]}},methods:{confirm:function(){var a=this.bankData;if(a.bankCode)if(a.cardCode)if(a.username){var e=/^09[0-9]{8,8}$/;a.mobile&&e.test(a.mobile)?(this.$wanlshop.prePage().refreshList(a),this.$wanlshop.back(1)):this.$wanlshop.msg("请填写正确行动电话号")}else this.$wanlshop.msg("请填写真實姓名");else this.$wanlshop.msg("请选择账号");else this.$wanlshop.msg("请选择銀行帳戶")},bankChange:function(a){this.index=a.detail.value,this.bankData.bankCode=this.bankList[a.detail.value].bankCode,this.bankData.bankName=this.bankList[a.detail.value].bankName}}};e.default=t}}]);