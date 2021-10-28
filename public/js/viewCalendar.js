document.querySelectorAll('.calendar-chip-post').forEach(function(element) {
    element.addEventListener('click', function() {

        var post = element.nextElementSibling;
        var post_right = post.getBoundingClientRect().right;
        var window_width = window.innerWidth;

        var difference = post_right - window_width;

        if (post_right > window_width) {
            post.style.left = -difference - 32 +'px';
        }
    })
})

var ctxMonthCats = document.getElementById('monthCats').getContext('2d');
var ctxMonthTools = document.getElementById('monthTools').getContext('2d');
var ctxYearCats = document.getElementById('yearCatsDonut').getContext('2d');
var ctxYearCatsBar = document.getElementById('yearCatsBar').getContext('2d');
var ctxYearTools = document.getElementById('yearToolsDonut').getContext('2d');
var ctxYearToolsBar = document.getElementById('yearToolsBar').getContext('2d');
var ctxGlobalCats = document.getElementById('globalCats').getContext('2d');
var ctxGlobalTools = document.getElementById('globalTools').getContext('2d');
var ctxYearRadar = document.getElementById('yearRadar').getContext('2d');

Chart.register({
    ChartDataLabels,
});

function alphaTranform(color) {
    let colorAlphaRegx = /(, ?0\.)[0-9]/g;
    let colorWithoutAlpha = color.replace(colorAlphaRegx, ', 0.8');

    return colorWithoutAlpha;
}

var colorScheme = [
    'rgba(30, 50, 49,0.6)',
    'rgba(72, 86, 101,0.6)',
    'rgba(142, 124, 147,0.6)',
    'rgba(208, 165, 192,0.6)',
    'rgba(246, 192, 208,0.6)',
    'rgba(251, 196, 171,0.6)',
    'rgba(255, 218, 185,0.6)',
    'rgba(209, 227, 221,0.6)',
    'rgba(100, 166, 189,0.6)',
    'rgba(227, 210, 111,0.6)',
    'rgba(13, 0, 164,0.6)',
    'rgba(34, 0, 124,0.6)',
    'rgba(162, 37, 34,0.6)',
    'rgba(143, 133, 125,0.6)',
    'rgba(107, 109, 118,0.6)',
];

var toolColor = new Object();

var optionsBar = {
    plugins: {
        datalabels: {
            display: false,
        },
        tooltip: {
            callbacks: {
                label: function(context) {
                    var data = context.parsed.y;

                    if (data % 1 != 0) {
                        var hour = Math.floor(data);
                        var min = Math.round((data % 1).toFixed(3) * 60);

                        if (min < 10) {
                            min = '0' + min;
                        }

                        return context.dataset.label + ': ' + hour + 'h' + min;

                    } else {
                        return context.dataset.label + ': ' + data + 'h';
                    }
                    
                }
            }
        }
    }
};

var options = {
    plugins: {
        legend: {
            display: false,
        },
        datalabels: {
            formatter: (value, ctx) => {
                let total = 0;
                let dataArr = ctx.dataset.data;
                dataArr.forEach((data) => {
                    total += parseFloat(data);
                });

                let percentage = (value * 100 / total).toFixed(0);

                if (percentage < 10) {
                    return null;
                }

                return percentage + "%";
            },
            color: '#000000',
            font: {
                size: (document.getElementsByClassName('donut_chart')[0].clientWidth) / 14
            }
        },
        tooltip: {
            callbacks: {
                label: function(context) {
                    var data = context.parsed;

                    if (data % 1 != 0) {
                        var hour = Math.floor(data);
                        var min = Math.round((data % 1).toFixed(3) * 60);

                        if (min < 10) {
                            min = '0' + min;
                        }

                        return context.label + ': ' + hour + 'h' + min;

                    } else {
                        return context.label + ': ' + data + 'h';
                    }
                }
            }
        }
    },
};

var monthCats = new Chart(ctxMonthCats, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [],
            borderColor: [],
            hoverOffset: 3
        }]
    },
    options
});

var monthTools = new Chart(ctxMonthTools, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [],
            borderColor: [],
            hoverOffset: 3
        }]
    },
    options
});

var yearCats = new Chart(ctxYearCats, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [],
            borderColor: [],
            hoverOffset: 3
        }]
    },
    options
});

var yearTools = new Chart(ctxYearTools, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [],
            borderColor: [],
            hoverOffset: 3
        }]
    },
    options
});

var globalCats = new Chart(ctxGlobalCats, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [],
            borderColor: [],
            hoverOffset: 3
        }]
    },
    options
});

var globalTools = new Chart(ctxGlobalTools, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [],
            borderColor: [],
            hoverOffset: 3
        }]
    },
    options
});

var yearCatsBar = new Chart(ctxYearCatsBar, {
    type: 'bar',
    data: {
        labels: [
            'Jan.', 'Fev.', 'Mar.', 'Avr.', 'Mai', 'Juin', 'Jui.', 'Aou.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'
        ],
        datasets: []
    },
    options: optionsBar
});

var yearToolsBar = new Chart(ctxYearToolsBar, {
    type: 'bar',
    data: {
        labels: [
            'Jan.', 'Fev.', 'Mar.', 'Avr.', 'Mai', 'Juin', 'Jui.', 'Aou.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'
        ],
        datasets: []
    },
    options: optionsBar
});

