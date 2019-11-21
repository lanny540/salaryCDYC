// 文件扩展名
function getFileExtension(fileName)
{
    let pos = fileName.lastIndexOf(".");

    return fileName.substring(pos, fileName.length);
}

// excel文件上传
function importf(obj)
{
    excel = [];
    if (!obj.files) {
        return;
    }

    let suffix = obj.files[0].name.split(".")[1];
    if (suffix !== 'xls' && suffix !== 'xlsx') {
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
    reader.onload = function (e) {
        let data = e.target.result;
        wb = XLSX.read(data, {
            type: 'binary'
        });
        //wb.SheetNames[0]是获取Sheets中第一个Sheet的名字
        //wb.Sheets[Sheet名]获取第一个Sheet的数据

        // 按字段读取excel的值
        let xlsData = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]);
        excel = filterData(xlsData, filters);
        // console.log(excel);
    };
    reader.readAsBinaryString(f);
}

// 根据列名筛选数据
function filterData(arr1, temp)
{
    // const commonArray = ['保险编号'];
    // let filter = commonArray.concat(temp);
    // console.log(filter);
    let data = [];
    for (let x of arr1) {
        x = R.pick(temp, x);
        data = R.append(x)(data);
    }
    return data;
}

// 计算合计字段
function calculationData(data, filters, uploadType)
{
    let res ={};
    res.excel = {};
    res.filters = [];
    switch (uploadType) {
        case '9':
            filters = R.append('年薪工资', filters);
            filters = R.append('岗位工资', filters);
            filters = R.append('交通费', filters);
            res.excel = employeesWage(data);
            res.filters = filters;
            break;
        case '10':
            filters = R.append('基本养老金', filters);
            res.excel = lgxy(data);
            res.filters = filters;
            break;
        case '11':
            filters = R.append('国家小计', filters);
            filters = R.append('地方小计', filters);
            filters = R.append('行业小计', filters);
            filters = R.append('统筹小计', filters);
            filters = R.append('企业小计', filters);
            res.excel = txsj(data);
            res.filters = filters;
            break;
        case '21':
            filters = R.append('独子费', filters);
            res.excel = single(data);
            res.filters = filters;
            break;
        case '22':
            filters = R.append('公积金个人', filters);
            filters = R.append('公积金扣除', filters);
            filters = R.append('公积企超标', filters);
            res.excel = gjj(data);
            res.filters = filters;
            break;
        case '23':
            filters = R.append('年金个人', filters);
            filters = R.append('年金扣除', filters);
            filters = R.append('年金企超标', filters);
            filters = R.append('退养金个人', filters);
            filters = R.append('退养金扣除', filters);
            filters = R.append('退养企超标', filters);
            filters = R.append('医保金个人', filters);
            filters = R.append('医保金扣除', filters);
            filters = R.append('医保企超标', filters);
            filters = R.append('失业金个人', filters);
            filters = R.append('失业金扣除', filters);
            filters = R.append('失业企超标', filters);
            res.excel = insurances(data);
            res.filters = filters;
            break;
        default:
            res.excel = data;
            res.filters =filters;
    }

    return res;
}

// 在岗职工工资.
function employeesWage(data)
{
    for (let item=0; item<data.length; item++) {
        data[item]['年薪工资'] = data[item]['标准预付年'] - data[item]['岗位工资病'] - data[item]['岗位工资事'] - data[item]['岗位工资婴'];
        data[item]['岗位工资'] = data[item]['标准岗位工'] - data[item]['岗位工资病'] - data[item]['岗位工资事'] - data[item]['岗位工资婴'];
        data[item]['交通费'] = data[item]['标准交通补'] + data[item]['交通补贴考'];
    }

    return data;
}

// 离岗休养
function lgxy(data)
{
    for (let item=0; item<data.length; item++) {
        data[item]['基本养老金'] = data[item]['内岗位'] + data[item]['内保留'] + data[item]['内增加'] + data[item]['年功工资'];
    }

    return data;
}

// 离岗休养
function txsj(data)
{
    for (let item=0; item < data.length; item++) {
        data[item]['国家小计'] = data[item]['国家补贴'] + data[item]['国家生活'];
        data[item]['地方小计'] = data[item]['地方粮差'] + data[item]['地方其他'] + data[item]['地方物补'] + data[item]['地方生活'];
        data[item]['行业小计'] = data[item]['行业工龄'] + data[item]['行业退补'] + data[item]['行业其他'];
        data[item]['统筹小计'] = data[item]['基本养老金'] + data[item]['增机'] + data[item]['国家小计'] + data[item]['地方小计'] + data[item]['行业小计'];

        data[item]['企业小计'] = data[item]['企业粮差'] + data[item]['企业工龄'] + data[item]['企业书报'] + data[item]['企业水电'] + data[item]['企业生活'];
        data[item]['企业小计'] += data[item]['企业独子费'] + data[item]['企业护理费'] + data[item]['企业通讯费'] + data[item]['企业规范增'];
        data[item]['企业小计'] += data[item]['企业工龄02'] + data[item]['企业内退补'] + data[item]['企业补发'];
    }

    return data;
}

