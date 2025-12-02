let revenueChart, activityChart, categoryChart, peakHoursChart, geoChart;
window.currentPeriod = "daily";

function initializeReportsCharts(chartData, trends) {
  console.log("🚀 Initializing reports charts...", { chartData, trends });

  initializeRevenueChart(chartData);
  initializeActivityChart(chartData);
  initializeCategoryChart(trends);
  initializePeakHoursChart(trends);
  initializeGeoChart(trends);
}

function initializeRevenueChart(chartData) {
  const revenueCtx = document.getElementById("revenueChart");
  if (!revenueCtx) return;

  const totalRevenue = chartData.revenue.reduce((a, b) => a + b, 0);
  if (totalRevenue === 0) {
    revenueCtx.closest(".bg-white").innerHTML = getEmptyStateHTML(
      "pendapatan",
      "transaksi",
      "green"
    );
    return;
  }

  revenueChart = new Chart(revenueCtx, {
    type: "line",
    data: {
      labels: chartData.labels,
      datasets: [
        {
          label: "Pendapatan (Rp)",
          data: chartData.revenue,
          borderColor: "#22c55e",
          backgroundColor: "rgba(34, 197, 94, 0.1)",
          borderWidth: 3,
          tension: 0.4,
          fill: true,
        },
      ],
    },
    options: getRevenueChartOptions(),
  });
}

function initializeActivityChart(chartData) {
  const activityCtx = document.getElementById("activityChart");
  if (!activityCtx) return;

  const totalAuctions = chartData.auctions.reduce((a, b) => a + b, 0);
  const totalUsers = chartData.users.reduce((a, b) => a + b, 0);

  if (totalAuctions === 0 && totalUsers === 0) {
    activityCtx.closest(".bg-white").innerHTML = getEmptyStateHTML(
      "aktivitas",
      "pengguna/lelang baru",
      "blue"
    );
    return;
  }

  activityChart = new Chart(activityCtx, {
    type: "bar",
    data: {
      labels: chartData.labels,
      datasets: [
        {
          label: "Lelang Baru",
          data: chartData.auctions,
          backgroundColor: "#3b82f6",
          barPercentage: 0.6,
        },
        {
          label: "Pengguna Baru",
          data: chartData.users,
          backgroundColor: "#8b5cf6",
          barPercentage: 0.6,
        },
      ],
    },
    options: getActivityChartOptions(),
  });
}

function initializeCategoryChart(trends) {
  const categoryCtx = document.getElementById("categoryChart");
  if (!categoryCtx) return;

  if (!trends.categories || Object.keys(trends.categories).length === 0) {
    categoryCtx.closest(".bg-white").innerHTML = getEmptyStateHTML(
      "kategori",
      "kendaraan terdaftar",
      "purple"
    );
    return;
  }

  categoryChart = new Chart(categoryCtx, {
    type: "doughnut",
    data: {
      labels: Object.keys(trends.categories),
      datasets: [
        {
          data: Object.values(trends.categories),
          backgroundColor: [
            "#3b82f6",
            "#8b5cf6",
            "#10b981",
            "#f59e0b",
            "#ef4444",
          ],
        },
      ],
    },
    options: getCategoryChartOptions(),
  });
}

function initializePeakHoursChart(trends) {
  const peakHoursCtx = document.getElementById("peakHoursChart");
  if (!peakHoursCtx) return;

  if (!trends.peakHours || Object.keys(trends.peakHours).length === 0) {
    peakHoursCtx.closest(".bg-white").innerHTML = getEmptyStateHTML(
      "jam sibuk",
      "aktivitas lelang",
      "orange"
    );
    return;
  }

  peakHoursChart = new Chart(peakHoursCtx, {
    type: "bar",
    data: {
      labels: Object.keys(trends.peakHours).map((h) => h + ":00"),
      datasets: [
        {
          label: "Aktivitas",
          data: Object.values(trends.peakHours),
          backgroundColor: "#f59e0b",
        },
      ],
    },
    options: getPeakHoursChartOptions(),
  });
}

function initializeGeoChart(trends) {
  const geoCtx = document.getElementById("geoChart");
  if (!geoCtx) return;

  if (!trends.geo || Object.keys(trends.geo).length === 0) {
    geoCtx.closest(".bg-white").innerHTML = getEmptyStateHTML(
      "distribusi geografis",
      "pengguna terdaftar",
      "red"
    );
    return;
  }

  geoChart = new Chart(geoCtx, {
    type: "bar",
    data: {
      labels: Object.keys(trends.geo),
      datasets: [
        {
          label: "Pengguna",
          data: Object.values(trends.geo),
          backgroundColor: "#ef4444",
        },
      ],
    },
    options: getGeoChartOptions(),
  });
}

function destroyAllCharts() {
  [
    revenueChart,
    activityChart,
    categoryChart,
    peakHoursChart,
    geoChart,
  ].forEach((chart) => {
    if (chart) chart.destroy();
  });
}

function updateAllCharts(data) {
  destroyAllCharts();
  initializeReportsCharts(data, window.reportsTrendsData);
}

function updateTable(data) {
  const tableBody = document.querySelector("tbody");
  const dataCount = document.querySelector(".data-count");

  if (!tableBody || !data.labels || !data.revenue) return;

  let tableHTML = "";

  data.labels.forEach((label, index) => {
    const revenue = data.revenue[index] || 0;
    const auctions = data.auctions[index] || 0;
    const users = data.users[index] || 0;
    const transactions = data.transactions[index] || 0;
    const platform_fee = data.platform_fee[index] || 0;

    let statusClass, statusText;
    if (revenue > 100000000) {
      statusClass = "bg-green-100 text-green-800 border border-green-200";
      statusText = "Tinggi";
    } else if (revenue > 50000000) {
      statusClass = "bg-blue-100 text-blue-800 border border-blue-200";
      statusText = "Normal";
    } else {
      statusClass = "bg-yellow-100 text-yellow-800 border border-yellow-200";
      statusText = "Rendah";
    }

    tableHTML += `
            <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${label}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">${
                  revenue > 0
                    ? "Rp " + (revenue / 1000000).toFixed(0) + "Jt"
                    : '<span class="text-gray-400">-</span>'
                }</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">${auctions}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">${users}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">${transactions}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${
                  platform_fee > 0
                    ? "Rp " + (platform_fee / 1000000).toFixed(1) + "Jt"
                    : '<span class="text-gray-400">-</span>'
                }</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusClass}">${statusText}</span>
                </td>
            </tr>
        `;
  });

  tableBody.innerHTML = tableHTML;

  if (dataCount) {
    dataCount.textContent = `Menampilkan ${data.labels.length} data transaksi`;
  }
}

function exportReport(type) {
  if (type === "excel") {
    window.location.href =
      "/owner/reports/export-excel?period=" + window.currentPeriod;
  }
}

window.initializeReportsCharts = initializeReportsCharts;
window.updateAllCharts = updateAllCharts;
window.updateTable = updateTable;
window.exportReport = exportReport;
