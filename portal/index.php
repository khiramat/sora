<!-- head -->
<?php
$h1 = "運用レポート ポータルサイト";
?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<meta charset = "utf-8">
	<title>レンジャーシステムズ運用レポート</title>
	<link rel = "stylesheet" type = "text/css" href = "http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
	<!--	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap/css/bootstrap-reboot.css"> -->
	<link rel = "stylesheet" type = "text/css" href = "<?=base_url()?>assets/css/report_top.css">
</head>

<body>
<!-- header -->
<header>
	<p>Ranger Systems</p>
	<nav>
		<ul>
			<li><a href = "<?=base_url()?>throughput/main/12/weekly" target = "_blank">LinksMate Web版</a></li>
			<li><a href = "<?=base_url()?>home/pdf" target = "_blank">LinksMate 提出版</a></li>
			<li><a href = "http://13.114.82.254/report_sora/traffic_trend/line" target = "_blank">SORAシム 提出版</a></li>
			<li><a href = "http://13.114.82.254/report_sora/appendix/line" target = "_blank">SORAシム 別紙</a></li>
            <li><a href = "http://13.114.82.254/report_docomo/docomo_report/index" target = "_blank">docomo 提出版</a></li>
            <li><a href = "http://13.114.82.254/report_docomo/throughput/main/Xi/weekly" target = "_blank">docomo Web版</a></li>
		</ul>
	</nav>
	<h1><?=$h1?></h1>
</header>
<!-- body -->
<div class = "container">
	<div class = "grid1">
		<div id = "container1" style = "width: 680px; height: 330px; margin: 0"></div>
	</div>
	<div class = "grid3">
		<div id = "container3" style = "width: 330px; height: 330px; margin: 0"></div>
		<!--
		<div id="wrapper">
			<div id="container99"></div>
			<div id="info">
				<span class="f32"><span id="flag"></span></span>
				<h2></h2>
				<div class="subheader">Click countries to view history</div>
				<div id="country-chart"></div>
			</div>-->
	</div>

<div class = "grid4">
	<div id = "container2" style = "width: 330px; height: 330px; margin: 0"></div>
</div>
<div class = "grid5">
	<div id = "container4" style = "width: 680px; height: 330px; margin: 0"></div>
</div>
<div class = "grid2">
	<ul>
		<li>LinksMate 様レポートは、毎週月曜日の AM 7時半に自動生成されます。</li>
	</ul>
</div>
</div>

<!-- footer -->
<footer>
	<address>(c) 2007 - <?php echo date("Y"); ?> Ranger Systems Co., Ltd. all rights reserved.</address>
</footer>
<script src = "//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src = "https://code.highcharts.com/highcharts.js"></script>
<script src = "https://code.highcharts.com/modules/series-label.js"></script>
<script src = "https://code.highcharts.com/modules/exporting.js"></script>
<script src = "https://code.highcharts.com/modules/export-data.js"></script>
<script src = "https://code.highcharts.com/highcharts-more.js"></script>
<script src = "https://code.highcharts.com/modules/sankey.js"></script>
<script src = "https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src = "https://code.highcharts.com/maps/modules/map.js"></script>
<script src = "https://code.highcharts.com/mapdata/custom/world.js"></script>
<link rel = "stylesheet" type = "text/css" href = "//github.com/downloads/lafeber/world-flags-sprite/flags32.css" />

