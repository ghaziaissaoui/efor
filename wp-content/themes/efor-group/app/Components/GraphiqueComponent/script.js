import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';

/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Config
  • Component Class
  • Private Functions
  • Event Handlers
  • Init and Exports
*/

/*
  • Config
  ---------- ---------- ---------- ---------- ----------
*/

const SELECTORS = {};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class GraphiqueComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);

    myChart.call(this)
  }

  disconnectedCallback() {
    console.log('Disconnected:', this);
  }

  adoptedCallback() {
    console.log('Adopted:', this);
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue && oldValue !== newValue) {
      console.log('Attribute Changed:', name, oldValue, newValue);
    }
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------

*/
function myChart () {
  const years = this.dataset.years.split(',');
  const column = this.dataset.column.split(',');
  const curve = this.dataset.curve.split(',');
  const curve_colors = this.dataset.curve_colors.split(',');
  const tooltip_label = this.dataset.tooltip_label;
  const y_right_axis_label = this.dataset.y_right_axis_label;
  const y_left_axis_label = this.dataset.y_left_axis_label;
  const footer = (tooltipItems) => {
    let evol = 0;
    tooltipItems.forEach(function (tooltipItem, index, arr) {
      if (tooltipItem.dataset.type == 'bar' && tooltipItem.dataIndex > 0) {
        const prev = arr[1].dataset.data[tooltipItem.dataIndex - 1];
        const current = arr[1].dataset.data[tooltipItem.dataIndex];
        evol = Math.trunc((current - prev) / prev * 100)
      }
    });

    if (tooltip_label) {
      return tooltip_label + ' : ' + evol + '%';
    } else {
      return '';
    }
  };

  const mdBreakpoint = window.matchMedia('(max-width: 560px)');

  let data = {
    labels: years,
    datasets: [{
      type: 'bar',
      label: y_right_axis_label,
      data: column,
      yAxisID: 'right-y-axis',
      backgroundColor: curve_colors,
      position: 'top',
      hoverBorderColor: '#ffffff47',
      color: '#ffffff',
      borderSkipped: 'false',
      borderWidth: 2,
      borderRadius: {topLeft: 60, topRight: 10},
      minBarLength: 50,
      barIndicator: -30,
      barThickness: 60
    }, {
      type: 'line',
      label: y_left_axis_label,
      data: curve,
      borderWidth: 1,
      yAxisID: 'left-y-axis',
      borderColor: '#C9A778',
      backgroundColor: '#C9A778',
      pointBackgroundColor: '#C9A778',
      pointRadius: 5,
      color: '#C9A778',
      barIndicator: 10,
      tension: 0.1
    }]
  }

  if (mdBreakpoint.matches) {
    data = {
      labels: years,
      datasets: [{
        type: 'bar',
        label: y_right_axis_label,
        data: column,
        yAxisID: 'right-y-axis',
        backgroundColor: curve_colors,
        position: 'top',
        hoverBorderColor: '#ffffff47',
        color: '#ffffff',
        borderSkipped: 'false',
        borderWidth: 2,
        borderRadius: {topLeft: 60, topRight: 10},
        minBarLength: 20,
        barIndicator: -30,
      }, {
        type: 'line',
        label: y_left_axis_label,
        data: curve,
        borderWidth: 1,
        yAxisID: 'left-y-axis',
        borderColor: '#C9A778',
        backgroundColor: '#C9A778',
        pointBackgroundColor: '#C9A778',
        pointRadius: 5,
        color: '#C9A778',
        barIndicator: 10,
        tension: 0.1
      }]
    }
  }


  let ctx = document.getElementById('myChart').getContext('2d');
  if (mdBreakpoint.matches) {
    new Chart(ctx, {
      data: data,
      options: {
        responsive: false,
        aspectRatio: 1, // mobile
        interaction: {
          intersect: false,
          mode: 'index',
          axis: 'x'
        },
        plugins: {
          tooltip: {
            enabled: false,
          },
          legend: {
            title: {
              display: false,
              text: 'Legend Title',
              align: 'start',
            },
            labels: {
              textAlign: 'left', //mobile,
            }
          }
        },
        scales: {
          'x': {
            grid: {
              display: false
            },
            ticks: {
              font: {
                family: 'Sometimes-Times',
                size: 14, //desktop
              },
            },
          },
          'left-y-axis': {
            display: false,
            type: 'linear',
            position: 'right',
            grid: {
              display: true
            },
            ticks: {
              beginAtZero: true
            }
          },
          'right-y-axis': {
            display: false,
            type: 'linear',
            position: 'right',
            grid: {
              display: false
            },
            ticks: {
              font: {
                family: 'General-Sans',
                size: 14,
              },
            },
          }
        },
        animation: {
          'onProgress': labelsOnColumn,
          'onComplete': labelsOnColumn
        }
      }
    });
  } else {
    new Chart(ctx, {
      data: data,
      options: {
        layout: {
          padding: {top: 100},
        },
        responsive: false,
        interaction: {
          intersect: false,
          mode: 'index',
          axis: 'x'
        },
        plugins: {
          tooltip: {
            callbacks: {
              footer: footer,
            }
          },
          legend: {
            title: {
              display: false,
              text: 'Legend Title',
              align: 'start',
            },
          }
        },
        scales: {
          'x': {
            grid: {
              display: false
            },
            ticks: {
              font: {
                family: 'Sometimes-Times',
                size: 24, //desktop
              },
            },
          },
          'left-y-axis': {
            display: false,
            type: 'linear',
            position: 'right',
            grid: {
              display: true
            },
            ticks: {
              beginAtZero: true
            }
          },
          'right-y-axis': {
            display: false,
            type: 'linear',
            position: 'right',
            grid: {
              display: false
            },
            ticks: {
              font: {
                family: 'General-Sans',
                size: 14,
              },
            },
          }
        },
        animation: {
          'onProgress': labelsOnColumn,
          'onComplete': labelsOnColumn
        }
      }
    });
  }



  function labelsOnColumn (e) {
    const ctx = e.chart.ctx;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'bottom';

    this.data.datasets.forEach(function (dataset, i) {
      let meta = e.chart.getDatasetMeta(i);
      meta.data.forEach(function (bar, index) {
        ctx.fillStyle = meta._dataset.color;
        let data = dataset.data[index];
        if (meta.type == 'line') {
          ctx.fillText(data, bar.x, bar.y - meta._dataset.barIndicator);

        } else {
          ctx.fillText(data, bar.x, bar.y - 27); //desktop
        }
      });
    });
  }
}
/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('graphique-component', GraphiqueComponent);

export default GraphiqueComponent;
