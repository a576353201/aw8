(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-service"],{"3da7":function(t,e,i){"use strict";var a;i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"wanl-chat"},[i("v-uni-view",{on:{touchstart:function(e){arguments[0]=e=t.$handleEvent(e),t.hideDrawer.apply(void 0,arguments)}}},[i("v-uni-scroll-view",{staticClass:"cu-chat",attrs:{"scroll-y":"true","scroll-with-animation":t.scrollAnimation,"scroll-top":t.scrollTop,"scroll-into-view":t.scrollToView,"upper-threshold":"50"}},t._l(t.msgList,(function(e,a){return i("v-uni-view",{key:a,attrs:{id:"msg"+e.id}},[e.form.id==t.user_id?i("v-uni-view",{staticClass:"cu-item self"},["text"==e.message.type?i("v-uni-view",{staticClass:"main"},[i("v-uni-view",{staticClass:"content bg-green"},[i("v-uni-rich-text",{attrs:{nodes:e.message.content.text}})],1)],1):t._e(),"img"==e.message.type?i("v-uni-view",{staticClass:"main"},[i("v-uni-image",{style:{width:e.message.content.w+"px",height:e.message.content.h+"px"},attrs:{src:e.message.content.url},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.showPic(e.message)}}})],1):t._e(),"voice"==e.message.type?i("v-uni-view",{staticClass:"main",class:t.playMsgid==e.message.id?"play":"",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.playVoice(e.message)}}},[i("v-uni-view",{staticClass:"action text-bold text-grey",staticStyle:{"padding-right":"2rpx"}},[t._v(t._s(e.message.content.length)),i("v-uni-text",{staticClass:"wlIcon-miao"})],1),i("v-uni-view",{staticClass:"content bg-green"},[i("v-uni-text",{style:{width:6*e.message.content.length+"rpx"}}),i("v-uni-text",{staticClass:"wlIcon-yuyinyou text-xxl padding-left-xl"})],1)],1):t._e(),i("v-uni-view",{staticClass:"cu-avatar round",style:{backgroundImage:"url("+t.$wanlshop.oss(e.form.avatar,44,44,2,"avatar")+")"}})],1):i("v-uni-view",{staticClass:"cu-item"},[e.form.avatar?i("v-uni-view",{staticClass:"cu-avatar round",style:{backgroundImage:"url("+t.$wanlshop.oss(e.form.avatar)+")"}}):i("v-uni-view",{staticClass:"cu-avatar round",style:{backgroundImage:"url("+t.$wanlshop.appstc("/common/logo.png")+")"}}),"text"==e.message.type?i("v-uni-view",{staticClass:"main"},[i("v-uni-view",{staticClass:"content"},[i("v-uni-rich-text",{attrs:{nodes:e.message.content.text}})],1)],1):t._e(),"list"==e.message.type?i("v-uni-view",{staticClass:"main"},[i("v-uni-view",{staticClass:"content"},[i("v-uni-view",{staticClass:"list"},[e.message.content.length>0?i("v-uni-view",[i("v-uni-view",[t._v("您是否想问 ？"),i("v-uni-view",{staticClass:"ai solid-top solid-bottom"},t._l(e.message.content,(function(e,a){return i("v-uni-view",{key:e.id,staticClass:"text-cut",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.aiSend(e.keywords?e.keywords:"未设置关键字")}}},[i("v-uni-text",[t._v(t._s(e.title))])],1)})),1)],1),i("v-uni-view",[t._v("都不是？您可以"),i("v-uni-text",{on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.aiSend("人工客服")}}},[t._v("点击此处")]),t._v("，或者回複人工")],1)],1):i("v-uni-view",[t._v("没有任何相关幫助内容，"),i("v-uni-text",{on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.aiSend("人工客服")}}},[t._v("点击此处")]),t._v("或者回複人工")],1)],1)],1)],1):t._e(),"article"==e.message.type?i("v-uni-view",{staticClass:"main",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onDetails(e.message.content.id,e.message.content.title)}}},[i("v-uni-view",{staticClass:"content"},[i("v-uni-view",{staticStyle:{width:"100%"}},[i("v-uni-view",[t._v(t._s(e.message.content.title))]),i("v-uni-view",{staticClass:"article solid-top"},[i("v-uni-rich-text",{attrs:{nodes:e.message.content.content}})],1)],1)],1)],1):t._e(),"img"==e.message.type?i("v-uni-view",{staticClass:"main"},[i("v-uni-image",{style:{width:e.message.content.w+"px",height:e.message.content.h+"px"},attrs:{src:e.message.content.url},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.showPic(e.message)}}})],1):t._e(),i("v-uni-view",{staticClass:"date"},[t._v(t._s(t.$wanlshop.timeToChat(e.createtime)))])],1)],1)})),1)],1),i("v-uni-view",{staticClass:"popup-layer",class:{showLayer:t.popupLayerClass},on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.discard.apply(void 0,arguments)}}},[i("v-uni-view",{class:{hidden:t.hideEmoji}},[i("v-uni-view",{staticClass:"emoji"},[i("v-uni-scroll-view",{staticClass:"emojinav",attrs:{"scroll-x":!0,"scroll-with-animation":!0}},[i("v-uni-view",{staticClass:"item"},t._l(t.emojiList.categories,(function(e,a){return i("v-uni-view",{key:a,class:e==t.TabCur?"emojibg":"",style:{backgroundImage:"url("+t.emojiList.groups[e][0].url+")"},attrs:{"data-id":e},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tabSelect.apply(void 0,arguments)}}})})),1)],1),t._l(t.emojiList.groups,(function(e,a){return t.TabCur==a?i("v-uni-scroll-view",{key:a,staticClass:"subject",attrs:{"scroll-y":!0,"scroll-with-animation":!0}},[i("v-uni-view",{staticClass:"item grid margin-bottom text-center col-5"},t._l(e,(function(e,a){return i("v-uni-view",{key:a,style:{backgroundImage:"url("+e.url+")"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.addEmoji(e.value)}}})})),1)],1):t._e()}))],2)],1),i("v-uni-view",{staticClass:"solid-top",class:{hidden:t.hideMore}},[i("v-uni-view",{staticClass:"opmenu solid-top"},[i("v-uni-view",{staticClass:"box",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.chooseImage.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"icon"},[i("v-uni-text",{staticClass:"wlIcon-tupian1"})],1),i("v-uni-text",{staticClass:"text-sm"},[t._v("照片")])],1)],1)],1)],1),i("v-uni-view",{staticClass:"input-box",class:{emptybottom:t.emptybottom,showLayer:t.popupLayerClass},on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.discard.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"more",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.showMore.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"wlIcon-yuanquanjiahao"})],1),i("v-uni-view",{staticClass:"textbox"},[i("v-uni-view",{staticClass:"voice-mode",class:[t.isVoice?"":"hidden",t.recording?"recording":""],on:{touchstart:function(e){arguments[0]=e=t.$handleEvent(e),t.voiceBegin.apply(void 0,arguments)},touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e),t.voiceIng.apply(void 0,arguments)},touchend:function(e){arguments[0]=e=t.$handleEvent(e),t.voiceEnd.apply(void 0,arguments)},touchcancel:function(e){arguments[0]=e=t.$handleEvent(e),t.voiceCancel.apply(void 0,arguments)}}},[t._v(t._s(t.voiceTis))]),i("v-uni-view",{staticClass:"text-mode",class:t.isVoice?"hidden":""},[i("v-uni-view",{staticClass:"box"},[i("v-uni-textarea",{attrs:{"auto-height":"true",maxlength:"300","show-confirm-bar":!1,"cursor-spacing":"90"},on:{focus:function(e){arguments[0]=e=t.$handleEvent(e),t.textareaFocus.apply(void 0,arguments)},blur:function(e){arguments[0]=e=t.$handleEvent(e),t.textareaBlur.apply(void 0,arguments)},confirm:function(e){arguments[0]=e=t.$handleEvent(e),t.sendText.apply(void 0,arguments)}},model:{value:t.textMsg,callback:function(e){t.textMsg=e},expression:"textMsg"}})],1),i("v-uni-view",{staticClass:"em",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.chooseEmoji.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"wlIcon-biaoqing2"})],1)],1)],1),i("v-uni-view",{staticClass:"send",class:t.isVoice?"hidden":"",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.sendText.apply(void 0,arguments)}}},[t.textMsg?i("v-uni-text",{staticClass:"wlIcon-zhifeiji"}):i("v-uni-text",{staticClass:"wlIcon-fasong"})],1)],1),i("v-uni-view",{staticClass:"record",class:t.recording?"":"hidden"},[i("v-uni-view",{staticClass:"ing",class:t.willStop?"hidden":""},[i("v-uni-view",{staticClass:"wlIcon-huatong01"})],1),i("v-uni-view",{staticClass:"cancel",class:t.willStop?"":"hidden"},[i("v-uni-view",{staticClass:"wlIcon-shanchu2"})],1),i("v-uni-view",{staticClass:"tis",class:t.willStop?"change":""},[t._v(t._s(t.recordTis))])],1)],1)},s=[]},"5af0":function(t,e,i){"use strict";i.r(e);var a=i("6500"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},6500:function(t,e,i){"use strict";(function(t){var a=i("4ea4");i("4160"),i("d81d"),i("e25e"),i("ac1f"),i("5319"),i("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("96cf");var n=a(i("1da1")),s=i("5827"),o={data:function(){return{user_id:this.$store.state.user.id,avatar:this.$store.state.user.avatar,nickname:this.$store.state.user.nickname,to_id:0,textMsg:"",scrollAnimation:!1,scrollTop:0,scrollToView:"",msgList:[],msgImgList:[],emptybottom:!1,isVoice:!1,voiceTis:"按住 说话",recordTis:"手指上滑 取消发送",recording:!1,willStop:!1,initPoint:{identifier:0,Y:0},recordTimer:null,recordLength:0,AUDIO:uni.createInnerAudioContext(),playMsgid:null,VoiceTimer:null,popupLayerClass:!1,hideMore:!0,TabCur:"默认",hideEmoji:!0,emojiList:this.emojiData(),QnUrl:""}},onLoad:function(t){var e=this;this.loadData(),this.AUDIO.onEnded((function(t){e.playMsgid=null})),uni.$on("onService",this.onChat)},onShow:function(){this.scrollTop=9999999},methods:{loadData:function(){var t=this;return(0,n.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:t.$api.post({url:"/wanlshop/chat/hello",data:{id:1,type:"service",form_id:t.user_id}});case 1:case"end":return e.stop()}}),e)})))()},sendMsg:function(t,e){var i=2;this.msgList.length&&(i=this.msgList[this.msgList.length-1].id,i++);var a={id:i,type:"service",to_id:this.to_id,form:{id:this.user_id,avatar:this.avatar,name:this.nickname},message:{type:e,content:t},createtime:parseInt((new Date).getTime()/1e3)};this.onChat(JSON.parse(JSON.stringify(a)),!0),this.$api.post({url:"/wanlshop/chat/service",data:a})},onChat:function(t,e){var i=this;e||(this.to_id=t.form.id,t.form.hasOwnProperty("name")&&this.$wanlshop.title(t.form.name)),"list"==t.message.type&&this.addListMsg(t),"article"==t.message.type&&this.addArticleMsg(t),"text"==t.message.type&&this.addTextMsg(t),"voice"==t.message.type&&this.addVoiceMsg(t),"img"==t.message.type&&this.addImgMsg(t),"end"==t.message.type&&this.$wanlshop.msg(t.message.content),this.$nextTick((function(){i.scrollToView="msg"+t.id}))},addListMsg:function(t){this.msgList.push(t)},addArticleMsg:function(t){this.msgList.push(t)},addTextMsg:function(t){t.message.content.text=this.replaceEmoji(t.message.content.text),this.msgList.push(t)},addVoiceMsg:function(t){this.msgList.push(t)},addImgMsg:function(t){t.message.content=this.setPicSize(t.message.content),this.msgImgList.push(t.message.content.url),this.msgList.push(t)},chooseImage:function(){this.getImage("album")},camera:function(){this.getImage("camera")},getImage:function(t){var e=this;this.hideDrawer(),uni.chooseImage({sourceType:[t],sizeType:["original","compressed"],success:function(t){e.$api.get({url:"/wanlshop/common/uploadData",success:function(i){for(var a=0;a<t.tempFilePaths.length;a++)uni.getImageInfo({src:t.tempFilePaths[a],success:function(t){e.$api.upload({url:i.uploadurl,filePath:t.path,name:"file",formData:"local"==i.storage?null:i.multipart,success:function(i){e.sendMsg({url:i.fullurl,w:t.width,h:t.height},"img")}})}})}})}})},sendText:function(){if(this.hideDrawer(),this.textMsg){var t={text:this.textMsg};this.sendMsg(t,"text"),this.textMsg=""}},aiSend:function(t){this.sendMsg({text:t},"text")},showPic:function(t){uni.previewImage({indicator:"none",current:t.content.url,urls:this.msgImgList})},playVoice:function(t){var e=this;this.playMsgid=t.id,this.AUDIO.src=t.content.url,this.$nextTick((function(){e.AUDIO.play()}))},voiceBegin:function(t){t.touches.length>1||(this.initPoint.Y=t.touches[0].clientY,this.initPoint.identifier=t.touches[0].identifier,this.RECORDER.start({format:"mp3"}))},recordBegin:function(t){var e=this;this.recording=!0,this.voiceTis="松开 结束",this.recordLength=0,this.recordTimer=setInterval((function(){e.recordLength++}),1e3)},voiceCancel:function(){this.recording=!1,this.voiceTis="按住 说话",this.recordTis="手指上滑 取消发送",this.willStop=!0,this.RECORDER.stop()},voiceIng:function(t){if(this.recording){var e=t.touches[0];this.initPoint.Y-e.clientY>=uni.upx2px(200)?(this.willStop=!0,this.recordTis="松开手指 取消发送"):(this.willStop=!1,this.recordTis="手指上滑 取消发送")}},voiceEnd:function(t){this.recording&&(this.recording=!1,this.voiceTis="按住 说话",this.recordTis="手指上滑 取消发送",this.RECORDER.stop())},recordEnd:function(e){var i=this;clearInterval(this.recordTimer),this.willStop?t.log("取消发送录音"):(this.$api.get({url:"/wanlshop/common/uploadData",success:function(t){i.$api.upload({url:t.uploadurl,filePath:e.tempFilePath,name:"file",formData:"local"==t.storage?null:t.multipart,success:function(t){var e={length:0,url:t.fullurl};e.length=i.recordLength%60,e.length>0&&i.sendMsg(e,"voice")}})}}),t.log("录音结束")),this.willStop=!1},switchVoice:function(){this.hideDrawer(),this.isVoice=!this.isVoice},emojiData:function(){var t={},e=[],i={};return s.forEach((function(a){var n=a.category.length>0?a.category:"默认";t[n]||(t[n]=[],e.push(n)),t[n].push(a),i[a.phrase]=a.icon})),{groups:t,categories:e,map:i}},replaceEmoji:function(t){var e=this,i=t.replace(/\[([^(\]|\[)]*)\]/g,(function(t,i){return'<img src="'+e.emojiList.map[t]+'" width="18rpx">'}));return i.replace(/(\r\n)|(\n)/g,"<br>")},tabSelect:function(t){this.TabCur=t.currentTarget.dataset.id},setPicSize:function(t){var e=uni.upx2px(350),i=uni.upx2px(350);if(t.w>e||t.h>i){var a=t.w/t.h;t.w=a>1?e:i*a,t.h=a>1?e/a:i}return t},showMore:function(){this.isVoice=!1,this.hideEmoji=!0,this.hideMore?(this.hideMore=!1,this.openDrawer()):this.hideDrawer()},openDrawer:function(){this.emptybottom=!0,this.popupLayerClass=!0},hideDrawer:function(){var t=this;this.emptybottom=!1,this.popupLayerClass=!1,setTimeout((function(){t.hideMore=!0,t.hideEmoji=!0}),150)},chooseEmoji:function(){this.hideMore=!0,this.hideEmoji?(this.hideEmoji=!1,this.openDrawer()):this.hideDrawer()},addEmoji:function(t){this.textMsg+=t},textareaFocus:function(){this.emptybottom=!0,this.popupLayerClass&&0==this.hideMore&&this.hideDrawer()},textareaBlur:function(){this.emptybottom=!1},discard:function(){}}};e.default=o}).call(this,i("5a52")["default"])},"8da1":function(t,e,i){var a=i("f68c");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("360e61da",a,!0,{sourceMap:!1,shadowMode:!1})},adf9:function(t,e,i){"use strict";i.r(e);var a=i("3da7"),n=i("5af0");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("ae4d");var o,c=i("f0c5"),r=Object(c["a"])(n["default"],a["b"],a["c"],!1,null,"5252a3b9",null,!1,a["a"],o);e["default"]=r.exports},ae4d:function(t,e,i){"use strict";var a=i("8da1"),n=i.n(a);n.a},f68c:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'.cu-chat .cu-item>.main[data-v-5252a3b9]{margin:0 %?20?%}.cu-chat .cu-item > .main .content[data-v-5252a3b9]:after{width:0;height:0}.cu-chat .cu-item > .main .content[data-v-5252a3b9]{font-size:%?30?%;-webkit-border-radius:%?10?% %?30?% %?30?% %?30?%;border-radius:%?10?% %?30?% %?30?% %?30?%}.cu-chat .cu-item.self > .main .content[data-v-5252a3b9]{-webkit-border-radius:%?30?% %?10?% %?30?% %?30?%;border-radius:%?30?% %?10?% %?30?% %?30?%}.cu-chat .cu-item > .main .content .article[data-v-5252a3b9]{margin-top:%?10?%;padding-top:%?10?%;width:100%;overflow:hidden}.cu-chat .cu-item > .main .content .list[data-v-5252a3b9]{width:100%;font-size:%?28?%}.cu-chat .cu-item > .main .content .list uni-text[data-v-5252a3b9]{color:#ff6a00}.cu-chat .cu-item > .main .content .list .ai[data-v-5252a3b9]{padding:%?16?% 0;margin:%?16?% 0;line-height:1.5}.cu-chat .cu-item [class*="wlIcon-"][data-v-5252a3b9]{font-size:%?34?%}.opmenu[data-v-5252a3b9]{display:-webkit-box;display:-webkit-flex;display:flex;margin-top:%?2?%;color:#4c4c4c}.opmenu .box[data-v-5252a3b9]{padding-top:%?35?%;padding-left:%?50?%;text-align:center}.opmenu .box .icon[data-v-5252a3b9]{height:%?130?%;width:%?130?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;justify-items:center;background-color:#fff;-webkit-border-radius:%?20?%;border-radius:%?20?%;font-size:%?70?%;margin-bottom:%?10?%}.hidden[data-v-5252a3b9]{display:none!important}.popup-layer[data-v-5252a3b9]{-webkit-transition:all .15s linear;transition:all .15s linear;width:100%;height:%?480?%;background-color:#f7f7fa;position:fixed;z-index:2000;top:100%}.popup-layer.showLayer[data-v-5252a3b9]{-webkit-transform:translate3d(0,%?-480?%,0);transform:translate3d(0,%?-480?%,0)}.popup-layer .emoji .emojinav[data-v-5252a3b9]{background-color:#f8f8f8}.popup-layer .emoji .emojinav .item[data-v-5252a3b9]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?100?%;padding-left:%?10?%}.popup-layer .emoji .emojinav .item .emojibg[data-v-5252a3b9]{background-color:#dedede}.popup-layer .emoji .emojinav .item > uni-view[data-v-5252a3b9]{margin:0 %?25?%;width:%?60?%;height:%?60?%;-webkit-border-radius:%?18?%;border-radius:%?18?%;background-repeat:no-repeat;background-size:80%;background-position:50%}.popup-layer .emoji .subject[data-v-5252a3b9]{height:%?380?%;background-color:#f1f1f1}.popup-layer .emoji .subject .item[data-v-5252a3b9]{padding:%?25?%}.popup-layer .emoji .subject .item > uni-view[data-v-5252a3b9]{background-repeat:no-repeat;background-size:56%;background-position:50%;width:12.5%;height:%?100?%}.input-box[data-v-5252a3b9]{width:100%;min-height:%?100?%;padding-bottom:env(safe-area-inset-bottom);background-color:#f7f7fa;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end;position:fixed;z-index:2000;bottom:%?-2?%;-webkit-transition:all .15s linear;transition:all .15s linear}.input-box [class*="wlIcon-"][data-v-5252a3b9]{font-size:%?50?%;color:#4c4c4c}.input-box .wlIcon-zhifeiji[data-v-5252a3b9]{color:#fe6600}.input-box.showLayer[data-v-5252a3b9]{-webkit-transform:translate3d(0,%?-480?%,0);transform:translate3d(0,%?-480?%,0)}.input-box .voice[data-v-5252a3b9],\r\n.input-box .more[data-v-5252a3b9]{-webkit-flex-shrink:0;flex-shrink:0;width:%?90?%;height:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.input-box .send[data-v-5252a3b9]{-webkit-flex-shrink:0;flex-shrink:0;width:%?90?%;height:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.input-box .send .btn[data-v-5252a3b9]{width:%?110?%;height:%?70?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-border-radius:%?16?%;border-radius:%?16?%;font-size:%?32?%}.input-box .textbox[data-v-5252a3b9]{width:100%}.input-box .textbox .voice-mode[data-v-5252a3b9]{width:calc(100% - %?2?%);height:%?80?%;margin:%?10?% 0;-webkit-border-radius:%?16?%;border-radius:%?16?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?28?%;background-color:#fff;color:#555}.input-box .textbox .voice-mode.recording[data-v-5252a3b9]{background-color:#e5e5e5}.input-box .textbox .text-mode[data-v-5252a3b9]{width:100%;min-height:%?80?%;margin:%?10?% 0;display:-webkit-box;display:-webkit-flex;display:flex;background-color:#fff;-webkit-border-radius:%?16?%;border-radius:%?16?%}.input-box .textbox .text-mode .box[data-v-5252a3b9]{width:100%;padding-left:%?30?%;min-height:%?80?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.input-box .textbox .text-mode .box uni-textarea[data-v-5252a3b9]{width:100%}.input-box .textbox .text-mode .em[data-v-5252a3b9]{-webkit-flex-shrink:0;flex-shrink:0;width:%?80?%;padding-left:%?10?%;height:%?80?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.record[data-v-5252a3b9]{width:39vw;height:39vw;position:fixed;top:35%;left:30%;background-color:rgba(0,0,0,.8);-webkit-border-radius:%?40?%;border-radius:%?40?%}.record .ing[data-v-5252a3b9]{width:100%;height:30vw;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}@-webkit-keyframes volatility-data-v-5252a3b9{0%{background-position:0 130%}20%{background-position:0 150%}30%{background-position:0 155%}40%{background-position:0 160%}50%{background-position:0 145%}70%{background-position:0 150%}80%{background-position:0 170%}90%{background-position:0 160%}100%{background-position:0 135%}}@keyframes volatility-data-v-5252a3b9{0%{background-position:0 130%}20%{background-position:0 150%}30%{background-position:0 155%}40%{background-position:0 160%}50%{background-position:0 145%}70%{background-position:0 150%}80%{background-position:0 170%}90%{background-position:0 160%}100%{background-position:0 135%}}.record .ing [class*="wlIcon"][data-v-5252a3b9]{background-image:-webkit-gradient(linear,left top,left bottom,from(#fff),color-stop(50%,#565656));background-image:-webkit-linear-gradient(top,#fff,#565656 50%);background-image:linear-gradient(180deg,#fff,#565656 50%);background-size:100% 200%;-webkit-animation:volatility-data-v-5252a3b9 1.5s ease-in-out -1.5s infinite alternate;animation:volatility-data-v-5252a3b9 1.5s ease-in-out -1.5s infinite alternate;-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-size:%?140?%;padding-top:%?40?%;color:#f09b37}.record .cancel[data-v-5252a3b9]{width:100%;height:30vw;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.record .cancel [class*="wlIcon"][data-v-5252a3b9]{color:#fff;font-size:%?150?%}.record .tis[data-v-5252a3b9]{width:100%;height:10vw;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:%?24?%;color:#fff}.record .tis.change[data-v-5252a3b9]{color:#f09b37}.content[data-v-5252a3b9]{width:100%}.content .msg-list[data-v-5252a3b9],\r\n.cu-chat[data-v-5252a3b9]{position:absolute;top:0;bottom:%?100?%;bottom:calc(env(safe-area-inset-bottom) + %?100?%)}.loading[data-v-5252a3b9]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}@-webkit-keyframes stretchdelay-data-v-5252a3b9{0%,\r\n\t40%,\r\n\t100%{-webkit-transform:scaleY(.6);transform:scaleY(.6)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes stretchdelay-data-v-5252a3b9{0%,\r\n\t40%,\r\n\t100%{-webkit-transform:scaleY(.6);transform:scaleY(.6)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}.loading .spinner[data-v-5252a3b9]{margin:%?20?% 0;width:%?60?%;height:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.loading .spinner uni-view[data-v-5252a3b9]{background-color:#dadada;height:%?50?%;width:%?6?%;-webkit-border-radius:%?6?%;border-radius:%?6?%;-webkit-animation:stretchdelay-data-v-5252a3b9 1.2s infinite ease-in-out;animation:stretchdelay-data-v-5252a3b9 1.2s infinite ease-in-out}.loading .spinner .rect2[data-v-5252a3b9]{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}.loading .spinner .rect3[data-v-5252a3b9]{-webkit-animation-delay:-1s;animation-delay:-1s}.loading .spinner .rect4[data-v-5252a3b9]{-webkit-animation-delay:-.9s;animation-delay:-.9s}.loading .spinner .rect5[data-v-5252a3b9]{-webkit-animation-delay:-.8s;animation-delay:-.8s}.emptybottom[data-v-5252a3b9]{padding-bottom:0!important}',""]),t.exports=e}}]);