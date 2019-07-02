var dom = document.getElementById("salaryDetail");
var myChart = echarts.init(dom);
var app = {};
option = null;
app.title = '嵌套环形图';

option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: 'horizontal',
        x: 'left',
        data:['工资','奖金','AAAA工资','BBBB工资','CCCC工资','AAAA奖金','BBBB奖金','CCCC奖金','DDDD奖金','EEEE奖金','FFFF奖金']
    },
    series: [
        {
            name:'岗位类型',
            type:'pie',
            selectedMode: 'single',
            radius: [0, '30%'],
            label: {
                normal: {
                    position: 'inner'
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {value:3200, name:'奖金'},
                {value:5600, name:'工资'}
            ]
        },
        {
            name:'分类',
            type:'pie',
            radius: ['40%', '55%'],
            label: {
                normal: {
                    backgroundColor: '#eee',
                    borderColor: '#aaa',
                    borderWidth: 1,
                    borderRadius: 4,
                    rich: {
                        a: {
                            color: '#999',
                            lineHeight: 22,
                            align: 'center'
                        },
                        hr: {
                            borderColor: '#aaa',
                            width: '100%',
                            borderWidth: 0.5,
                            height: 0
                        },
                        b: {
                            fontSize: 16,
                            lineHeight: 33
                        },
                        per: {
                            color: '#eee',
                            backgroundColor: '#334455',
                            padding: [2, 4],
                            borderRadius: 2
                        }
                    }
                }
            },
            data:[
                {value:2000, name:'AAAA奖金'},
                {value:400, name:'BBBB奖金'},
                {value:100, name:'CCCC奖金'},
                {value:200, name:'DDDD奖金'},
                {value:250, name:'EEEE奖金'},
                {value:250, name:'FFFF奖金'},
                {value:3400, name:'AAAA工资'},
                {value:1200, name:'BBBB工资'},
                {value:1000, name:'CCCC工资'}
            ]
        }
    ]
};;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}
