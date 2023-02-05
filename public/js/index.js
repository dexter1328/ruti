$(function() {
    "use strict";
    // easy pie chart 

    $('.easy-dash-chart1').easyPieChart({
        easing: 'easeOutBounce',
        barColor: '#3b5998',
        lineWidth: 10,
        trackColor: 'rgba(0, 0, 0, 0.08)',
        scaleColor: false,
        onStep: function(from, to, percent) {
            $(this.el).find('.w_percent').text(Math.round(percent));
        }
    });


    $('.easy-dash-chart2').easyPieChart({
        easing: 'easeOutBounce',
        barColor: '#55acee',
        lineWidth: 10,
        trackColor: 'rgba(0, 0, 0, 0.08)',
        scaleColor: false,
        onStep: function(from, to, percent) {
            $(this.el).find('.w_percent').text(Math.round(percent));
        }
    });


    $('.easy-dash-chart3').easyPieChart({
        easing: 'easeOutBounce',
        barColor: '#e52d27',
        lineWidth: 10,
        trackColor: 'rgba(0, 0, 0, 0.08)',
        scaleColor: false,
        onStep: function(from, to, percent) {
            $(this.el).find('.w_percent').text(Math.round(percent));
        }
    });

    $("#trendchart1").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {
        type: 'bar',
        height: '20',
        barWidth: '2',
        resize: true,
        barSpacing: '3',
        barColor: '#eb5076'
    });


    $("#trendchart2").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {
        type: 'bar',
        height: '20',
        barWidth: '2',
        resize: true,
        barSpacing: '3',
        barColor: '#14abef'
    });


    $("#trendchart3").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {
        type: 'bar',
        height: '20',
        barWidth: '2',
        resize: true,
        barSpacing: '3',
        barColor: '#02ba5a'
    });


    $("#trendchart4").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {
        type: 'bar',
        height: '20',
        barWidth: '2',
        resize: true,
        barSpacing: '3',
        barColor: '#d13adf'
    });


    $("#trendchart5").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {
        type: 'bar',
        height: '20',
        barWidth: '2',
        resize: true,
        barSpacing: '3',
        barColor: '#000000'
    });

    // chart 5
   

});