// 独子费
function single(data)
{
    for (let item=0; item < data.length; item++) {
        data[item]['独子费'] = data[item]['独子费标准'] + data[item]['独子费补发'];
    }

    return data;
}

// 公积金
function gjj(data)
{
    const GJJ_PERSON_UPPER_LIMIT =2139;
    const GJJ_ENTERPRISE_UPPER_LIMIT =2139;

    for (let item=0; item < data.length; item++) {
        let temp = data[item]['公积金标准'] + data[item]['公积金补扣'];
        data[item]['公积金个人'] = temp;

        if (temp > GJJ_PERSON_UPPER_LIMIT) {
            data[item]['公积金扣除'] = GJJ_PERSON_UPPER_LIMIT;
        } else {
            data[item]['公积金扣除'] = temp;
        }

        if (data[item]['公积企业缴'] > GJJ_ENTERPRISE_UPPER_LIMIT) {
            data[item]['公积企超标'] = GJJ_ENTERPRISE_UPPER_LIMIT;
        } else {
            data[item]['公积企超标'] = data[item]['公积企业缴'];
        }
    }

    return data;
}

// 社保
function insurances(data)
{
    const ANNUITY_PERSON_UPPER_LIMIT = 713;
    const ANNUITY_ENTERPRISE_UPPER_LIMIT = 999999;
    const RETIRE_PERSON_UPPER_LIMIT = 1294.32;
    const RETIRE_ENTERPRISE_UPPER_LIMIT = 999999;
    const MEDICAL_PERSON_UPPER_LIMIT = 323.58;
    const MEDICAL_ENTERPRISE_UPPER_LIMIT = 1213.43;
    const UNEMPLOYMENT_PERSON_UPPER_LIMIT = 64.72;
    const UNEMPLOYMENT_ENTERPRISE_UPPER_LIMIT = 97.07;

    for (let item=0; item < data.length; item++) {
        // 年金计算字段
        let annuity = data[item]['年金标准'] + data[item]['年金补扣'];
        data[item]['年金个人'] = annuity;

        if (annuity > ANNUITY_PERSON_UPPER_LIMIT) {
            data[item]['年金扣除'] = ANNUITY_PERSON_UPPER_LIMIT;
        } else {
            data[item]['年金扣除'] = annuity;
        }

        if (data[item]['年金企业缴'] > ANNUITY_ENTERPRISE_UPPER_LIMIT) {
            data[item]['年金企超标'] = ANNUITY_ENTERPRISE_UPPER_LIMIT;
        } else {
            data[item]['年金企超标'] = data[item]['年金企业缴'];
        }
        // 退养金计算字段
        let retire = data[item]['退养金标准'] + data[item]['退养金补扣'];
        data[item]['退养金个人'] = retire;

        if (retire > RETIRE_PERSON_UPPER_LIMIT) {
            data[item]['退养金扣除'] = RETIRE_PERSON_UPPER_LIMIT;
        } else {
            data[item]['退养金扣除'] = retire;
        }

        if (data[item]['退养企业缴'] > RETIRE_ENTERPRISE_UPPER_LIMIT) {
            data[item]['退养企超标'] = RETIRE_ENTERPRISE_UPPER_LIMIT;
        } else {
            data[item]['退养企超标'] = data[item]['退养企业缴'];
        }
        // 医保金计算字段
        let medical = data[item]['医保金标准'] + data[item]['医保金补扣'];
        data[item]['医保金个人'] = medical;

        if (medical > MEDICAL_PERSON_UPPER_LIMIT) {
            data[item]['医保金扣除'] = MEDICAL_PERSON_UPPER_LIMIT;
        } else {
            data[item]['医保金扣除'] = medical;
        }

        if (data[item]['医保企业缴'] > MEDICAL_ENTERPRISE_UPPER_LIMIT) {
            data[item]['医保企超标'] = MEDICAL_ENTERPRISE_UPPER_LIMIT;
        } else {
            data[item]['医保企超标'] = data[item]['医保企业缴'];
        }
        // 失业金计算字段
        let unemployment = data[item]['失业金标准'] + data[item]['失业金补扣'];
        data[item]['失业金个人'] = unemployment;

        if (unemployment > UNEMPLOYMENT_PERSON_UPPER_LIMIT) {
            data[item]['失业金扣除'] = UNEMPLOYMENT_PERSON_UPPER_LIMIT;
        } else {
            data[item]['失业金扣除'] = unemployment;
        }

        if (data[item]['失业企业缴'] > UNEMPLOYMENT_ENTERPRISE_UPPER_LIMIT) {
            data[item]['失业企超标'] = UNEMPLOYMENT_ENTERPRISE_UPPER_LIMIT;
        } else {
            data[item]['失业企超标'] = data[item]['失业企业缴'];
        }
    }

    return data;
}

