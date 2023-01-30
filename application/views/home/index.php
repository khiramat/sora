<!-- head -->
<?php
$h1 = "運用レポート ポータルサイト";
$this->load->view('common/head');
?>
<body>
<!-- header -->
<header>
	<p>Ranger Systems</p>
	<?php
	$this->load->view('common/header');
	?>
	<h1><?=$h1?></h1>
</header>
<!-- footer -->
<?php $this->load->view('common/footer'); ?>
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
		{ x: 95, y: 95, z: 13.8, name: 'BE', country: 'Belgium' },
		{ x: 86.5, y: 102.9, z: 14.7, name: 'DE', country: 'Germany' },
		{ x: 80.8, y: 91.5, z: 15.8, name: 'FI', country: 'Finland' },
		{ x: 80.4, y: 102.5, z: 12, name: 'NL', country: 'Netherlands' },
		{ x: 80.3, y: 86.1, z: 11.8, name: 'SE', country: 'Sweden' },
		{ x: 78.4, y: 70.1, z: 16.6, name: 'ES', country: 'Spain' },
		{ x: 74.2, y: 68.5, z: 14.5, name: 'FR', country: 'France' },
		{ x: 73.5, y: 83.1, z: 10, name: 'NO', country: 'Norway' },
		{ x: 71, y: 93.2, z: 24.7, name: 'UK', country: 'United Kingdom' },
		{ x: 69.2, y: 57.6, z: 10.4, name: 'IT', country: 'Italy' },
		{ x: 68.6, y: 20, z: 16, name: 'RU', country: 'Russia' },
		{ x: 65.5, y: 126.4, z: 35.3, name: 'US', country: 'United States' },
		{ x: 65.4, y: 50.8, z: 28.5, name: 'HU', country: 'Hungary' },
		{ x: 63.4, y: 51.8, z: 15.4, name: 'PT', country: 'Portugal' },
		{ x: 64, y: 82.9, z: 31.3, name: 'NZ', country: 'New Zealand' }
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
		['Brazil', 'Portugal', 5 ],
		['Brazil', 'France', 1 ],
		['Brazil', 'Spain', 1 ],
		['Brazil', 'England', 1 ],
		['Canada', 'Portugal', 1 ],
		['Canada', 'France', 5 ],
		['Canada', 'England', 1 ],
		['Mexico', 'Portugal', 1 ],
		['Mexico', 'France', 1 ],
		['Mexico', 'Spain', 5 ],
		['Mexico', 'England', 1 ],
		['USA', 'Portugal', 1 ],
		['USA', 'France', 1 ],
		['USA', 'Spain', 1 ],
		['USA', 'England', 5 ],
		['Portugal', 'Angola', 2 ],
		['Portugal', 'Senegal', 1 ],
		['Portugal', 'Morocco', 1 ],
		['Portugal', 'South Africa', 3 ],
		['France', 'Angola', 1 ],
		['France', 'Senegal', 3 ],
		['France', 'Mali', 3 ],
		['France', 'Morocco', 3 ],
		['France', 'South Africa', 1 ],
		['Spain', 'Senegal', 1 ],
		['Spain', 'Morocco', 3 ],
		['Spain', 'South Africa', 1 ],
		['England', 'Angola', 1 ],
		['England', 'Senegal', 1 ],
		['England', 'Morocco', 2 ],
		['England', 'South Africa', 7 ],
		['South Africa', 'China', 5 ],
		['South Africa', 'India', 1 ],
		['South Africa', 'Japan', 3 ],
		['Angola', 'China', 5 ],
		['Angola', 'India', 1 ],
		['Angola', 'Japan', 3 ],
		['Senegal', 'China', 5 ],
		['Senegal', 'India', 1 ],
		['Senegal', 'Japan', 3 ],
		['Mali', 'China', 5 ],
		['Mali', 'India', 1 ],
		['Mali', 'Japan', 3 ],
		['Morocco', 'China', 5 ],
		['Morocco', 'India', 1 ],
		['Morocco', 'Japan', 3 ]
	  ],
	  type: 'sankey',
	  name: 'Sankey demo series'
	}]

  });
</script>
</body>
</html>