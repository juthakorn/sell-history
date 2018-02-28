$(function() {

   /* Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            iphone: 2666,
            ipad: null,
            itouch: 2647
        }, {
            period: '2010 Q2',
            iphone: 2778,
            ipad: 2294,
            itouch: 2441
        }, {
            period: '2010 Q3',
            iphone: 4912,
            ipad: 1969,
            itouch: 2501
        }, {
            period: '2010 Q4',
            iphone: 3767,
            ipad: 3597,
            itouch: 5689
        }, {
            period: '2011 Q1',
            iphone: 6810,
            ipad: 1914,
            itouch: 2293
        }, {
            period: '2011 Q2',
            iphone: 5670,
            ipad: 4293,
            itouch: 1881
        }, {
            period: '2011 Q3',
            iphone: 4820,
            ipad: 3795,
            itouch: 1588
        }, {
            period: '2011 Q4',
            iphone: 15073,
            ipad: 5967,
            itouch: 5175
        }, {
            period: '2012 Q1',
            iphone: 10687,
            ipad: 4460,
            itouch: 2028
        }, {
            period: '2012 Q2',
            iphone: 8432,
            ipad: 5713,
            itouch: 1791
        }],
        xkey: 'period',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });*/

    /*Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });*/
var datavalbuy = $("input[name='valbuy']").val().split("|");
var datavalrent = $("input[name='valrent']").val().split("|");
var valdateb = $("input[name='valdateb']").val().split("|");

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: valdateb[0],
            a: datavalbuy[0],
            b: datavalrent[0]
        }, {
            y: valdateb[1],
            a: datavalbuy[1],
            b: datavalrent[1]
        }, {
            y: valdateb[2],
            a: datavalbuy[2],
            b: datavalrent[2]
        }, {
            y: valdateb[3],
            a: datavalbuy[3],
            b: datavalrent[3]
        }, {
            y: valdateb[4],
            a: datavalbuy[4],
            b: datavalrent[4]
        }, {
            y: valdateb[5],
            a: datavalbuy[5],
            b: datavalrent[5]
        }, {
            y: valdateb[6],
            a: datavalbuy[6],
            b: datavalrent[6]
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['ยอดการขาย', 'ยอดการเช่า'],
        hideHover: 'auto',
        resize: true
    });

});
