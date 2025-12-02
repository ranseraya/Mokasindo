function getEmptyStateHTML(type, condition, color) {
  const icons = {
    green: "graph-up-arrow",
    blue: "activity",
    purple: "pie-chart",
    orange: "clock-history",
    red: "geo-alt",
  };

  const titles = {
    pendapatan: "Grafik Pendapatan",
    aktivitas: "Aktivitas Sistem",
    kategori: "Kategori Populer",
    "jam sibuk": "Jam Sibuk",
    "distribusi geografis": "Distribusi Geografis",
  };

  return `
        <div class="flex items-center mb-4">
            <i class="bi bi-${icons[color]} text-${color}-600 text-xl mr-2"></i>
            <h3 class="text-lg font-semibold text-gray-800">${titles[type]}</h3>
        </div>
        <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <div class="text-center">
                <i class="bi bi-inbox text-gray-400 text-4xl mb-2"></i>
                <p class="text-gray-500 font-medium">Belum ada data ${type}</p>
                <p class="text-gray-400 text-sm mt-1">Data akan muncul ketika ada ${condition}</p>
            </div>
        </div>
    `;
}

function getRevenueChartOptions() {
  return {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function (value) {
            if (value >= 1000000000) {
              return "Rp " + (value / 1000000000).toFixed(1) + "M";
            } else {
              return "Rp " + (value / 1000000).toFixed(0) + "Jt";
            }
          },
        },
      },
    },
  };
}

function getActivityChartOptions() {
  return {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  };
}

function getCategoryChartOptions() {
  return {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: "bottom",
      },
    },
  };
}

function getPeakHoursChartOptions() {
  return {
    responsive: true,
    maintainAspectRatio: false,
    indexAxis: "y",
  };
}

function getGeoChartOptions() {
  return {
    responsive: true,
    maintainAspectRatio: false,
    indexAxis: "y",
  };
}

function changePeriod(period) {
  console.log("Changing period to:", period);
  window.currentPeriod = period;

  updateButtonStyles(period);
  showLoadingStates();

  fetch(`/owner/reports/chart-data?period=${period}`)
    .then((res) => {
      if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
      return res.json();
    })
    .then((data) => {
      console.log("Data received for period:", period, data);
      updateAllCharts(data);
      updateTable(data);
    })
    .catch((error) => {
      console.error("Gagal memuat data:", error);
      alert("Terjadi kesalahan saat memuat data. Silakan refresh halaman.");
    });
}

function updateButtonStyles(activePeriod) {
  ["daily", "monthly"].forEach((p) => {
    const btn = document.getElementById("btn-" + p);
    if (btn) {
      if (p === activePeriod) {
        btn.className =
          "px-4 py-2 rounded-lg font-medium bg-indigo-600 text-white hover:bg-indigo-700 transition-colors";
      } else {
        btn.className =
          "px-4 py-2 rounded-lg font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors";
      }
    }
  });
}

function showLoadingStates() {
  const charts = [
    "revenueChart",
    "activityChart",
    "categoryChart",
    "peakHoursChart",
    "geoChart",
  ];
  charts.forEach((chartId) => {
    const ctx = document.getElementById(chartId);
    if (ctx) {
      ctx.innerHTML =
        '<div class="flex items-center justify-center h-full"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div></div>';
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  if (window.reportsChartData && window.reportsTrendsData) {
    initializeReportsCharts(window.reportsChartData, window.reportsTrendsData);
  }
});

window.changePeriod = changePeriod;
window.getEmptyStateHTML = getEmptyStateHTML;
window.getRevenueChartOptions = getRevenueChartOptions;
window.getActivityChartOptions = getActivityChartOptions;
window.getCategoryChartOptions = getCategoryChartOptions;
window.getPeakHoursChartOptions = getPeakHoursChartOptions;
window.getGeoChartOptions = getGeoChartOptions;
