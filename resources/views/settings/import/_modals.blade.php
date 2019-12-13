{{--Modal--}}
<div class="modal inmodal fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">编辑数据</h4>
            </div>
            <div class="modal-body">
                <form id="import">
                    <div class="form-group">
                        <label for="hunman_column" class="control-label">系统字段:</label>
                        <input id="hunman_column" class="form-control" type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label for="excel_column" class="control-label">读取字段:</label>
                        <input id="excel_column" class="form-control" type="text">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save" class="btn btn-primary" value="update">提交</button>
                <input type="hidden" id="id" name="id" value="-1">
            </div>
        </div>
    </div>
</div>