<script>
  Highcharts.chart('container1', {
	chart: {
	  type: 'spline',
	  scrollablePlotArea: {
		minWidth: 600,
		scrollPositionX: 1
	  }
	},
	title: {
	  text: 'Wind speed during two days'
	},
	subtitle: {
	  text: '13th & 14th of February, 2018 at two locations in Vik i Sogn, Norway'
	},
	xAxis: {
	  type: 'datetime',
	  labels: {
		overflow: 'justify'
	  }
	},
	yAxis: {
	  title: {
		text: 'Wind speed (m/s)'
	  },
	  minorGridLineWidth: 0,
	  gridLineWidth: 0,
	  alternateGridColor: null,
	  plotBands: [{ // Light air
		from: 0.3,
		to: 1.5,
		color: 'rgba(68, 170, 213, 0.1)',
		label: {
		  text: 'Light air',
		  style: {
			color: '#606060'
		  }
		}
	  }, { // Light breeze
		from: 1.5,
		to: 3.3,
		color: 'rgba(0, 0, 0, 0)',
		label: {
		  text: 'Light breeze',
		  style: {
			color: '#606060'
		  }
		}
	  }, { // Gentle breeze
		from: 3.3,
		to: 5.5,
		color: 'rgba(68, 170, 213, 0.1)',
		label: {
		  text: 'Gentle breeze',
		  style: {
			color: '#606060'
		  }
		}
	  }, { // Moderate breeze
		from: 5.5,
		to: 8,
		color: 'rgba(0, 0, 0, 0)',
		label: {
		  text: 'Moderate breeze',
		  style: {
			color: '#606060'
		  }
		}
	  }, { // Fresh breeze
		from: 8,
		to: 11,
		color: 'rgba(68, 170, 213, 0.1)',
		label: {
		  text: 'Fresh breeze',
		  style: {
			color: '#606060'
		  }
		}
	  }, { // Strong breeze
		from: 11,
		to: 14,
		color: 'rgba(0, 0, 0, 0)',
		label: {
		  text: 'Strong breeze',
		  style: {
			color: '#606060'
		  }
		}
	  }, { // High wind
		from: 14,
		to: 15,
		color: 'rgba(68, 170, 213, 0.1)',
		label: {
		  text: 'High wind',
		  style: {
			color: '#606060'
		  }
		}
	  }]
	},
	tooltip: {
	  valueSuffix: ' m/s'
	},
	plotOptions: {
	  spline: {
		lineWidth: 4,
		states: {
		  hover: {
			lineWidth: 5
		  }
		},
		marker: {
		  enabled: false
		},
		pointInterval: 3600000, // one hour
		pointStart: Date.UTC(2018, 1, 13, 0, 0, 0)
	  }
	},
	series: [{
	  name: 'Hestavollane',
	  data: [
		3.7, 3.3, 3.9, 5.1, 3.5, 3.8, 4.0, 5.0, 6.1, 3.7, 3.3, 6.4,
		6.9, 6.0, 6.8, 4.4, 4.0, 3.8, 5.0, 4.9, 9.2, 9.6, 9.5, 6.3,
		9.5, 10.8, 14.0, 11.5, 10.0, 10.2, 10.3, 9.4, 8.9, 10.6, 10.5, 11.1,
		10.4, 10.7, 11.3, 10.2, 9.6, 10.2, 11.1, 10.8, 13.0, 12.5, 12.5, 11.3,
		10.1
	  ]

	}, {
	  name: 'Vik',
	  data: [
		0.2, 0.1, 0.1, 0.1, 0.3, 0.2, 0.3, 0.1, 0.7, 0.3, 0.2, 0.2,
		0.3, 0.1, 0.3, 0.4, 0.3, 0.2, 0.3, 0.2, 0.4, 0.0, 0.9, 0.3,
		0.7, 1.1, 1.8, 1.2, 1.4, 1.2, 0.9, 0.8, 0.9, 0.2, 0.4, 1.2,
		0.3, 2.3, 1.0, 0.7, 1.0, 0.8, 2.0, 1.2, 1.4, 3.7, 2.1, 2.0,
		1.5
	  ]
	}],
	navigation: {
	  menuItemStyle: {
		fontSize: '10px'
	  }
	}
  });
