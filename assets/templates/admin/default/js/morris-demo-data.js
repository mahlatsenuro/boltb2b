var line = Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'morris-chart-donut',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [],
  // The name of the data record attribute that contains x-values.
  xkey: 'y',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['b'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Products', 'Total']
});

$.ajax({
    type: "GET",
    url:  "admin_dashboard/line",
    success: function(html){   
        if(html == "error"){
            alert('error');
        }
        else{
            line.setData(JSON.parse(html));
        }
    }
});

var area = Morris.Area({
  element: 'morris-chart-area',
  data: [],
  parseTime: false,
  xkey: 'y',
  ykeys: ['a', 'b'],
  labels: ['Customers', 'Total']
});

$.ajax({
    type: "GET",
    url:  "admin_dashboard/area",
    data: {from_date:$("#date_from").val(), to_date:$("#date_to").val()},
    success: function(html){   
        if(html == "error"){
            alert('error');
        }
        else{
            area.setData(JSON.parse(html));
            bar.setData(JSON.parse(html));
        }
    }
});


var abandond = Morris.Area({
  element: 'morris-chart-abandond',
  data: [],
  parseTime: false,
  xkey: 'y',
  ykeys: ['a', 'b'],
  labels: ['Abandon cart items', 'Revenue']
});

$.ajax({
    type: "GET",
    url:  "admin_dashboard/abandond",
    success: function(html){   
        if(html == "error"){
            alert('error');
        }
        else{
            abandond.setData(JSON.parse(html));
        }
    }
});


//Morris Bar Chart
var bar = Morris.Bar({
element: 'morris-chart-bar',
data: [],
xkey: 'y',
 parseTime: false,
ykeys: ['a', 'b'],
labels: ['Customers', 'Total'],
barColors: ['#8e44ad','#e74c3c'],
resize: true
});
$.ajax({
    type: "GET",
    url:  "admin_dashboard/donut",
    data: {from_date:$("#date_from").val(), to_date:$("#date_to").val()},
    success: function(html){   
        if(html == "error"){
            alert('error');
        }
        else{
            dont.setData(JSON.parse(html));
        }
    }
});
