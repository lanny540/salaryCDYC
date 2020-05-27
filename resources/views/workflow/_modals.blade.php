{{--Modal--}}
<div class="modal inmodal fade" id="workflowModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px;">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="wf_name"></h4>
            </div>
            <div class="modal-body" style="overflow: scroll; max-height: 500px;">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>保险编号</th>
                        <th>部门</th>
                        <th>金额</th>
                        <th>卡号</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody id="detail">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