</script>
<script>
  Highcharts.chart('container2', {

	chart: {
	  type: 'bubble',
	  plotBorderWidth: 1,
	  zoomType: 'xy'
	},

	legend: {
	  enabled: false
	},

	title: {
	  text: 'Sugar and fat intake per country'
	},

	subtitle: {
	  text: 'Source: <a href="http://www.euromonitor.com/">Euromonitor</a> and <a href="https://data.oecd.org/">OECD</a>'
	},

	xAxis: {
	  gridLineWidth: 1,
	  title: {
		text: 'Daily fat intake'
	  },
	  labels: {
		format: '{value} gr'
	  },
	  plotLines: [{
		color: 'black',
		dashStyle: 'dot',
		width: 2,
		value: 65,
		label: {
		  rotation: 0,
		  y: 15,
		  style: {
			fontStyle: 'italic'
		  },
		  text: 'Safe fat intake 65g/day'
		},
		zIndex: 3
	  }]
	},

	yAxis: {
	  startOnTick: false,
	  endOnTick: false,
	  title: {
		text: 'Daily sugar intake'
	  },
	  labels: {
		format: '{value} gr'
	  },
	  maxPadding: 0.2,
	  plotLines: [{
		color: 'black',
		dashStyle: 'dot',
		width: 2,
		value: 50,
		label: {
		  align: 'right',
		  style: {
			fontStyle: 'italic'
		  },
		  text: 'Safe sugar intake 50g/day',
		  x: -10
		},
		zIndex: 3
	  }]
	},

	tooltip: {
	  useHTML: true,
	  headerFormat: '<table>',
	  pointFormat: '<tr><th colspan="2"><h3>{point.country}</h3></th></tr>' +
	  '<tr><th>Fat intake:</th><td>{point.x}g</td></tr>' +
	  '<tr><th>Sugar intake:</th><td>{point.y}g</td></tr>' +
	  '<tr><th>Obesity (adults):</th><td>{point.z}%</td></tr>',
	  footerFormat: '</table>',
	  followPointer: true
	},

	plotOptions: {
	  series: {
		dataLabels: {
		  enabled: true,
		  format: '{point.name}'
		}
	  }
	},

	series: [{
	  data: [
		{x: 95, y: 95, z: 13.8, name: 'BE', country: 'Belgium'},
		{x: 86.5, y: 102.9, z: 14.7, name: 'DE', country: 'Germany'},
		{x: 80.8, y: 91.5, z: 15.8, name: 'FI', country: 'Finland'},
		{x: 80.4, y: 102.5, z: 12, name: 'NL', country: 'Netherlands'},
		{x: 80.3, y: 86.1, z: 11.8, name: 'SE', country: 'Sweden'},
		{x: 78.4, y: 70.1, z: 16.6, name: 'ES', country: 'Spain'},
		{x: 74.2, y: 68.5, z: 14.5, name: 'FR', country: 'France'},
		{x: 73.5, y: 83.1, z: 10, name: 'NO', country: 'Norway'},
		{x: 71, y: 93.2, z: 24.7, name: 'UK', country: 'United Kingdom'},
		{x: 69.2, y: 57.6, z: 10.4, name: 'IT', country: 'Italy'},
		{x: 68.6, y: 20, z: 16, name: 'RU', country: 'Russia'},
		{x: 65.5, y: 126.4, z: 35.3, name: 'US', country: 'United States'},
		{x: 65.4, y: 50.8, z: 28.5, name: 'HU', country: 'Hungary'},
		{x: 63.4, y: 51.8, z: 15.4, name: 'PT', country: 'Portugal'},
		{x: 64, y: 82.9, z: 31.3, name: 'NZ', country: 'New Zealand'}
	  ]
	}]

  });
</script>
<script>
  Highcharts.chart('container3', {
	title: {
	  text: 'Combination chart'
	},
	xAxis: {
	  categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums']
	},
	labels: {
	  items: [{
		html: 'Total fruit consumption',
		style: {
		  left: '50px',
		  top: '18px',
		  color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
		}
	  }]
	},
	series: [{
	  type: 'column',
	  name: 'Jane',
	  data: [3, 2, 1, 3, 4]
	}, {
	  type: 'column',
	  name: 'John',
	  data: [2, 3, 5, 7, 6]
	}, {
	  type: 'column',
	  name: 'Joe',
	  data: [4, 3, 3, 9, 0]
	}, {
	  type: 'spline',
	  name: 'Average',
	  data: [3, 2.67, 3, 6.33, 3.33],
	  marker: {
		lineWidth: 2,
		lineColor: Highcharts.getOptions().colors[3],
		fillColor: 'white'
	  }
	}, {
	  type: 'pie',
	  name: 'Total consumption',
	  data: [{
		name: 'Jane',
		y: 13,
		color: Highcharts.getOptions().colors[0] // Jane's color
	  }, {
		name: 'John',
		y: 23,
		color: Highcharts.getOptions().colors[1] // John's color
	  }, {
		name: 'Joe',
		y: 19,
		color: Highcharts.getOptions().colors[2] // Joe's color
	  }],
	  center: [50, 40],
	  size: 50,
	  showInLegend: false,
	  dataLabels: {
		enabled: false
	  }
	}]
  });
