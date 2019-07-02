$.fn.dataTable({
    defaults: {
        serverSide: true,
        processing: true,
        responsive: true,
        pagingType: 'full_numbers',
    }
});

$.fn.dataTable.defaults.lengthMenu = [
    [10, 25, 50, -1],
    [10, 25, 50, "All"]
];
$.fn.dataTable.defaults.oLanguage = {
    "sProcessing": "查询中...",
    "sLengthMenu": "每页显示 _MENU_ 条记录",
    "sZeroRecords": "抱歉， 没有找到",
    "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
    "sInfoEmpty": "",
    "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
    "sInfoPostFix": "",
    "sSearch": "快速筛选：",
    "sUrl": "",
    "sEmptyTable": "表中数据为空",
    "sLoadingRecords": "载入中...",
    "sInfoThousands": ",",
    "oPaginate": {
        "sFirst": "首页",
        "sPrevious": "前一页",
        "sNext": "后一页",
        "sLast": "末页"
    },
    "oAria": {
        "sSortAscending": ": 以升序排列此列",
        "sSortDescending": ": 以降序排列此列"
    }
};
