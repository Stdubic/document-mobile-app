const CHARTS_API_BASE = location.protocol + '//' + location.hostname + '/api/charts/';

function updateGraphs() {
	const data = {
		year: document.getElementById('graph_year').value,
		month: document.getElementById('graph_month').value,
		day: document.getElementById('graph_day').value
	};

	updateGraphUsersCount(data);
}

function updateGraphUsersCount(data) {
	var time_order = 'month';

	if (data.day != '%') time_order = 'hour';
	else if (data.month != '%') time_order = 'day';

	const graphOptions = {
		graph_area_id: 'graph-user-count',
		titles: ['Users'],
		time_order: time_order
	};

	new ApiHandler().call(CHARTS_API_BASE + 'user-count', data, plotLineChart, graphOptions);
}

function plotLineChart(data, graphOptions) {
	var graph = jQuery('#' + graphOptions.graph_area_id);
	if (!data.length) {
		graph[0].innerHTML = '<p><mark>No data.</mark></p>';
		return;
	}

	const opacities = [0.7, 0.5];
	var i,
		j,
		valueSum,
		minX = 1,
		maxX = 12,
		maxCount = 0;

	if (graphOptions.time_order == 'hour') {
		minX = 0;
		maxX = 24;
	} else if (graphOptions.time_order == 'day') maxX = 31;

	if (graphOptions.titles.length == 1) data = [data];

	for (j = 0; j < graphOptions.titles.length; j++) {
		valueSum = 0;

		for (i = 0; i < data[j].length; i++) {
			valueSum += data[j][i].value;
			if (data[j][i].value > maxCount) maxCount = data[j][i].value;

			data[j][i] = [data[j][i][graphOptions.time_order], data[j][i].value];
		}

		data[j] = {
			label: graphOptions.titles[j].trim() + ' (' + valueSum + ')',
			data: data[j],
			lines: {
				show: true,
				fill: true,
				fillColor: {
					colors: [{ opacity: opacities[j] }, { opacity: opacities[j] }]
				}
			},
			points: {
				show: true,
				radius: 4
			}
		};
	}

	$.plot(graph, data, {
		xaxis: {
			min: minX,
			max: maxX,
			tickSize: 1,
			tickDecimals: 0
		},
		yaxis: {
			min: 0,
			max: Math.ceil(maxCount * 1.1),
			tickSize: Math.ceil(maxCount / 10),
			tickDecimals: 0
		},
		colors: ['#abe37d', '#faad7d'],
		grid: {
			borderWidth: 1,
			hoverable: true
		}
	});

	createTooltips(graph);
}

function plotBarChart(data, graphOptions) {
	var graph = jQuery('#' + graphOptions.graph_area_id);
	if (!data.length) {
		graph[0].innerHTML = '<p><mark>No data.</mark></p>';
		return;
	}

	var i,
		maxCount = 0,
		series = (labels = []);

	for (i = 0; i < data.length; i++) {
		series[series.length] = {
			label: data[i].label + ' (' + data[i].value + ')',
			data: [[i, data[i].value]],
			bars: {
				show: true,
				barWidth: data.length / 4,
				lineWidth: 0,
				align: 'center',
				fillColor: {
					colors: [{ opacity: 0.7 }, { opacity: 0.7 }]
				}
			}
		};

		labels[labels.length] = [i, data[i].label];
		if (data[i].value > maxCount) maxCount = data[i].value;
	}

	jQuery.plot(graph, series, {
		legend: {
			show: true
		},
		grid: {
			borderWidth: 1,
			hoverable: true
		},
		yaxis: {
			min: 0,
			max: Math.ceil(maxCount * 1.1),
			tickSize: Math.ceil(maxCount / 10),
			tickDecimals: 0,
			tickColor: '#f5f5f5'
		},
		xaxis: {
			ticks: labels,
			tickColor: '#f5f5f5'
		}
	});

	createTooltips(graph);
}

function plotPieChart(data, graphOptions) {
	var graph = jQuery('#' + graphOptions.graph_area_id);
	if (!data.length) {
		graph[0].innerHTML = '<p><mark>No data.</mark></p>';
		return;
	}

	$.plot(graph, data, {
		legend: { show: true },
		series: {
			pie: {
				show: true,
				radius: 1,
				label: {
					show: true,
					radius: 2 / 3,
					formatter: (label, pieSeries) => {
						return (
							'<div class="flot-pie-label">' +
							label +
							'<br>' +
							Math.round(pieSeries.percent) +
							'%</div>'
						);
					},
					background: {
						opacity: 0.7,
						color: '#000000'
					}
				}
			}
		}
	});
}

function createTooltips(graph) {
	graph.bind('plothover', (event, pos, item) => {
		jQuery('.js-flot-tooltip').remove();
		if (!item) return;

		const ttlabel = '<strong>' + item.datapoint[1] + '</strong>';
		jQuery('<div class="js-flot-tooltip flot-tooltip" align="center">' + ttlabel + '</div>')
			.css({ top: item.pageY - 45, left: item.pageX + 5 })
			.appendTo('body')
			.show();
	});
}
