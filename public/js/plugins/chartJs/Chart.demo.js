var Options = {
    responsive: true
};
// 柱形图
var barData = {
    labels: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
    datasets: [
        {
            label: "2017月度收入",
            backgroundColor: 'rgba(255, 163, 58, 0.5)',
            pointBorderColor: "#fff",
            data: [7986, 8091, 8093,7642,7964,7787,7153,7445,7470,8349,8342,7773]
        },
        {
            label: "2018月度收入",
            backgroundColor: 'rgba(26,179,148,0.5)',
            borderColor: "rgba(26,179,148,0.7)",
            pointBackgroundColor: "rgba(26,179,148,1)",
            pointBorderColor: "#fff",
            data: [7222, 7456, 7540, 8054, 8631, 7813, 7523, 7129, 7923, 8310, 9512, 0]
        },
    ]
};

var ctx2 = document.getElementById("profile-chart").getContext("2d");
new Chart(ctx2, {type: 'bar', data: barData, options:Options});
