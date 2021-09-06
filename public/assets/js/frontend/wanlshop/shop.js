"use strict";
define(["jquery", "bootstrap", "backend", "table", "form", "vue"],
    function(e, t, a, i, r, l) {
        var o = {
            index: function() {
                i.api.init({
                    extend: {
                        index_url: "wanlshop/page/index" + location.search,
                        add_url: "",
                        edit_url: "wanlshop/page/edit",
                        del_url: "wanlshop/page/del",
                        multi_url: "",
                        table: "wanlshop_page"
                    }
                }),
                    Fast.config.openArea = ["90%", "90%"];
                var t = e("#table");
                t.bootstrapTable({
                    url: e.fn.bootstrapTable.defaults.extend.index_url,
                    pk: "id",
                    sortName: "id",
                    columns: [[{
                        checkbox: !0
                    },
                        {
                            field: "id",
                            title: __("Id")
                        },
                        {
                            field: "page_token",
                            title: __("Token")
                        },
                        {
                            field: "name",
                            title: __("Name")
                        },
                        {
                            field: "type",
                            title: __("Type"),
                            searchList: {
                                page: __("Page"),
                                shop: __("Shop"),
                                index: __("Index")
                            },
                            formatter: i.api.formatter.normal
                        },
                        {
                            field: "createtime",
                            title: __("Createtime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: i.api.formatter.datetime
                        },
                        {
                            field: "updatetime",
                            title: __("Updatetime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: i.api.formatter.datetime
                        },
                        {
                            field: "status",
                            title: __("Status"),
                            searchList: {
                                normal: __("Normal"),
                                hidden: __("Hidden")
                            },
                            formatter: i.api.formatter.status
                        },
                        {
                            field: "operate",
                            title: __("Operate"),
                            table: t,
                            events: i.api.events.operate,
                            formatter: i.api.formatter.operate
                        }]]
                }),
                    i.api.bindevent(t),
                    e(document).on("click", ".btn-addnew",
                        function() {
                            a.api.open("wanlshop/page/add/", __("新建页面"), {
                                area: ["800px", "400px"]
                            })
                        })
            },
            category: function() {
                i.api.init({
                    extend: {
                        index_url: "wanlshop/shopsort/index" + location.search,
                        add_url: "wanlshop/shopsort/add",
                        edit_url: "wanlshop/shopsort/edit",
                        del_url: "wanlshop/shopsort/del",
                        multi_url: "wanlshop/shopsort/multi",
                        dragsort_url: "",
                        table: "wanlshop_shop_sort"
                    }
                });
                var t = e("#table");
                t.bootstrapTable({
                    url: e.fn.bootstrapTable.defaults.extend.index_url,
                    pk: "id",
                    sortName: "weigh",
                    pagination: !1,
                    columns: [[{
                        checkbox: !0
                    },
                        {
                            field: "id",
                            title: __("Id")
                        },
                        {
                            field: "name",
                            title: __("Name"),
                            align: "left",
                            formatter: o.api.formatter.escape2Html
                        },
                        {
                            field: "image",
                            title: __("Image"),
                            events: i.api.events.image,
                            formatter: i.api.formatter.image
                        },
                        {
                            field: "createtime",
                            title: __("Createtime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: i.api.formatter.datetime
                        },
                        {
                            field: "updatetime",
                            title: __("Updatetime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: i.api.formatter.datetime
                        },
                        {
                            field: "status",
                            title: __("Status"),
                            searchList: {
                                normal: __("Normal"),
                                hidden: __("Hidden")
                            },
                            formatter: i.api.formatter.status
                        },
                        {
                            field: "id",
                            title: __("展开"),
                            operate: !1,
                            formatter: o.api.formatter.subnode
                        },
                        {
                            field: "operate",
                            title: __("Operate"),
                            table: t,
                            events: i.api.events.operate,
                            formatter: i.api.formatter.operate
                        }]],
                    search: !1,
                    commonSearch: !1
                }),
                    t.on("post-body.bs.table",
                        function(t, a, i, r) {
                            e(".btn-node-sub.disabled[data-pid!=0]").closest("tr").hide(),
                                e(".btn-node-sub").off("click").on("click",
                                    function(t) {
                                        var a = !!(e(this).data("shown") || e("a.btn[data-pid='" + e(this).data("id") + "']:visible").size() > 0);
                                        return e("a.btn[data-pid='" + e(this).data("id") + "']").each(function() {
                                            e(this).closest("tr").toggle(!a),
                                            e(this).hasClass("disabled") || e(this).trigger("click")
                                        }),
                                            e(this).data("shown", !a),
                                            !1
                                    })
                        }),
                    e(document.body).on("click", ".btn-toggle",
                        function(t) {
                            e("a.btn[data-id][data-pid][data-pid!=0].disabled").closest("tr").hide();
                            var a = this,
                                i = e("i", a).hasClass("fa-chevron-down");
                            e("i", a).toggleClass("fa-chevron-down", !i),
                                e("i", a).toggleClass("fa-chevron-up", i),
                                e("a.btn[data-id][data-pid][data-pid!=0]").not(".disabled").closest("tr").toggle(i),
                                e(".btn-node-sub[data-pid=0]").data("shown", i)
                        }),
                    e(document.body).on("click", ".btn-toggle-all",
                        function(t) {
                            var a = this,
                                i = e("i", a).hasClass("fa-plus");
                            e("i", a).toggleClass("fa-plus", !i),
                                e("i", a).toggleClass("fa-minus", i),
                                e(".btn-node-sub.disabled[data-pid!=0]").closest("tr").toggle(i),
                                e(".btn-node-sub[data-pid!=0]").data("shown", i)
                        }),
                    i.api.bindevent(t)
            },
            profile: function() {
                e("#plupload-avatar").data("upload-success",
                    function(t) {
                        var i = a.api.cdnurl(t.url);
                        e(".profile-user-img").prop("src", i)
                    }),
                    o.api.bindevent()
            },
            brand: function() {
                i.api.init({
                    extend: {
                        index_url: "wanlshop/brand/index" + location.search,
                        add_url: "wanlshop/brand/add",
                        edit_url: "wanlshop/brand/edit",
                        del_url: "wanlshop/brand/del",
                        multi_url: "wanlshop/brand/multi",
                        dragsort_url: "",
                        table: "wanlshop_brand"
                    }
                });
                var t = e("#table");
                t.bootstrapTable({
                    url: e.fn.bootstrapTable.defaults.extend.index_url,
                    pk: "id",
                    sortName: "weigh",
                    columns: [[{
                        checkbox: !0
                    },
                        {
                            field: "id",
                            title: __("Id")
                        },
                        {
                            field: "name",
                            title: __("品牌名称"),
                            formatter: i.api.formatter.search
                        },
                        {
                            field: "image",
                            title: __("Image"),
                            events: i.api.events.image,
                            formatter: i.api.formatter.image
                        },
                        {
                            field: "category.name",
                            title: __("Category.name"),
                            formatter: i.api.formatter.search
                        },
                        {
                            field: "createtime",
                            title: __("Createtime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: i.api.formatter.datetime
                        },
                        {
                            field: "updatetime",
                            title: __("Updatetime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: i.api.formatter.datetime
                        },
                        {
                            field: "state",
                            title: __("State"),
                            searchList: {
                                0 : __("State 0"),
                                1 : __("State 1")
                            },
                            formatter: i.api.formatter.status
                        },
                        {
                            field: "operate",
                            title: __("Operate"),
                            table: t,
                            events: i.api.events.operate,
                            formatter: i.api.formatter.operate
                        }]]
                }),
                    i.api.bindevent(t)
            },
            attachment: function() {
                i.api.init({
                    extend: {
                        index_url: "wanlshop/attachment/index",
                        add_url: "wanlshop/attachment/add",
                        edit_url: "",
                        del_url: "wanlshop/attachment/del",
                        multi_url: "",
                        table: "attachment"
                    }
                });
                var t = e("#table");
                t.bootstrapTable({
                    url: e.fn.bootstrapTable.defaults.extend.index_url,
                    sortName: "id",
                    columns: [[{
                        field: "state",
                        checkbox: !0
                    },
                        {
                            field: "id",
                            title: __("Id")
                        },
                        {
                            field: "user_id",
                            title: __("User_id"),
                            visible: !1,
                            addClass: "selectpage",
                            extend: "data-source='user/user/index' data-field='nickname'"
                        },
                        {
                            field: "url",
                            title: __("Preview"),
                            formatter: o.api.formatter.thumb,
                            operate: !1
                        },
                        {
                            field: "url",
                            title: __("Url"),
                            formatter: o.api.formatter.url
                        },
                        {
                            field: "imagewidth",
                            title: __("Imagewidth"),
                            sortable: !0
                        },
                        {
                            field: "imageheight",
                            title: __("Imageheight"),
                            sortable: !0
                        },
                        {
                            field: "imagetype",
                            title: __("Imagetype"),
                            formatter: i.api.formatter.search
                        },
                        {
                            field: "storage",
                            title: __("Storage"),
                            formatter: i.api.formatter.search
                        },
                        {
                            field: "filesize",
                            title: __("Filesize"),
                            operate: "BETWEEN",
                            sortable: !0,
                            formatter: function(e, t, a) {
                                var i = parseFloat(e),
                                    r = Math.floor(Math.log(i) / Math.log(1024));
                                return 1 * (i / Math.pow(1024, r)).toFixed(r < 2 ? 0 : 2) + " " + ["B", "KB", "MB", "GB", "TB"][r]
                            }
                        },
                        {
                            field: "mimetype",
                            title: __("Mimetype"),
                            formatter: i.api.formatter.search
                        },
                        {
                            field: "createtime",
                            title: __("Createtime"),
                            formatter: i.api.formatter.datetime,
                            operate: "RANGE",
                            addclass: "datetimerange",
                            sortable: !0
                        },
                        {
                            field: "operate",
                            title: __("Operate"),
                            table: t,
                            events: i.api.events.operate,
                            formatter: i.api.formatter.operate
                        }]]
                }),
                    i.api.bindevent(t),
                    require(["upload"],
                        function(t) {
                            t.api.plupload(e("#toolbar .plupload"),
                                function() {
                                    e(".btn-refresh").trigger("click")
                                })
                        })
            },

            teams: function() {
                i.api.init({
                    extend: {
                        index_url: "wanlshop/teams/index",
                        add_url: "wanlshop/teams/add",
                        edit_url: "",
                        del_url: "wanlshop/teams/del",
                        multi_url: "",
                        table: "teams"
                    }
                });
                var t = e("#table");
                t.bootstrapTable({
                    url: e.fn.bootstrapTable.defaults.extend.index_url,
                    sortName: "id",
                    cardView: false,
                    pagination: true,
                    pageSize: 3,                     //每页的记录行数（*）
                    pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
                    showExport: false,
                    showColumns:false,
                    commonSearch:false,
                    tableexport:false,
                          clickToSelect: false,                //是否启用点击选中行
                     detailView: false,                  //是否显示父子表

                    sortable: false,                     //是否启用排序
                    showToggle:false,
                    search: false,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大

                    columns: [[

{
                            field: 'operation',
                            align: 'left',
                            formatter: function (value, row, index) {

                                  return "&nbsp;"+row.nickname+"在批发中心批发商品"+row.title+"消費"+row.summoney+"$，獲得傭金&nbsp;&nbsp;&nbsp;";
                            }, events: ''
                        },


                        {
                            field: "commission",
                            align: 'right',
                            formatter: function (value, row, index) {

                                return "<font color='red'>+"+ row.commission+"</font>&nbsp;&nbsp;&nbsp;";
                            }, events: ''

                        }




                        ]]
                }),


                    i.api.bindevent(t),
                    require(["upload"],
                        function(t) {
                            t.api.plupload(e("#toolbar .plupload"),
                                function() {
                                    e(".btn-refresh").trigger("click")
                                })
                        })
            },


            teamsdd: function() {
                i.api.init({
                    extend: {
                        index_url: "wanlshop/teams/index",
                    }
                });
                var t = e("#table");
              t.bootstrapTable({
                    data: [
                        {
                            "id": 1,
                            "name": "苹果",
                            "card": "30.05"
                        },
                        {
                            "id": 2,
                            "name": "橘子",
                            "card": "18"
                        },
                        {
                            "id": 3,
                            "name": "香蕉",
                            "card": "10.5"
                        },
                        {
                            "id": 4,
                            "name": "栗子",
                            "card": "12.05"
                        },
                        {
                            "id": 5,
                            "name": "田七",
                            "card": "5.00"
                        }
                    ],
                    reorderableRows: true,
                    clickToSelect: true,//点击行选中
                    striped: true, // 是否显示行间隔色
                    uniqueId: "id",
                    search: false,
                    showRefresh: false,
                    columns: [
                        {
                            checkbox: true,
                            halign: 'center',
                            align: 'center',
                            width:  20,
                            footerFormatter: function () {
                                return '合计';
                            }
                        },
                        {
                            field: 'xh',
                            title: "序号",
                            halign :"center",
                            align:  "center",
                            width:  40,
                            formatter: function (value, row, index) {
                                return index+1;
                            }
                        },
                        {
                            field: 'name',
                            title: '商品',
                            width:  260,
                        },
                        {
                            field: 'card',
                            title: '价格',
                            halign :"center",
                            align:  "center",
                            width:  80,
                            formatter: function(value, row, index){
                                //增加的合计行不能并入总和计算范围内
                                if(value.indexOf("span") == -1){
                                    priceSum = floatTool.add(priceSum,value);
                                }
                                return value;
                            }
                        }
                    ]
                })


            },


            api: {
                formatter: {
                    thumb: function(e, t, a) {
                        if (t.mimetype.indexOf("image") > -1) {
                            var i = "upyun" == t.storage ? "!/fwfh/120x90": "";
                            return '<a href="' + t.fullurl + '" target="_blank"><img src="' + t.fullurl + i + '" alt="" style="max-height:90px;max-width:120px"></a>'
                        }
                        return '<a href="' + t.fullurl + '" target="_blank"><img src="https://tool.fastadmin.net/icon/' + t.imagetype + '.png" alt=""></a>'
                    },
                    url: function(e, t, a) {
                        return '<a href="' + t.fullurl + '" target="_blank" class="label bg-green">' + e + "</a>"
                    },
                    subnode: function(e, t, a) {
                        return '<a href="javascript:;" data-toggle="tooltip" title="' + __("Toggle sub menu") + '" data-id="' + t.id + '" data-pid="' + t.pid + '" class="btn btn-xs ' + (1 == t.haschild || 1 == t.ismenu ? "btn-success": "btn-default disabled") + ' btn-node-sub"><i class="fa fa-sitemap"></i></a>'
                    },
                    escape2Html: function(e, t, a) {
                        return e.toString().replace(/(&|&amp;)nbsp;/g, "")
                    }
                },
                bindevent: function() {
                    r.api.bindevent(e("form[role=form]"))
                }
            }
        };
        return o
    });