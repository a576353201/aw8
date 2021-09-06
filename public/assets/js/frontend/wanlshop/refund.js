"use strict";
define(["jquery", "bootstrap", "backend", "table", "form"],
    function(e, t, a, r, n) {
        var i = {
            index: function() {
                r.api.init({
                    extend: {
                        index_url: "wanlshop/refund/index" + location.search,
                        add_url: "",
                        edit_url: "",
                        del_url: "",
                        multi_url: "",
                        table: "wanlshop_refund"
                    }
                });
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
                            field: "goods_ids",
                            title: __("Goods_ids"),
                            align: "left",
                            formatter: i.api.formatter.goods
                        },
                        {
                            field: "expressType",
                            title: __("Expresstype"),
                            searchList: {
                                0 : __("Expresstype 0"),
                                1 : __("Expresstype 1")
                            },
                            formatter: r.api.formatter.normal
                        },
                        {
                            field: "price",
                            title: __("Price"),
                            operate: "BETWEEN"
                        },
                        {
                            field: "type",
                            title: __("Type"),
                            searchList: {
                                0 : __("Type 0"),
                                1 : __("Type 1")
                            },
                            formatter: r.api.formatter.normal
                        },
                        {
                            field: "reason",
                            title: __("Reason"),
                            searchList: {
                                0 : __("Reason 0"),
                                1 : __("Reason 1"),
                                2 : __("Reason 2"),
                                3 : __("Reason 3"),
                                4 : __("Reason 4"),
                                5 : __("Reason 5"),
                                6 : __("Reason 6")
                            },
                            formatter: r.api.formatter.normal
                        },
                        {
                            field: "images",
                            title: __("Images"),
                            events: r.api.events.image,
                            formatter: r.api.formatter.images
                        },
                        {
                            field: "createtime",
                            title: __("Createtime"),
                            operate: "RANGE",
                            addclass: "datetimerange",
                            formatter: r.api.formatter.datetime
                        },
                        {
                            field: "state",
                            title: __("State"),
                            searchList: {
                                0 : __("State 0"),
                                1 : __("State 1"),
                                2 : __("State 2"),
                                3 : __("State 3"),
                                4 : __("State 4"),
                                5 : __("State 5"),
                                6 : __("State 6")
                            },
                            align: "left",
                            formatter: r.api.formatter.status
                        },
                        {
                            field: "operate",
                            title: __("Operate"),
                            table: t,
                            events: r.api.events.operate,
                            buttons: [{
                                name: "detail",
                                title: __("查看退款"),
                                classname: "btn btn-xs btn-info btn-dialog",
                                icon: "fa fa-eye",
                                text: "查看退款",
                                url: "wanlshop/refund/detail"
                            },
                                {
                                    name: "agreeGoods",
                                    title: __("同意退货"),
                                    classname: "btn btn-xs btn-success btn-magic btn-ajax",
                                    icon: "fa fa-check",
                                    text: "同意退货",
                                    confirm: "确认同意买家退款退货？",
                                    url: "wanlshop/refund/agree",
                                    visible: function(e) {
                                        if (0 == e.state && 1 == e.type) return ! 0
                                    },
                                    success: function(e, a) {
                                        return t.bootstrapTable("refresh"),
                                            !1
                                    },
                                    error: function(e, t) {
                                        return console.log(e, t),
                                            Layer.alert(t.msg),
                                            !1
                                    }
                                },
                                {
                                    name: "agree",
                                    title: __("同意退款"),
                                    classname: "btn btn-xs btn-success btn-magic btn-ajax",
                                    icon: "fa fa-check",
                                    text: "同意退款",
                                    confirm: "确认同意买家退款，款項会直接轉到用戶余额？",
                                    url: "wanlshop/refund/agree",
                                    visible: function(e) {
                                        if (0 == e.state && 0 == e.type) return ! 0
                                    },
                                    success: function(e, a) {
                                        return t.bootstrapTable("refresh"),
                                            !1
                                    },
                                    error: function(e, t) {
                                        return console.log(e, t),
                                            Layer.alert(t.msg),
                                            !1
                                    }
                                },
                                {
                                    name: "receiving",
                                    title: __("确定收到买家退货"),
                                    classname: "btn btn-xs btn-success btn-magic btn-ajax",
                                    icon: "fa fa-check",
                                    text: "确认收货",
                                    confirm: "确定收到买家退货？确认后此退货订单自动完成退款！",
                                    url: "wanlshop/refund/receiving",
                                    visible: function(e) {
                                        if (6 == e.state) return ! 0
                                    },
                                    success: function(e, a) {
                                        return t.bootstrapTable("refresh"),
                                            !1
                                    },
                                    error: function(e, t) {
                                        return console.log(e, t),
                                            Layer.alert(t.msg),
                                            !1
                                    }
                                },
                                {
                                    name: "refuse",
                                    title: __("拒絕退款"),
                                    classname: "btn btn-xs btn-danger btn-dialog",
                                    icon: "fa fa-times",
                                    text: "拒絕退款",
                                    url: "wanlshop/refund/refuse",
                                    visible: function(e) {
                                        if (0 == e.state) return ! 0
                                    },
                                    extend: 'data-area=["500px","270px"]'
                                }],
                            formatter: r.api.formatter.operate
                        }]]
                }),
                    r.api.bindevent(t)
            },
            detail: function() {},
            refuse: function() {
                i.api.bindevent()
            },
            api: {
                bindevent: function() {
                    n.api.bindevent(e("form[role=form]"))
                },
                formatter: {
                    goods: function(e, t, a) {
                        return '<a href="javascript:" style="margin-right: 6px;"><img class="img-sm img-center" src="' + Fast.api.cdnurl(t.goods.image) + '"></a>' + t.goods.title
                    }
                }
            }
        };
        return i
    });