// 计算汇总记录数和汇总金额
function countSalary(importData, filters)
{
    let res = {};
    res.count = importData.length;
    res.sumColumn = {};
    for (let x of filters) {
        res.sumColumn = R.assoc(x, 0, res.sumColumn);
    }
    for (let i of importData) {
        for (let key in i) {
            if (key === '保险编号' || key === '工号' || key === '公车扣备注' || key === '它项扣备注') {
            } else {
                res.sumColumn[key] += i[key] * 100;
            }
        }
    }
    return res;
}

// 动态生成数据汇总结果html
function sumHtml(data)
{
    console.log(data);
    let html = '';
    html += '<thead><tr>';
    html += '<th>#</th>';
    for (let key in data) {
        if (key !== '保险编号' && key !== '工号') {
            html += '<th style="white-space: nowrap;">' + key + '</th>';
        }
    }
    html += '</tr></thead>';

    html += '<tbody><tr>';
    html += '<td style="white-space: nowrap;">合计金额</td>';
    for (let key in data) {
        if (key !== '保险编号' && key !== '工号') {
            html += '<td style="white-space: nowrap;">' + data[key] / 100 + '</td>';
        }
    }
    html += '</tr></tbody>';
    return html;
}

// excel上传数据与数据库信息校验
function excelDataCheck(arr1, arr2)
{
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

// 模拟form提交
function Post(URL, PARAMTERS)
{
    //创建form表单
    let temp_form = document.createElement("form");
    temp_form.action = URL;
    //如需打开新窗口，form的target属性要设置为'_blank'
    temp_form.target = "_self";
    temp_form.method = "post";
    temp_form.style.display = "none";
    //添加参数
    for (let item in PARAMTERS) {
        let opt = document.createElement("input");
        opt.name = item;
        opt.value = PARAMTERS[item];
        temp_form.appendChild(opt);
    }
    document.body.appendChild(temp_form);
    //提交数据
    temp_form.submit();
}

// 获取datatables数据
function getTableDatas()
{
    let sheetTable = new $.fn.dataTable.Api('#sheets-dataTables');
    let length = sheetTable.rows().data().length;
    let list = [];
    for (let i = 0; i < length; i++) {
        list.push(sheetTable.rows().data()[i]);
    }
    return list;
}

// 获取对象的KEY
function getObjectKeys(object)
{
    let keys = [];
    for (let property in object) {
        keys.push(property);
    }
    return keys;
}

// 获取对象的Value
function getObjectValues(object)
{
    let values = [];
    for (let property in object) {
        values.push(object[property]);
    }
    return values;
}

// 输出所有字段求和数据的html
function allColumnsHtml(data) {
    let keys = getObjectKeys(data);
    let tempLength = keys.length;
    let html = '';
    let tableTitle = '';
    let tableData = '';

    for (let i=0; i < tempLength; ++i)
    {
        if (i % 6 === 0) {
            tableTitle += `
                <tr class="row mx-0 bg-success">
                    <td class="col-2 text-center"><strong>${keys[i]}</strong></td>
            `;
            tableData += `
                <tr class="row mx-0">
                    <td class="col-2 text-center">${data[keys[i]]}</td>
            `;
        } else if (i % 6 === 5 || i === tempLength - 1) {
            tableTitle += `
                    <td class="col-2 text-center"><strong>${keys[i]}</strong></td>
                </tr>
            `;
            tableData += `
                    <td class="col-2 text-center">${data[keys[i]]}</td>
                </tr>
            `;
            html += tableTitle + tableData;
            tableTitle = '';
            tableData = '';
        } else {
            tableTitle += `
                <td class="col-2 text-center"><strong>${keys[i]}</strong></td>
            `;
            tableData += `
                <td class="col-2 text-center">${data[keys[i]]}</td>
            `;
        }
    }

    return html;
}