</script>
<script>
  Highcharts.chart('container4', {

	title: {
	  text: 'Highcharts Sankey Diagram'
	},

	series: [{
	  keys: ['from', 'to', 'weight'],
	  data: [
		['Brazil', 'Portugal', 5],
		['Brazil', 'France', 1],
		['Brazil', 'Spain', 1],
		['Brazil', 'England', 1],
		['Canada', 'Portugal', 1],
		['Canada', 'France', 5],
		['Canada', 'England', 1],
		['Mexico', 'Portugal', 1],
		['Mexico', 'France', 1],
		['Mexico', 'Spain', 5],
		['Mexico', 'England', 1],
		['USA', 'Portugal', 1],
		['USA', 'France', 1],
		['USA', 'Spain', 1],
		['USA', 'England', 5],
		['Portugal', 'Angola', 2],
		['Portugal', 'Senegal', 1],
		['Portugal', 'Morocco', 1],
		['Portugal', 'South Africa', 3],
		['France', 'Angola', 1],
		['France', 'Senegal', 3],
		['France', 'Mali', 3],
		['France', 'Morocco', 3],
		['France', 'South Africa', 1],
		['Spain', 'Senegal', 1],
		['Spain', 'Morocco', 3],
		['Spain', 'South Africa', 1],
		['England', 'Angola', 1],
		['England', 'Senegal', 1],
		['England', 'Morocco', 2],
		['England', 'South Africa', 7],
		['South Africa', 'China', 5],
		['South Africa', 'India', 1],
		['South Africa', 'Japan', 3],
		['Angola', 'China', 5],
		['Angola', 'India', 1],
		['Angola', 'Japan', 3],
		['Senegal', 'China', 5],
		['Senegal', 'India', 1],
		['Senegal', 'Japan', 3],
		['Mali', 'China', 5],
		['Mali', 'India', 1],
		['Mali', 'Japan', 3],
		['Morocco', 'China', 5],
		['Morocco', 'India', 1],
		['Morocco', 'Japan', 3]
	  ],
	  type: 'sankey',
	  name: 'Sankey demo series'
	}]

  });
