function initializeOverviewCharts(chartData) {
  console.log("🚀 Initializing overview charts...", chartData);

  if (typeof Chart === "undefined") {
    console.error("❌ Chart.js not loaded!");
    return;
  }

  const labels = chartData.labels || [];
  const revenueData = chartData.revenue || [];
  const userData = chartData.users || [];
  const auctionData = chartData.auctions || [];

  console.log("Chart data loaded:", {
    labels,
    revenueData,
    userData,
    auctionData,
  });

  const totalRevenue =
    revenueData.length > 0 ? revenueData.reduce((a, b) => a + b, 0) : 0;
  const totalUsers =
    userData.length > 0 ? userData.reduce((a, b) => a + b, 0) : 0;
  const totalAuctions =
    auctionData.length > 0 ? auctionData.reduce((a, b) => a + b, 0) : 0;

  console.log("Data totals:", { totalRevenue, totalUsers, totalAuctions });

  const revenueCanvas = document.getElementById("revenueChart");
  if (revenueCanvas) {
    if (totalRevenue === 0) {
      console.log("No revenue data, showing empty state");
      revenueCanvas.closest(".bg-white").innerHTML = `
                <div class="flex items-center mb-4">
                    <i class="bi bi-graph-up-arrow text-green-600 text-xl mr-2"></i>
                    <h4 class="text-lg font-semibold text-gray-800">Grafik Pendapatan 7 Hari Terakhir</h4>
                </div>
                <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="text-center">
                        <i class="bi bi-inbox text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-500 font-medium">Belum ada data pendapatan</p>
                        <p class="text-gray-400 text-sm mt-1">Data akan muncul ketika ada transaksi</p>
                    </div>
                </div>
            `;
    } else {
      console.log("Creating revenue chart with data:", revenueData);
      try {
        new Chart(revenueCanvas.getContext("2d"), {
          type: "line",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Pendapatan (Rp)",
                data: revenueData,
                borderColor: "#22c55e",
                backgroundColor: "rgba(34, 197, 94, 0.1)",
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: true,
                position: "top",
              },
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  callback: function (value) {
                    return "Rp " + (value / 1000000).toFixed(0) + "Jt";
                  },
                },
              },
            },
          },
        });
        console.log("✅ Revenue chart created successfully");
      } catch (error) {
        console.error("❌ Error creating revenue chart:", error);
      }
    }
  } else {
    console.error("❌ Revenue canvas not found");
  }

  const userCanvas = document.getElementById("userChart");
  if (userCanvas) {
    if (totalUsers === 0 && totalAuctions === 0) {
      console.log("No user/auction data, showing empty state");
      userCanvas.closest(".bg-white").innerHTML = `
                <div class="flex items-center mb-4">
                    <i class="bi bi-activity text-blue-600 text-xl mr-2"></i>
                    <h4 class="text-lg font-semibold text-gray-800">Aktivitas Pengguna & Lelang</h4>
                </div>
                <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="text-center">
                        <i class="bi bi-inbox text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-500 font-medium">Belum ada data aktivitas</p>
                        <p class="text-gray-400 text-sm mt-1">Data akan muncul ketika ada pengguna/lelang baru</p>
                    </div>
                </div>
            `;
    } else {
      console.log("Creating user activity chart with data:", {
        users: userData,
        auctions: auctionData,
      });
      try {
        new Chart(userCanvas.getContext("2d"), {
          type: "bar",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Pengguna Baru",
                data: userData,
                backgroundColor: "#3b82f6",
                borderRadius: 4,
              },
              {
                label: "Lelang Baru",
                data: auctionData,
                backgroundColor: "#8b5cf6",
                borderRadius: 4,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: "top",
              },
            },
          },
        });
        console.log("✅ User activity chart created successfully");
      } catch (error) {
        console.error("❌ Error creating user activity chart:", error);
      }
    }
  } else {
    console.error("❌ User canvas not found");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM loaded, checking for chart data...");

  if (!window.overviewChartData) {
    console.error("❌ No chart data found in window.overviewChartData");
    showFallbackEmptyStates();
    return;
  }

  setTimeout(() => {
    initializeOverviewCharts(window.overviewChartData);
  }, 100);
});

function showFallbackEmptyStates() {
  console.log("Showing fallback empty states");

  const revenueContainer = document
    .querySelector("#revenueChart")
    ?.closest(".bg-white");
  if (revenueContainer) {
    revenueContainer.innerHTML = `
            <div class="flex items-center mb-4">
                <i class="bi bi-graph-up-arrow text-green-600 text-xl mr-2"></i>
                <h4 class="text-lg font-semibold text-gray-800">Grafik Pendapatan 7 Hari Terakhir</h4>
            </div>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle text-yellow-400 text-4xl mb-2"></i>
                    <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                    <p class="text-gray-400 text-sm mt-1">Refresh halaman atau coba lagi nanti</p>
                </div>
            </div>
        `;
  }

  const userContainer = document
    .querySelector("#userChart")
    ?.closest(".bg-white");
  if (userContainer) {
    userContainer.innerHTML = `
            <div class="flex items-center mb-4">
                <i class="bi bi-activity text-blue-600 text-xl mr-2"></i>
                <h4 class="text-lg font-semibold text-gray-800">Aktivitas Pengguna & Lelang</h4>
            </div>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle text-yellow-400 text-4xl mb-2"></i>
                    <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                    <p class="text-gray-400 text-sm mt-1">Refresh halaman atau coba lagi nanti</p>
                </div>
            </div>
        `;
  }
}
