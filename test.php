
<?php?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script src="js_includes/amcharts/amcharts.js" type="text/javascript"></script>
<script src="js_includes/amcharts/serial.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/dark.js"></script>

<script type="text/javascript">

AmCharts.loadJSON = function(url) {
  // create the request
  if (window.XMLHttpRequest) {
    // IE7+, Firefox, Chrome, Opera, Safari
    var request = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    var request = new ActiveXObject('Microsoft.XMLHTTP');
  }

  // load it
  // the last "false" parameter ensures that our code will wait before the
  // data is loaded
  request.open('GET', url, false);
  request.send();

  // parse adn return the output
  return eval(request.responseText);
};

   //console.debug(chartData);
  AmCharts.ready(function() {
   // load the data
  var chartData = AmCharts.loadJSON('data.php');

  var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "dark",
    "pathToImages": "http://www.amcharts.com/lib/3/images/",
    "dataProvider": chartData,
    "valueAxes": [{
        "axisAlpha": 0.2,
        "dashLength": 1,
        "position": "left"
    }],
    "graphs": [{
        "id":"g1",
        "balloonText": "[[category]]<br /><b><span style='font-size:14px;'>value: [[value]]</span></b>",
        "bullet": "round",
        "bulletBorderAlpha": 1,
    "bulletColor":"#FFFFFF",
        "hideBulletsCount": 50,
        "title": "red line",
        "valueField": "visits",
    "useLineColorForBulletBorder":true
    }],
    "chartScrollbar": {
        "autoGridCount": true,
        "graph": "g1",
        "scrollbarHeight": 40
    },
    "chartCursor": {
        "cursorPosition": "mouse"
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "axisColor": "#DADADA",
        "dashLength": 1,
        "minorGridEnabled": true
    },
  "exportConfig":{
    menuRight: '20px',
      menuBottom: '30px',
      menuItems: [{
      icon: 'http://www.amcharts.com/lib/3/images/export.png',
      format: 'png'   
      }]  
  }
});

chart.addListener("rendered", zoomChart);
zoomChart();

// this method is called when chart is first inited as we listen for "dataUpdated" event
function zoomChart() {
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
}



   // this is a temporary line to verify if the data is loaded and parsed correctly
   // please note, that console.debug will work on Safari/Chrome only
   console.debug(chartData);
    // SERIAL CHART    
  chart = new AmCharts.AmSerialChart();
  chart.pathToImages = "http://www.amcharts.com/lib/images/";
  chart.dataProvider = chartData;
  chart.categoryField = "category";
  chart.dataDateFormat = "YYYY-MM-DD";


  // GRAPHS

  var graph1 = new AmCharts.AmGraph();
  graph1.valueField = "value1";
  graph1.bullet = "round";
  graph1.bulletBorderColor = "#FFFFFF";
  graph1.bulletBorderThickness = 2;
  graph1.lineThickness = 2;
  graph1.lineAlpha = 0.5;
  chart.addGraph(graph1);

  //var graph2 = new AmCharts.AmGraph();
 // graph2.valueField = "value2";
 // //graph2.bullet = "round";
 // graph2.bulletBorderColor = "#FFFFFF";
 // graph2.bulletBorderThickness = 2;
 //// graph2.lineThickness = 2;
 // graph2.lineAlpha = 0.5;
 // chart.addGraph(graph2);

  // CATEGORY AXIS 
  chart.categoryAxis.parseDates = true;

  // WRITE
  chart.write("chartdiv");
   // build the chart
   // ...
 });
</script>
<style type="text/css">
  #chartdiv {
    background: #3f3f4f;
    color:#ffffff; 
  width:100%;
  height:500px;
  font-size:11px;
}          
</style>
</head>
<body>
    <div id="chartdiv"></div>
</body>
</html>