</script>
<script>
  $.ajax({
	url: 'https://cdn.rawgit.com/highcharts/highcharts/057b672172ccc6c08fe7dbb27fc17ebca3f5b770/samples/data/world-population-history.csv',
	success: function (csv) {

	  // Parse the CSV Data
	  /*Highcharts.data({
				csv: data,
				switchRowsAndColumns: true,
				parsed: function () {
						console.log(this.columns);
				}
		});*/

	  // Very simple and case-specific CSV string splitting
	  function CSVtoArray(text) {
		return text.replace(/^"/, '')
			.replace(/",$/, '')
			.split('","');
	  }

	  csv = csv.split(/\n/);

	  var countries = {},
		  mapChart,
		  countryChart,
		  numRegex = /^[0-9\.]+$/,
		  lastCommaRegex = /,\s$/,
		  quoteRegex = /\"/g,
		  categories = CSVtoArray(csv[2]).slice(4);

	  // Parse the CSV into arrays, one array each country
	  $.each(csv.slice(3), function (j, line) {
		var row = CSVtoArray(line),
			data = row.slice(4);

		$.each(data, function (i, val) {
		  val = val.replace(quoteRegex, '');
		  if (numRegex.test(val)) {
			val = parseInt(val, 10);
		  } else if (!val || lastCommaRegex.test(val)) {
			val = null;
		  }
		  data[i] = val;
		});

		countries[row[1]] = {
		  name: row[0],
		  code3: row[1],
		  data: data
		};
	  });

	  // For each country, use the latest value for current population
	  var data = [];
	  for (var code3 in countries) {
		if (countries.hasOwnProperty(code3)) {
		  var value = null,
			  year,
			  itemData = countries[code3].data,
			  i = itemData.length;

		  while (i--) {
			if (typeof itemData[i] === 'number') {
			  value = itemData[i];
			  year = categories[i];
			  break;
			}
		  }
		  data.push({
			name: countries[code3].name,
			code3: code3,
			value: value,
			year: year
		  });
		}
	  }

	  // Add lower case codes to the data set for inclusion in the tooltip.pointFormat
	  var mapData = Highcharts.geojson(Highcharts.maps['custom/world']);
	  $.each(mapData, function () {
		this.id = this.properties['hc-key']; // for Chart.get()
		this.flag = this.id.replace('UK', 'GB').toLowerCase();
	  });

	  // Wrap point.select to get to the total selected points
	  Highcharts.wrap(Highcharts.Point.prototype, 'select', function (proceed) {

		proceed.apply(this, Array.prototype.slice.call(arguments, 1));

		var points = mapChart.getSelectedPoints();
		if (points.length) {
		  if (points.length === 1) {
			$('#info #flag').attr('class', 'flag ' + points[0].flag);
			$('#info h2').html(points[0].name);
		  } else {
			$('#info #flag').attr('class', 'flag');
			$('#info h2').html('Comparing countries');

		  }
		  $('#info .subheader').html('<h4>Historical population</h4><small><em>Shift + Click on map to compare countries</em></small>');

		  if (!countryChart) {
			countryChart = Highcharts.chart('country-chart', {
			  chart: {
				height: 250,
				spacingLeft: 0
			  },
			  credits: {
				enabled: false
			  },
			  title: {
				text: null
			  },
			  subtitle: {
				text: null
			  },
			  xAxis: {
				tickPixelInterval: 50,
				crosshair: true
			  },
			  yAxis: {
				title: null,
				opposite: true
			  },
			  tooltip: {
				split: true
			  },
			  plotOptions: {
				series: {
				  animation: {
					duration: 500
				  },
				  marker: {
					enabled: false
				  },
				  threshold: 0,
				  pointStart: parseInt(categories[0], 10)
				}
			  }
			});
		  }

		  $.each(points, function (i) {
			// Update
			if (countryChart.series[i]) {
			  /*$.each(countries[this.code3].data, function (pointI, value) {
						countryChart.series[i].points[pointI].update(value, false);
				});*/
			  countryChart.series[i].update({
				name: this.name,
				data: countries[this.code3].data,
				type: points.length > 1 ? 'line' : 'area'
			  }, false);
			} else {
			  countryChart.addSeries({
				name: this.name,
				data: countries[this.code3].data,
				type: points.length > 1 ? 'line' : 'area'
			  }, false);
			}
		  });
		  while (countryChart.series.length > points.length) {
			countryChart.series[countryChart.series.length - 1].remove(false);
		  }
		  countryChart.redraw();

		} else {
		  $('#info #flag').attr('class', '');
		  $('#info h2').html('');
		  $('#info .subheader').html('');
		  if (countryChart) {
			countryChart = countryChart.destroy();
		  }
		}
	  });

	  // Initiate the map chart
	  mapChart = Highcharts.mapChart('container', {

		title: {
		  text: 'Population history by country'
		},

		subtitle: {
		  text: 'Source: <a href="http://data.worldbank.org/indicator/SP.POP.TOTL/countries/1W?display=default">The World Bank</a>'
		},

		mapNavigation: {
		  enabled: true,
		  buttonOptions: {
			verticalAlign: 'bottom'
		  }
		},

		colorAxis: {
		  type: 'logarithmic',
		  endOnTick: false,
		  startOnTick: false,
		  min: 50000
		},

		tooltip: {
		  footerFormat: '<span style="font-size: 10px">(Click for details)</span>'
		},

		series: [{
		  data: data,
		  mapData: mapData,
		  joinBy: ['iso-a3', 'code3'],
		  name: 'Current population',
		  allowPointSelect: true,
		  cursor: 'pointer',
		  states: {
			select: {
			  color: '#a4edba',
			  borderColor: 'black',
			  dashStyle: 'shortdot'
			}
		  }
		}]
	  });

	  // Pre-select a country
	  mapChart.get('us').select();
	}
  });

</script>
</body>
</html>