var yearRadar = new Chart(ctxYearRadar, {
    type: 'radar',
    data: {
        labels: [
            'Jan.', 'Fev.', 'Mar.', 'Avr.', 'Mai', 'Juin', 'Jui.', 'Aou.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'
        ],
        datasets: [
            {
                label: 'Total',
                data: [],
                borderColor: 'black',
                borderWidth: 2,
            }
        ]
    },
    options: {
        plugins: {
            datalabels: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var data = context.parsed.r;

                        if (data == 0) {
                            return 'Aucune donnée';
                        }

                        if (data % 1 != 0) {
                            var hour = Math.floor(data);
                            var min = Math.round((data % 1).toFixed(3) * 60);

                            if (min < 10) {
                                min = '0' + min;
                            }

                            return context.dataset.label + ': ' + hour + 'h' + min;

                        } else {
                            return context.dataset.label + ': ' + data + 'h';
                        }
                        
                    }
                }
            }
        },
        scales: {
            r: {
                beginAtZero: true,
            }
        },

    }
});

var allMonthsCatData             = {};
var allMonthsToolData            = {};

var allMonthsTotalData           = {
    months: {
        1: '',
        2: '',
        3: '',
        4: '',
        5: '',
        6: '',
        7: '',
        8: '',
        9: '',
        10: '',
        11: '',
        12: '',
        }
};

dbDataGlobalTools.forEach((tool, index) => {
    var indexColor = Math.floor(Math.random() * colorScheme.length);
    let color = colorScheme[indexColor];
    let border = alphaTranform(color);

    globalTools.data.labels.push(tool.nameTool);
    globalTools.data.datasets[0].data.push(tool.totalFloat);
    globalTools.data.datasets[0].backgroundColor.push(color);
    globalTools.data.datasets[0].borderColor.push(border);

    toolColor[tool.nameTool] = color;
    colorScheme.splice(indexColor,1);
});

dbDataMonthCats.forEach((cat, index) => {
    monthCats.data.labels.push(cat.nameCat);
    monthCats.data.datasets[0].data.push(cat.totalFloat);
    monthCats.data.datasets[0].backgroundColor.push(cat.colorCat);
    monthCats.data.datasets[0].borderColor.push(cat.colorCat);
});

dbDataYearCats.forEach((cat, index) => {
    yearCats.data.labels.push(cat.nameCat);
    yearCats.data.datasets[0].data.push(cat.totalFloat);
    yearCats.data.datasets[0].backgroundColor.push(cat.colorCat);
    yearCats.data.datasets[0].borderColor.push(cat.colorCat);
});

dbDataGlobalCats.forEach((cat, index) => {
    globalCats.data.labels.push(cat.nameCat);
    globalCats.data.datasets[0].data.push(cat.totalFloat);
    globalCats.data.datasets[0].backgroundColor.push(cat.colorCat);
    globalCats.data.datasets[0].borderColor.push(cat.colorCat);
});

dbDataMonthTools.forEach((tool, index) => {
    let color = toolColor[tool.nameTool];
    let border = alphaTranform(color);

    monthTools.data.labels.push(tool.nameTool);
    monthTools.data.datasets[0].data.push(tool.totalFloat);
    monthTools.data.datasets[0].backgroundColor.push(color);
    monthTools.data.datasets[0].borderColor.push(border);
});

dbDataYearTools.forEach((tool, index) => {
    let color = toolColor[tool.nameTool];
    let border = alphaTranform(color);

    yearTools.data.labels.push(tool.nameTool);
    yearTools.data.datasets[0].data.push(tool.totalFloat);
    yearTools.data.datasets[0].backgroundColor.push(color);
    yearTools.data.datasets[0].borderColor.push(border)
});

dbDataCatsHoursInAllMonths.map(array => {
    array.map(data => {
        allMonthsCatData[data.nameCat] = {
            color: data.colorCat,
            months: {
                1: '',
                2: '',
                3: '',
                4: '',
                5: '',
                6: '',
                7: '',
                8: '',
                9: '',
                10: '',
                11: '',
                12: '',
            }
        };
    });
});

dbDataCatsHoursInAllMonths.map(array => {
    array.map(data => {
        Object.keys(allMonthsCatData[data.nameCat].months).forEach(month => {
            if (month == data.Month) {
                allMonthsCatData[data.nameCat].months[month] = data.totalFloat;
            }
        });
    });
});

dbDataToolsHoursInAllMonths.map(array => {
    array.map(data => {
        allMonthsToolData[data.nameTool] = {
            color: toolColor[data.nameTool],
            months: {
                1: '',
                2: '',
                3: '',
                4: '',
                5: '',
                6: '',
                7: '',
                8: '',
                9: '',
                10: '',
                11: '',
                12: '',
            }
        };
    });
});

dbDataToolsHoursInAllMonths.map(array => {
    array.map(data => {
        Object.keys(allMonthsToolData[data.nameTool].months).forEach(month => {
            if (month == data.Month) {
                allMonthsToolData[data.nameTool].months[month] = data.totalFloat;
            }
        });
    });
});

dbDataTotalHoursInAllMonths.map(data => {
    Object.keys(allMonthsTotalData.months).forEach(month => {
            if (month == data.Month) {
                allMonthsTotalData.months[month] = data.totalFloat;
            }
    });
});

Object.entries(allMonthsTotalData.months).forEach(month => {
    yearRadar.data.datasets[0].data.push(month[1]);
});

Object.entries(allMonthsCatData).forEach((cat, index) => {
    yearCatsBar.data.datasets.push(
        {
            label: cat[0],
            data: Object.values(cat[1].months),
            backgroundColor: cat[1].color,
        }
    );
});

Object.entries(allMonthsToolData).forEach((tool, index) => {
    yearToolsBar.data.datasets.push(
        {
            label: tool[0],
            data: Object.values(tool[1].months),
            backgroundColor: tool[1].color,
        }
    );
});

monthCats.update();
monthTools.update();
yearCats.update();
yearTools.update();
globalCats.update();
globalTools.update();
yearCatsBar.update();
yearToolsBar.update();
yearRadar.update();