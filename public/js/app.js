app.currentFrom = '';
app.currentTo = '';

app.prepareSwitcherData = function()
{
    this.switcherData = {};
    var length = this.data.length;

    for (var i = 0; i < length; i++) {
        item = this.data[i];
        
        if (this.switcherData.hasOwnProperty(item.from)) {
            this.switcherData[item.from].push(item.to);
        } else {
            this.switcherData[item.from] = [item.to];
        }
    }
};

app.switchFrom = function(from)
{
    if (this.currentFrom == from) {
        return;
    } else {
        this.currentFrom = from;
        this.currentTo = '';
    }

    $('.js-to .to').removeClass('selected');
    $('.js-from .currency').removeClass('selected');
    $('.js-to').removeClass('active');
    $('.js-to[data-from="'+from+'"]').addClass('active');
    $('.js-from .currency:contains("'+from+'")').addClass('selected');

    if (app.switcherData[from].length == 1) {
        this.switchTo(app.switcherData[from][0]);
    }
};

app.switchTo = function(to)
{
    if (this.currentTo == to) {
        return;
    } else {
        this.currentTo = to;
    }

    $('.js-to .to').removeClass('selected');
    $('.js-to.active .to:contains("'+to+'")').addClass('selected');

    this.createChart();
}

app.createChart = function()
{
    var chartData = this.createChartData();

    $('.js-chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Country messages share',
            data: chartData
        }]
    });
};

app.createChartData = function()
{
    var chartData = [];

    var length = this.data.length;
    for (var i = 0; i < length; i++) {
        var item = this.data[i];

        if (item.from != this.currentFrom || item.to != this.currentTo) {
            continue;
        }

        item = item.message_numbers;
        var itemLength = item.length;
        for (var j = 0; j < itemLength; j++) {
            chartData.push([
                item[j].country,
                parseInt(item[j].messages_number)
            ]);
        }
    }

    return chartData;
}

app.prepareSwitcherData();

(function(app) {
    $(function() {
        var cont = $('.js-switcher');
        
        placeFrom(cont, app.switcherData);

        placeTo(cont, app.switcherData);

        for (item in app.switcherData) {
            app.switchFrom(item);
            app.switchTo(app.switcherData[item][0]);
            break;
        }
    });

    function placeFrom(cont, data)
    {
        var content = $('<div class="js-from"><span>from: </span></div>');

        for (item in data) {
            var span = $('<span class="currency">'+item+'</span>');

            span.click(function() {
                app.switchFrom($(this).text());
            });

            content.append(span);
        }

        cont.append(content);
    }

    function placeTo(cont, data)
    {
        for (item in data) {
            var content = $('<div class="js-to" data-from="'+item+'"><span>to: </span></div>');

            var length = data[item].length;
            for (var i = 0; i < length; i++) {
                var span = $('<span class="to currency">'+data[item][i]+'</span>');

                span.click(function() {
                    app.switchTo($(this).text());
                });

                content.append(span);
            }

            cont.append(content);
        }
    }
})(app);
