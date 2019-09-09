// 文件扩展名
function getFileExtension(fileName) {
    var pos = fileName.lastIndexOf(".");
    var fileExtension = fileName.substring(pos, fileName.length);

    return fileExtension;
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
    const commonArray = ['转储姓名', '保险编号', '发放日期'];
    let filter = commonArray.concat(temp);
    let data = [];
    for (let x of arr1) {
        x = R.pick(filter, x);
        data = R.append(x)(data);
    }
    return data;
}

// 计算汇总记录数和汇总金额
function countSalary(importData, filters) {
    let res = {};
    res.count = importData.length;
    res.sumColumn = {};
    for (let x of filters) {
        res.sumColumn = R.assoc(x, 0, res.sumColumn);
    }
    for(let i of importData) {
        for(let key in i){
            if (key === '转储姓名' || key === '保险编号' || key === '发放日期') {
            } else {
                res.sumColumn[key] += i[key];
            }
        }
    }
    return res;
}

// 动态生成数据汇总结果html
function sumHtml(data) {
    let html = '';
    html += '<thead><tr>';
    html += '<th>#</th>';
    for(let key in data) {
        html += '<th style="white-space: nowrap;">' + key + '</th>';
    }
    html += '</tr></thead>';

    html += '<tbody><tr>';
    html += '<td style="white-space: nowrap;">合计金额</td>';
    for(let key in data) {
        html += '<td style="white-space: nowrap;">' + data[key] + '</td>';
    }
    html += '</tr></tbody>';
    return html;
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
