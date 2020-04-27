{{--Modal--}}
<div class="modal inmodal fade" id="tempVoucherSubjectModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 15px;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal_title">编辑数据</h4>
            </div>
            <div class="modal-body">
                <form id="tempVoucherSubject">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="seg0" class="control-label">公司:</label>
                                <select id="seg0" class="select2_segment form-control">
                                    @foreach($subjects['segment0'] as $s0)
                                        <option value="{{ $s0->subject_no }}">{{ $s0->subject_no }} — {{ $s0->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seg1" class="control-label">责任中心段:</label>
                                <select id="seg1" class="select2_segment form-control">
                                    @foreach($subjects['segment1'] as $s1)
                                        <option value="{{ $s1->subject_no }}">{{ $s1->subject_no }} — {{ $s1->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="seg2" class="control-label">科目段:</label>
                                <select id="seg2" class="select2_segment form-control">
                                    @foreach($subjects['segment2'] as $s2)
                                        <option value="{{ $s2->subject_no }}">{{ $s2->subject_no }} — {{ $s2->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seg3" class="control-label">子母段:</label>
                                <select id="seg3" class="form-control">
                                    @foreach($subjects['segment3'] as $s3)
                                        <option value="{{ $s3->subject_no }}">{{ $s3->subject_no }} — {{ $s3->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seg4" class="control-label">产品段:</label>
                                <select id="seg4" class="form-control">
                                    @foreach($subjects['segment4'] as $s4)
                                        <option value="{{ $s4->subject_no }}">{{ $s4->subject_no }} — {{ $s4->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seg5" class="control-label">参考段:</label>
                                <select id="seg5" class="form-control">
                                    @foreach($subjects['segment5'] as $s5)
                                        <option value="{{ $s5->subject_no }}">{{ $s5->subject_no }} — {{ $s5->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="debit" class="control-label">借方金额:</label>
                                <input id="debit" value="0" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="credit" class="control-label">贷方金额:</label>
                                <input id="credit" value="0" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seg_des" class="control-label">会计科目描述:</label>
                        <input id="seg_des" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="detail_des" class="control-label">凭证单项描述:</label>
                        <input id="detail_des" class="form-control" type="text">
                    </div>
                </form>
                <div>
                    <ul id="error_messages"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save" class="btn btn-primary" value="update">提交</button>
                <input type="hidden" id="id" name="id" value="-1">
                <input type="hidden" id="type" value="temp">
                <input type="hidden" id="hiddenId" value="0">
            </div>
        </div>
    </div>
</div>
