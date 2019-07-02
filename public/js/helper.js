// 文件扩展名
function getFileExtension(fileName) {
    var pos = fileName.lastIndexOf(".");
    var fileExtension = fileName.substring(pos, fileName.length);

    return fileExtension;
}

// 获取二级分类信息
function getLevel2(obj) {
    // 如果有二级分类
    const ids = ['10', '11', '12', '13', '14', '15', '16', '20', '21', '22'];
    if (R.contains(obj.value, ids)) {
        $.get({
            url: 'getCatesName/' + obj.value,
            success: function (data) {
                // console.log(data);
                document.getElementById('level2html').innerHTML = level2html(data);
            }
        });
    } else {
        document.getElementById('level2html').innerHTML = '';
    }
}

// 动态生成二级分类html
function level2html(data) {
    let html = '';
    html += '<label for="level2Name">二级分类 *</label>';
    html += '<select name="level2Name" class="form-control" id="level2Name">';
    data.forEach(e => {
        html += '<option value="' + e.id + '">' + e.name + '</option>';
    });
    html += '</select>';

    return html;
}

// excel文件上传
function importf(obj) {
    excel = [];
    if(!obj.files) {
        return;
    }

    let suffix = obj.files[0].name.split(".")[1];
    if(suffix !== 'xls' && suffix !== 'xlsx'){
        alert('导入的文件格式不正确!');
        return;
    }
    // const IMPORTFILE_MAXSIZE = 1*1024;//这里可以自定义控制导入文件大小
    // if(obj.files[0].size/1024 > IMPORTFILE_MAXSIZE){
    //     alert('导入的表格文件不能大于1M')
    //     return
    // }

    let f = obj.files[0];
    let reader = new FileReader();
    reader.onload = function(e) {
        let data = e.target.result;
        wb = XLSX.read(data, {
            type: 'binary'
        });
        //wb.SheetNames[0]是获取Sheets中第一个Sheet的名字
        //wb.Sheets[Sheet名]获取第一个Sheet的数据

        let xlsData = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]);
        excel = filterDate(xlsData, filters);
        // console.log(excel);
    };
    reader.readAsBinaryString(f);
}

// 根据列名筛选数据
function filterDate(arr1, temp) {
    const commonArray = ['姓名', '保险编号', 'dwdm', '部门', '银行卡号', '备注'];
    let filter = commonArray.concat(temp);
    let data = [];
    for (let x of arr1) {
        x = R.pick(filter, x);
        data = R.append(x)(data);
    }
    return data;
}

// excel上传数据与数据库信息校验
function excelDataCheck(arr1, arr2) {
    const cmp1 = (x,y) => x.姓名 == y.userName && x.保险编号 == y.policyNumber && (x.银行卡号 == y.wageCard || x.银行卡号 == y.bonusCard);
    const cmp2 = (x,y) => x.姓名 == y.userName && x.保险编号 == y.policyNumber;

    let falseList = [];
    let trueList = [];

    let res1 = R.differenceWith(cmp1, arr1, arr2);

    res1.forEach(e => {
        e = R.assoc('status', false, e);
        e = R.assoc('message', '校验失败', e);
        falseList = R.append(e)(falseList);
    });

    let res3 = R.differenceWith(cmp2, arr1, res1);

    res3.forEach(e => {
        e = R.assoc('status', true, e);
        e = R.assoc('message', '校验成功', e);
        trueList = R.append(e)(trueList);
    });
    // console.log(res1);
    // console.log(res3);
    return R.concat(falseList, trueList);
}

// 动态生成数据验证结果html
function excelData(data) {
    let html = '';

    data.forEach(e => {
        if (e.status === true) {
            html += '<tr class="table-success">';

        } else {
            html += '<tr class="table-danger">';
        }
        html += '<td>' + e.姓名 + '</td>';
        html += '<td>' + e.保险编号 + '</td>';
        html += '<td>' + e.银行卡号 + '</td>';
        html += '<td>' + e.部门 + '</td>';
        html += '<td style="width:15%">' + e.message + '</td>';
        html += '</tr>';
    });
    return html;
}

// 校验结果是否存在失败的情况
function checkResult(data) {
    let checkResule = true;

    for (let e of data) {
        if (e.status === false) {
            checkResule = false;
            break;
        }
    }

    return checkResule;
}

// 将数据合并处理成薪酬统计数据
function mergeSalary(data) {
    const { wage, bonus, insurance, subsidy, tax, property, deduction, other } = data;
    let commonT = [];
    let res = [];

    for (let i = 0; i < wage.length; i++) {
        commonT[i] = R.pick(['policyNumber', 'username'], wage[i]);
        const hasPolicy = R.propEq('policyNumber', commonT[i].policyNumber);
        // 合并
        res[i] = R.merge(R.filter(hasPolicy, wage)[0], R.filter(hasPolicy, bonus)[0]);
        res[i] = R.merge(res[i], R.filter(hasPolicy, insurance)[0]);
        res[i] = R.merge(res[i], R.filter(hasPolicy, subsidy)[0]);
        res[i] = R.merge(res[i], R.filter(hasPolicy, tax)[0]);
        res[i] = R.merge(res[i], R.filter(hasPolicy, property)[0]);
        res[i] = R.merge(res[i], R.filter(hasPolicy, deduction)[0]);
        res[i] = R.merge(res[i], R.filter(hasPolicy, other)[0]);

    }
    // let temp = R.pick(['policyNumber', 'username'], wage);
    // console.log(wage);
    return R.flatten(res);
}
