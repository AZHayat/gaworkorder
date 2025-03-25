document.addEventListener("DOMContentLoaded", function () {
    const yearSelector = document.querySelector("#year-selector");

    function fetchDashboardData(year) {
        fetch(`/dashboard/data?year=${year}`)
            .then((response) => response.json())
            .then((data) => {
                document.querySelector(".data-total").textContent = data.total;
                document.querySelector(".data-open").textContent = data.open;
                document.querySelector(".data-close").textContent = data.close;
            })
            .catch((error) =>
                console.error("Error fetching dashboard data:", error)
            );
    }

    function fetchChartData(year) {
        fetch(`/dashboard/chart?year=${year}`)
            .then((response) => response.json())
            .then((data) => {
                let categories = [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ];
                let seriesData = [
                    {
                        name: "TOTAL",
                        data: categories.map(
                            (_, index) => data.total[index + 1] || 0
                        ),
                    },
                    {
                        name: "OPEN",
                        data: categories.map(
                            (_, index) => data.open[index + 1] || 0
                        ),
                    },
                    {
                        name: "CLOSE",
                        data: categories.map(
                            (_, index) => data.close[index + 1] || 0
                        ),
                    },
                ];

                let chartOptions = {
                    series: seriesData,
                    chart: { type: "bar", height: 250 },
                    xaxis: { categories: categories },
                    yaxis: { labels: { show: false } },
                    colors: ["#6C757D", "#FD7E14", "#28A745"], // TOTAL = Abu-Abu, OPEN = Oranye, CLOSE = Hijau
                    legend: {
                        fontSize: "16px",
                        fontWeight: "bold",
                        markers: { width: 14, height: 14 },
                    },
                    grid: { show: true },
                };

                let chartContainer = document.querySelector("#sales-chart");
                chartContainer.innerHTML = ""; // Hapus grafik lama sebelum render baru
                new ApexCharts(chartContainer, chartOptions).render();
            })
            .catch((error) =>
                console.error("Error fetching chart data:", error)
            );
    }

    function fetchBarChartData(year) {
        fetch(`/dashboard/pie-chart?year=${year}`)
            .then((response) => response.json())
            .then((data) => {
                // Daftar Departemen & Jenis Pekerjaan Default
                let allDepartments = [
                    "Engineering",
                    "CPP",
                    "Slitting",
                    "Metalize",
                    "Warehouse & PPIC",
                    "Laboratorium",
                    "Direksi",
                    "Others",
                ];
                let allJobTypes = [
                    "Maintenance Building",
                    "Project",
                    "Cleaning",
                    "Crafting",
                    "Ekspedisi",
                    "Others",
                ];

                let departmentCounts = {};
                let jobTypeCounts = {};
                let othersDept = 0;
                let othersJob = 0;

                // Set Semua Departemen & JobType ke 0 dulu
                allDepartments.forEach((dept) => (departmentCounts[dept] = 0));
                allJobTypes.forEach((job) => (jobTypeCounts[job] = 0));

                // Isi Data dari API
                Object.entries(data.departments).forEach(([key, value]) => {
                    if (allDepartments.includes(key)) {
                        departmentCounts[key] = value;
                    } else {
                        othersDept += value; // Masukkan ke "Others"
                    }
                });

                Object.entries(data.jobTypes).forEach(([key, value]) => {
                    if (allJobTypes.includes(key)) {
                        jobTypeCounts[key] = value;
                    } else {
                        othersJob += value; // Masukkan ke "Others"
                    }
                });

                // Tambahkan "Others" Jika Ada Data
                if (othersDept > 0) departmentCounts["Others"] = othersDept;
                if (othersJob > 0) jobTypeCounts["Others"] = othersJob;

                // Konversi ke Array
                let departmentNames = Object.keys(departmentCounts);
                let departmentData = Object.values(departmentCounts);
                let jobTypeNames = Object.keys(jobTypeCounts);
                let jobTypeData = Object.values(jobTypeCounts);

                let departmentChartOptions = {
                    series: [{ name: "Work Orders", data: departmentData }],
                    chart: { type: "bar", height: 300 },
                    xaxis: {
                        categories: departmentNames,
                    },
                    yaxis: { title: { text: "Jumlah Work Order" } },
                    colors: ["#007BFF"],
                    plotOptions: {
                        bar: { horizontal: false, columnWidth: "50%" },
                    },
                    dataLabels: { enabled: false },
                    legend: { position: "top" },
                };

                let jobTypeChartOptions = {
                    series: [{ name: "Work Orders", data: jobTypeData }],
                    chart: { type: "bar", height: 300 },
                    xaxis: {
                        categories: jobTypeNames,
                    },
                    yaxis: { title: { text: "Jumlah Work Order" } },
                    colors: ["#FD7E14"],
                    plotOptions: {
                        bar: { horizontal: false, columnWidth: "50%" },
                    },
                    dataLabels: { enabled: false },
                    legend: { position: "top" },
                };

                let departmentChartContainer = document.querySelector(
                    "#pie-chart-department"
                );
                let jobTypeChartContainer =
                    document.querySelector("#pie-chart-jobtype");

                departmentChartContainer.innerHTML = "";
                jobTypeChartContainer.innerHTML = "";

                new ApexCharts(
                    departmentChartContainer,
                    departmentChartOptions
                ).render();
                new ApexCharts(
                    jobTypeChartContainer,
                    jobTypeChartOptions
                ).render();
            })
            .catch((error) =>
                console.error("Error fetching bar chart data:", error)
            );
    }

    yearSelector.addEventListener("change", function () {
        let selectedYear = this.value;
        fetchDashboardData(selectedYear);
        fetchChartData(selectedYear);
        fetchBarChartData(selectedYear);
    });

    fetchDashboardData(yearSelector.value);
    fetchChartData(yearSelector.value);
    fetchBarChartData(yearSelector.value);
});
