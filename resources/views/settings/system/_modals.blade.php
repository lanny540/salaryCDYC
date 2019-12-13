{{--Modal--}}
<div class="modal inmodal fade" id="systemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">编辑数据</h4>
            </div>
            <div class="modal-body">
                <form id="system">
                    <div class="form-group">
                        <label for="description" class="control-label">Key:</label>
                        <input id="description" class="form-control" type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label for="config_value" class="control-label">Value:</label>
                        <input id="config_value" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label">Type:<small>（请不要随意修改!）</small></label>
                        <input id="type" class="form-control" type="text">
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

