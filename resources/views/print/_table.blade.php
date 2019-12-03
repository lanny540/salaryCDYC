<style>
    .printTable-total > tbody > tr > td {
        border: 0 none;
    }

    .printTable-total > tbody > tr > td:nth-child(odd) {
        text-align: right;
    }

    .printTable-total > tbody > tr > td:nth-child(even) {
        border-bottom: 1px solid #DDDDDD;
        text-align: left;
        width: 15%;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <address>
            <strong>{{ Auth::user()->profile->userName }}</strong><br>
            <abbr title="部门">{{ Auth::user()->profile->department->name }}</abbr>
        </address>
    </div>
    <div class="col-sm-6 text-right">
        <address>
            <strong>保险编号</strong><br>
            <abbr title="保险编号" class="text-navy">{{ Auth::user()->profile->policyNumber }}</abbr>
        </address>
    </div>
</div>

<div id="printTable"></div>
