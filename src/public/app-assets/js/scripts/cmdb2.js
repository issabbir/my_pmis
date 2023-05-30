(function($){
    $(document).ready(function () {

        var Interval = 100000;
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'BDT'
        });


        function runEmpDetail() {
            $.ajax({
                url: "/cdb/employee-details",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {

                    var employeeDetailsCtx = document.getElementById("employee-details").getContext("2d");

                    var employee_details_data = {
                        labels: ["Late Present", "On Leave", "Training", "Tour"],
                        datasets: [{
                            label: "Officer",
                            backgroundColor: "#5A8DEE",
                            data: [
                                dataResult[0].length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                dataResult[1].length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                dataResult[2].length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                dataResult[3].length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0
                            ]
                        }, {
                            label: "Staff",
                            backgroundColor: "#4BC0C0",
                            data: [
                                dataResult[0].length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                dataResult[1].length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                dataResult[2].length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                dataResult[3].length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0
                            ]
                        }]
                    };
                    var myoption = {
                        tooltips: {
                            enabled: true
                        },
                        hover: {
                            animationDuration: 1
                        },
                        onClick : function(evt, i) {
                            if(i.length > 0){
                                var activePoint = employeeDetailsBarChart.getElementAtEvent(evt)[0];
                                var data = activePoint._chart.data;
                                var datasetIndex = activePoint._datasetIndex;
                                var label = data.datasets[datasetIndex].label;
                                var value = data.datasets[datasetIndex].data[activePoint._index];
                                e = i[0];
                                var x_value = this.data.labels[e._index];
                                window.pop_show(`/cdb/department-wise-employee-count/${x_value}/${label}`)
                            }

                        },
                        animation: {
                            duration: 1,
                            onComplete: function () {
                                var chartInstance = this.chart,
                                    ctx = chartInstance.ctx;
                                ctx.textAlign = 'center';
                                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                                ctx.textBaseline = 'bottom';
                                // Loop through each data in the datasets
                                this.data.datasets.forEach(function (dataset, i) {
                                    var meta = chartInstance.controller.getDatasetMeta(i);
                                    meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                    });
                                });
                            }
                        }
                    };

                    var employeeDetailsBarChart = new Chart(employeeDetailsCtx, {
                        type: 'bar',
                        data: employee_details_data,
                        options: myoption
                    });
                }
            });
        }
        runEmpDetail();
        window.setInterval(runEmpDetail, Interval);

        function maleRatio() {
            $.ajax({
                url: "/cdb/gender-wise-officer-staff",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            data: [dataResult.gender_employee.male.officer, dataResult.gender_employee.male.staff],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ],
                            label: 'My First Dataset'
                        }]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";
                                        var name = ['Officer', 'Staff'];
                                        if (val != 0) {
                                            ctx.fillText(name[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Male - ' + Number(((100 * (Number(dataResult.gender_employee.male.officer) +
                                Number(dataResult.gender_employee.male.staff))) / Number(dataResult.total.total))).toFixed(2) + "%"
                        }
                    };


                    var ctx = $('#male-gender-ratio');
                    var maleOfficerStaffPie = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        maleRatio();
        window.setInterval(maleRatio, Interval);

       /* function othersStaffRatio() {
            $.ajax({
                url: "/cdb/gender-wise-officer-staff",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            data: [dataResult.gender_employee.others.officer, dataResult.gender_employee.others.staff],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ],
                            label: 'My First Dataset'
                        }],
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";
                                        var name = ['Officer', 'Staff'];
                                        if (val != 0) {
                                            ctx.fillText(name[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Others - ' + Number((Number(Number(dataResult.total.total) - ((Number(dataResult.gender_employee.male.officer) +
                                Number(dataResult.gender_employee.male.staff)) + (Number(dataResult.gender_employee.female.officer) +
                                Number(dataResult.gender_employee.female.staff)))) * 100) / Number(dataResult.total.total)).toFixed(2) + "%"
                        }
                    };


                    var ctx = $('#others-gender-ratio');
                    var othersOfficerStaffPie = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        othersStaffRatio();
        window.setInterval(othersStaffRatio, Interval);*/

        function runGenderRatio() {
            $.ajax({
                url: "/cdb/gender-wise-officer-staff",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            data: [dataResult.gender_employee.female.officer, dataResult.gender_employee.female.staff],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ]
                        }]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";
                                        var name = ['Officer', 'Staff'];
                                        if (val != 0) {
                                            ctx.fillText(name[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Female - ' + Number(((100 * (Number(dataResult.gender_employee.female.officer) + Number(dataResult.gender_employee.female.staff))) / Number(dataResult.total.total))).toFixed(2) + "%"
                        }
                    };


                    var ctx = $('#female-gender-ratio');
                    var femaleOfficerStaffPie = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        runGenderRatio();
        window.setInterval(runGenderRatio, Interval);

        function runAuthPosition() {
            $.ajax({
                url: "/cdb/authorized-positions",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            data: [dataResult[0].total_working, dataResult[0].vacant],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            'Total Working',
                            'Vacant'
                        ]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Authorized Position'
                        }
                    };


                    var ctx = $('#authorized-position');
                    var trainingPie = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        runAuthPosition();
        window.setInterval(runAuthPosition, Interval);

        function runAccounts() {
            $.ajax({
                url: "/cdb/accounts",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var data = '';

                    $.each(dataResult,function(index,row){
                        $("#income_label").html(row.income_account_label);
                        $("#income_value").html(Number(row.income_account_balance).toFixed(2));
                        $("#expense_label").html(row.expense_account_label);
                        $("#expense_value").html(Number(row.expense_account_balance).toFixed(2));
                        $("#liabilities_label").html(row.libility_account_label);
                        $("#liabilities_value").html(Number(row.liability_account_balance).toFixed(2));
                        $("#assets_label").html(row.asset_account_label);
                        $("#assets_value").html(Number(row.asset_account_balance).toFixed(2));
                    })

                }
            });
        }
        runAccounts();
        window.setInterval(runAccounts, Interval);

        function runVesselHandled() {
            $.ajax({
                url: "/cdb/vessel-handled",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var resultData = dataResult;
                    var rowData = '';
                    var labelData = "<tr><th>#</th><th>" + resultData.columns[0] + "</th><th>" + resultData.columns[1] + "</th><th>" + resultData.columns[2] + "</th><th>" + resultData.columns[3] + "</th></tr>";
                    rowData += "<tr>"
                    rowData += "<td>Vessel Handled</td><td>" + resultData.data[resultData.columns[0]] + "</td><td>" + resultData.data[resultData.columns[1]] + "</td><td>" + resultData.data[resultData.columns[2]] + "</td><td>" + resultData.data[resultData.columns[3]] + "</td>";
                    rowData += "</tr>";
                    $("#vessel_handled_data").html(rowData);
                    $("#vessel_handled_label").html(labelData);
                    var container_percent = Number(dataResult.container_cargo[1].container) == 0 ? 100: ((Number(dataResult.container_cargo[0].container) - Number(dataResult.container_cargo[1].container)) / Number(dataResult.container_cargo[1].container)) * 100
                    var cargo_percent = Number(dataResult.container_cargo[1].cargo) == 0 ? 100: ((Number(dataResult.container_cargo[0].cargo) - Number(dataResult.container_cargo[1].cargo)) / Number(dataResult.container_cargo[1].cargo)) * 100

                    var container_cargo_label = ''
                    container_cargo_label+="<tr>"
                    container_cargo_label+="<td>#</td>" +
                        "<td>"+dataResult.container_cargo[1].months+"</td>" +
                        "<td>"+dataResult.container_cargo[0].months+"</td>" +
                        "<td>CHANGE</td>"
                    container_cargo_label+="</tr>";
                    $("#container_cargo_monthly_compare_label").html(container_cargo_label);

                    var container_cargo_data = ''
                    container_cargo_data+="<tr>"
                    container_cargo_data+="<td>No. of Container Handle</td>" +
                        "<td>"+dataResult.container_cargo[1].container+"</td>" +
                        "<td>"+dataResult.container_cargo[0].container+"</td>" +
                        "<td>"+container_percent+"%</td>"
                    container_cargo_data+="</tr>";
                    container_cargo_data+="<tr>"
                    container_cargo_data+="<td>No. of Cargo Handle</td>" +
                        "<td>"+dataResult.container_cargo[1].cargo+"</td>" +
                        "<td>"+dataResult.container_cargo[0].cargo+"</td>" +
                        "<td>"+cargo_percent+"%</td>"
                    container_cargo_data+="</tr>";
                    $("#container_cargo_monthly_compare_data").html(container_cargo_data);



                    var ctx = document.getElementById('VesselHandlingChart');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: resultData.labels,
                            datasets: [{
                                label: 'Vessel Handle',
                                data: resultData.value,
                                backgroundColor: [
                                    '#ff5b5c8a'
                                ],
                                borderColor: [
                                    '#5A8DEE'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        min: 0
                                    }
                                }]
                            }
                        }
                    });


                    var container_cargo_ctx = document.getElementById('CargoContainerChart');
                    var container_cargo_chart = new Chart(container_cargo_ctx, {
                        type: 'line',
                        data: {
                            labels: [dataResult.container_cargo[1].months, dataResult.container_cargo[0].months],
                            datasets: [{
                                label: 'Container Handle '+container_percent+'%',
                                data: [dataResult.container_cargo[1].container, dataResult.container_cargo[0].container],
                                backgroundColor: [

                'rgba(54, 162, 235, 0.2)'/*,
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'*/
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 0.2)'/*,
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'*/
                                ],
                                borderWidth: 1
                            },
                                {
                                    label: 'Cargo Handle '+cargo_percent+'%',
                                    data: [dataResult.container_cargo[1].cargo, dataResult.container_cargo[0].cargo],
                                    backgroundColor: [
                                        '#ff5b5c8a'/*,
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'*/
                                    ],
                                    borderColor: [
                                        '#ff5b5c8a'/*,
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'*/
                                    ],
                                    borderWidth: 1
                                }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                }
            });
        }
        runVesselHandled();
        window.setInterval(runVesselHandled, Interval);



        function runSalaries() {
            $.ajax({
                url: "/cdb/salaries",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var resultData = dataResult.salaries;
                    var rowData = '';

                    var first_month = resultData.columns[0]
                    var second_month = resultData.columns[1]

                    var salary_icon = resultData.data.salary[resultData.columns[1]] - resultData.data.salary[resultData.columns[0]] > 0 ?
                        "bx-trending-up text-success":
                        (resultData.data.salary[resultData.columns[1]] - resultData.data.salary[resultData.columns[0]] < 0 ?
                                "bx-trending-down text-primary ":
                                "bx-move-horizontal text-primary"
                        )
                    var salary_first_month = resultData.data.salary[resultData.columns[0] + "-format"]
                    var salary_second_month = resultData.data.salary[resultData.columns[1] + "-format"]
                    var salary_change = resultData.data.salary[resultData.columns[1]] - resultData.data.salary[resultData.columns[0]] > 0 ?
                        (((resultData.data.salary[resultData.columns[1]] - resultData.data.salary[resultData.columns[0]]) * 100) / resultData.data.salary[resultData.columns[0]]).toFixed(2):
                        (resultData.data.salary[resultData.columns[1]] - resultData.data.salary[resultData.columns[0]] == 0 ? 0:
                                Number(((resultData.data.salary[resultData.columns[1]] - resultData.data.salary[resultData.columns[0]]) * 100) / resultData.data.salary[resultData.columns[0]]).toFixed(2)
                        )

                    var pf_first_month = resultData.data.pf[resultData.columns[0] + "-format"]
                    var pf_second_month = resultData.data.pf[resultData.columns[1] + "-format"]
                    var pf_change = resultData.data.pf[resultData.columns[1]] - resultData.data.pf[resultData.columns[0]] > 0 ?
                        (((resultData.data.pf[resultData.columns[1]] - resultData.data.pf[resultData.columns[0]]) * 100) / resultData.data.pf[resultData.columns[0]]).toFixed(2):
                        (resultData.data.pf[resultData.columns[1]] - resultData.data.pf[resultData.columns[0]] == 0 ? 0:
                                Number(((resultData.data.pf[resultData.columns[1]] - resultData.data.pf[resultData.columns[0]]) * 100) / resultData.data.pf[resultData.columns[0]]).toFixed(2)
                        )

                    var ot_first_month = resultData.data.ot[resultData.columns[0] + "-format"]
                    var ot_second_month = resultData.data.ot[resultData.columns[1] + "-format"]
                    ot_second_month = typeof(ot_second_month) != "undefined" ? ot_second_month : 0
                    var ot_change = resultData.data.ot[resultData.columns[1]] - resultData.data.ot[resultData.columns[0]] > 0 ?
                        (((resultData.data.ot[resultData.columns[1]] - resultData.data.ot[resultData.columns[0]]) * 100) / resultData.data.ot[resultData.columns[0]]).toFixed(2):
                        (resultData.data.ot[resultData.columns[1]] - resultData.data.ot[resultData.columns[0]] == 0 ? 0:
                                Number(((typeof(resultData.data.ot[resultData.columns[1]]) != "undefined"? resultData.data.ot[resultData.columns[1]]:0 - typeof(resultData.data.ot[resultData.columns[0]])!="undefined"?resultData.data.ot[resultData.columns[0]]:0) * 100) / typeof(resultData.data.ot[resultData.columns[0]]) != "undefined" ? resultData.data.ot[resultData.columns[0]]:0).toFixed(2)
                        )


                    var labelData = "<tr><th>Name</th><th class=\"text-right\">" + first_month + "</th><th class=\"text-right\">" + second_month + "</th><th class=\"text-right\">Change</th></tr>";

                    rowData += "<tr>"
                    rowData += "<td>Salary</td>" +
                        "<td class=\"text-right\">" + salary_first_month + "</td>" +
                        "<td class=\"text-right\">" + salary_second_month + "</td>" +
                        "<td class='text-right'><i class='bx text-success align-middle mr-50'></i><span>" + salary_change + "%</span></td>";
                    rowData += "</tr>";

                    rowData += "<tr>"
                    rowData += "<td>Provident Fund</td>" +
                        "<td class=\"text-right\">" + pf_first_month + "</td>" +
                        "<td class=\"text-right\">" + pf_second_month + "</td>" +
                        "<td class='text-right'><i class=\"bx text-success align-middle mr-50\"></i><span>" + pf_change + "%</span></td>";
                    rowData += "</tr>";


                    rowData += "<tr>"
                    rowData += "<td>Over Time</td>" +
                        "<td class=\"text-right\">" + ot_first_month + "</td>" +
                        "<td class=\"text-right\">" + Number(ot_second_month).toFixed(2) + "</td>" +
                        "<td class='text-right'><i class=\"bx text-success align-middle mr-50\"></i><span>" + ot_change + "%</span></td>";
                    rowData += "</tr>";


                    $("#salaries_data").html(rowData);
                    $("#salaries_label").html(labelData);
                }
            });
        }
        runSalaries();
        window.setInterval(runSalaries, Interval);

        function runAssets() {
            $.ajax({
                url: "/cdb/assets",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var resultData = dataResult;
                    var rowData = '';
                    $.each(resultData, function (index, row) {
                        rowData += "<tr>"
                        rowData += "<td>" + row.fy_year + "</td><td class=\"text-right\">" + row.fixed_asset_format + "</td>";
                        rowData += "</tr>";
                        rowData += "<tr><td colspan='2'>";
                        var liData = '<ul>'
                        $.each(row.heads, function (i, item) {
                            liData += "<li><div class='float-left'>"+item.asset_group_name+"</div><div class='text-right'>"+item.amount+"</div></li>"
                        })
                        liData += "</ul>"

                        rowData += liData;
                        rowData += "</td></tr>"
                    })
                    $("#assets_data").html(rowData);
                }
            });
        }
        runAssets();
        window.setInterval(runAssets, Interval);

        function runAudit() {
            $.ajax({
                url: "/cdb/audits",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    var resultDataInternal = dataResult.internal;
                    var resultDataGov = dataResult.gov;
                    var internalData = '';
                    var govData = '';
                    $.each(resultDataInternal,function(index,row){
                        internalData+="<tr>"
                        internalData+="<td>"+row.year+"</td><td>"+row.in_progress+"</td><td>"+row.completed+"</td>"
                            +"<td class=\"bg-success bg-light\">"+row.total+"</td>";
                        internalData+="</tr>";

                    })
                    $("#internal_data").html(internalData);


                    $.each(resultDataGov,function(index,row){
                        govData+="<tr>"
                        govData+="<td>"+row.year+"</td>" +
                            "<td><a href='javascript:void(0)' data-status='1' data-year="+row.year+" class='audit-second-level' >"+row.audit_entry+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='2' data-year="+row.year+"  class='audit-second-level' >"+row.submitted_for_initial_approval+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='3' data-year="+row.year+"  class='audit-second-level' >"+row.initially_approved+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='4' data-year="+row.year+"  class='audit-second-level' >"+row.initially_rejected+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='14' data-year="+row.year+"  class='audit-second-level' >"+row.findings_entry+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='11' data-year="+row.year+"  class='audit-second-level' >"+row.submitted_for_findings_appr+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='12' data-year="+row.year+"  class='audit-second-level' >"+row.findings_approved+"</a></td>" +
                            "<td><a href='javascript:void(0)' data-status='13' data-year="+row.year+"  class='audit-second-level' >"+row.findings_rejected+"</a></td>" +
                            "<td class=\"bg-success bg-light\">"+row.total+"</td>";
                        govData+="</tr>";

                    })
                    $("#gov_data").html(govData);
                }
            });
        }
        runAudit();
        window.setInterval(runAudit, Interval);

        function runTraining() {
            $.ajax({
                url: "/cdb/trainings",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var rowData = '';
                    var labelData =
                        "<tr><th>Type Name</th><th class=\"text-right\">Total Training</th></tr>";
                    $.each(dataResult.trainings, function (index, row) {
                        rowData += "<tr>"
                        rowData +=
                            "<td>"+
                            row.type_name+"</td><td class=\"text-right\"> <a data-type='"+row.training_type_id+"' class='training_second_level' href='#'>" +
                            row.total_training + "</a></td>";
                        rowData += "</tr>";
                    })
                    $("#trainings_label").html(labelData);
                    $("#trainings_data").html(rowData);
                }
            });
        }
        runTraining();
        window.setInterval(runTraining,Interval);

        function runHydro() {
            $.ajax({
                url: "/cdb/hydrography",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    let resultData = dataResult.survey_data;
                    let schedule_data = dataResult.schedule_data;
                    let rowData = '';
                    let rowDatas = '';
                    let total = 0;
                    $.each(resultData, function (index, row) {
                        rowData += "<tr>"
                        rowData += "<td>" + row.survey_chart + "</td><td class=\"text-right\">" + row.quantity + "</td><td class=\"text-right\">" + row.sales_amount_format + "</td>";
                        rowData += "</tr>";
                        total += Number(row.sales_amount);
                    })
                    $("#hydrography_data").html(rowData);
                    $("#total").html(formatter.format(total))

                    $.each(schedule_data, function (index, row) {
                        rowDatas += "<tr>"
                        rowDatas += "<td>" + row.total_schedule + "</td><td class=\"text-right\">" + row.approved + "</td><td class=\"text-right\">" + row.not_approved + "</td>";
                        rowDatas += "</tr>";
                    })
                    $("#hydrography_schedule_data").html(rowDatas);
                }
            });
        }
        runHydro();
        window.setInterval(runHydro, Interval);

        function runIncidents() {
            $.ajax({
                url: "/cdb/incidents",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var data = '';

                    $.each(dataResult,function(index,row){
                        var subtype = row.incidence_subtype_name == null?'': row.incidence_subtype_name
                        data+="<tr>"
                        data+="<td>"+row.incidence_time+"</td>" +
                            "<td>"+row.incidence_number+"</td>" +
                            "<td>"+row.incidence_place+"</td>" +
                            "<td>"+row.incidence_type+"</td>" +
                            "<td>"+subtype+"</td>" +
                            "<td>"+row.incidence_status+"</td>";
                        data+="</tr>";

                    })
                    $("#incident_data").html(data);
                }
            });
        }
        runIncidents();
        window.setInterval(runIncidents, Interval);

        function runEquipments() {
            $.ajax({
                url: "/cdb/equipments",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var equipmentData = '';

                    $.each(dataResult,function(index,row){
                        equipmentData+="<tr>"
                        equipmentData+="<td class=\"text-center\">"+row.total_equipment+"</td>"+
                            "<td class=\"text-center\"><i class=\"bx bxs-circle success font-small-1 mr-50\"></i><span>"+row.servicing_equip+"</span></td>" +
                            "<td class=\"text-center\"><i class=\"bx bxs-circle primary font-small-1 mr-50\"></i><span>"+row.working_equip+"</span></td>";
                        equipmentData+="</tr>";

                    })
                    $("#equipment_data").html(equipmentData);
                }
            });
        }
        runEquipments();
        window.setInterval(runEquipments, Interval);

        function runVehicles() {
            $.ajax({
                url: "/cdb/vehicles",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var data = '';

                    $.each(dataResult,function(index,row){
                        var operating = row.operating == null? 0: row.operating
                        var out_of_order = row.out_of_order == null ? 0 : row.out_of_order
                        var repairing_servicing = row.repairing_servicing == null ? 0 : row.repairing_servicing
                        var total = Number(operating) + Number(out_of_order) + Number(repairing_servicing)
                        data+="<tr>"
                        data+="<td class=\"text-center\">"+operating+"</td>" +
                            "<td class=\"text-center\"><a href='javascript:void(0)' data-status='3' class='vehicle-second-level' >"+out_of_order+"</a></td>" +
                            "<td class=\"text-center\"><a href='javascript:void(0)' data-status='2' class='vehicle-second-level' >"+repairing_servicing+"</a></td>" +
                            "<td class=\"text-center\">"+total+"</td>";
                        data+="</tr>";
                    })
                    $("#vehicle_data").html(data);
                }
            });
        }
        runVehicles();
        window.setInterval(runVehicles, Interval);

        function runVesselBill() {
            $.ajax({
                url: "/cdb/vesselbills",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var data = '';

                    $.each(dataResult,function(index,row){
                        data+="<tr>"
                        data+="<td>"+row.bill_from_date+"</td>" +
                            "<td>"+row.bill_to_date+"</td>" +
                            "<td class=\"text-right\">"+row.paid_amount+"</td>" +
                            "<td class=\"text-right\">"+row.total_bill_amount+"</td>";
                        data+="</tr>";

                    })
                    $("#vessel_bill_data").html(data);
                }
            });
        }
        runVesselBill();
        window.setInterval(runVesselBill, Interval);

        function run_appointment(){
            $.ajax({
                url: "/cdb/appointment",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(data){
                    $('#div_appointment').html(data.html);
                }
            });
        }
        run_appointment();
        window.setInterval(run_appointment, Interval);

        function runBackupData() {
            $.ajax({
                url: "/cdb/backup-data",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var data = '';

                    $.each(dataResult,function(index,row){
                        var status = row.sucessful_yn == 'Y'?'Successful': 'Unsuccessful'
                        data+="<tr>"
                        data+="<td>DB Backup</td>" +
                            "<td>"+row.backup_sart_time+"</td>" +
                            "<td>"+row.backup_end_time+"</td>" +
                            "<td>"+status+"</td>";
                        data+="</tr>";

                    })
                    $("#backup_data").html(data);
                }
            });
        }
        runBackupData();
        window.setInterval(runBackupData, Interval);

        function run_board_decision(){
            $.ajax({
                url: "/cdb/board_decision",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(data){
                    $('#div_board_decision').html(data.html);
                }
            });
        }
        run_board_decision();
        window.setInterval(run_board_decision, Interval);

        function runOnestop() {
            $.ajax({
                url: "/cdb/one-stop",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    let todayLcl = dataResult.data.todayLcl;
                    let todayFcl = dataResult.data.todayFcl;
                    let deliveryLcl = dataResult.data.deliveryLcl;
                    let deliveryFcl = dataResult.data.deliveryFcl;
                    let containerLclHandled = dataResult.data.containerLclHandled;
                    let containerFclHandled = dataResult.data.containerFclHandled;
                    if (todayLcl){
                        var dataTodayLcl = '';
                        dataTodayLcl+="<td>"+todayLcl.fcl_lcl+" BILL </td>" +
                            "<td><a class='containerDetails' href='/cdb/container_details/LCL'>"+todayLcl.no_of_container+"</a></td>" +
                            "<td class=\"text-right\">"+todayLcl.no_of_bill+"</td>" +
                            "<td class=\"text-right\">"+todayLcl.bill_amount+"</td>" +
                            "<td class=\"text-right\">"+todayLcl.no_of_paid_bill+"</td>" +
                            "<td class=\"text-right\">"+todayLcl.paid_amount+"</td>";
                        $(".dataTodayLcl").html(dataTodayLcl);
                    }
                    if (todayFcl){
                        var dataTodayFcl = '';
                        dataTodayFcl+="<tr>"
                        dataTodayFcl+="<td>"+todayLcl.fcl_lcl+" Bill </td>" +
                            "<td><a class='containerDetails' href='/cdb/container_details/FCL'>"+todayLcl.no_of_container+"</a></td>" +
                            "<td class=\"text-right\">"+todayLcl.no_of_bill+"</td>" +
                            "<td class=\"text-right\">"+todayLcl.bill_amount+"</td>" +
                            "<td class=\"text-right\">"+todayLcl.no_of_paid_bill+"</td>" +
                            "<td class=\"text-right\">"+todayLcl.paid_amount+"</td>";
                        dataTodayFcl+="</tr>";
                        $(".dataTodayFcl").html(dataTodayFcl);
                    }
                    var resultData = dataResult;
                    var rowData = '';
                    var labelData =
                        "<tr><th>#</th><th>" + containerLclHandled.labels[0] + "</th><th>" + containerLclHandled.labels[1] + "</th><th>" + containerLclHandled.labels[2] + "</th><th>" + containerLclHandled.labels[3] + "</th><th>" + containerLclHandled.labels[4] + "</th><th>" + containerLclHandled.labels[5] + "</th><th>" + containerLclHandled.labels[6] + "</th></tr>";
                    rowData += "<tr>"
                    rowData += "<td>LCL</td><td>" + containerLclHandled.value[0] + "</td><td>" + containerLclHandled.value[1] + "</td><td>" + containerLclHandled.value[2] + "</td><td>" + containerLclHandled.value[3] + "</td><td>" + containerLclHandled.value[4] + "</td><td>" + containerLclHandled.value[5] + "</td><td>" + containerLclHandled.value[6] + "</td>";
                    rowData += "</tr>"
                    rowData += "<tr>"
                    rowData += "<td>FCL</td><td>" + containerFclHandled.value[0] + "</td><td>" + containerFclHandled.value[1] + "</td><td>" + containerFclHandled.value[2] + "</td><td>" + containerFclHandled.value[3] + "</td><td>" + containerFclHandled.value[4] + "</td><td>" + containerFclHandled.value[5] + "</td><td>" + containerFclHandled.value[6] + "</td>";
                    rowData += "</tr>";
                    $("#container_handled_data").html(rowData);
                    $("#container_handled_label").html(labelData);

                    var ctx = document.getElementById("SevenDaysCollection").getContext("2d");

                    var seven_days_data = {
                        labels: containerLclHandled.labels,
                        datasets: [{
                            label: "FCL",
                            backgroundColor: "#5A8DEE",
                            data: containerFclHandled.value
                        }, {
                            label: "LCL",
                            backgroundColor: "#4BC0C0",
                            data: containerLclHandled.value
                        }]
                    };

                    var myoption = {
                        tooltips: {
                            enabled: true
                        },
                        hover: {
                            animationDuration: 1
                        },
                        onClick : function(evt, i) {
                            if(i.length > 0){
                                var activePoint = onestopDetailsBarChart.getElementAtEvent(evt)[0];
                                var data = activePoint._chart.data;
                                var datasetIndex = activePoint._datasetIndex;
                                var label = data.datasets[datasetIndex].label;
                                var value = data.datasets[datasetIndex].data[activePoint._index];
                                e = i[0];
                                var x_value = this.data.labels[e._index];
                                window.pop_show(`/cdb/handaling_details/${x_value}/${label}`)
                            }

                        },
                        animation: {
                            duration: 1,
                            onComplete: function () {
                                var chartInstance = this.chart,
                                    ctx = chartInstance.ctx;
                                ctx.textAlign = 'center';
                                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                                ctx.textBaseline = 'bottom';
                                // Loop through each data in the datasets
                                this.data.datasets.forEach(function (dataset, i) {
                                    var meta = chartInstance.controller.getDatasetMeta(i);
                                    meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                    });
                                });
                            }
                        }
                    };

                    var onestopDetailsBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: seven_days_data,
                        options: myoption
                    });

                    if (deliveryLcl){
                        var dataDeliveryLcl = '';
                        dataDeliveryLcl+="<td>LCL</td>" +
                            "<td>"+deliveryLcl.cart_ticket_issued+"</td>" +
                            "<td>"+deliveryLcl.gate_pass_issued+"</td>" +
                            "<td>"+deliveryLcl.gate_pass_used+"</td>";
                        $(".dataDeliveryLcl").html(dataDeliveryLcl);
                    }
                    if (deliveryFcl){
                        var dataDeliveryFcl = '';
                        dataDeliveryFcl+="<tr>"
                        dataDeliveryFcl+="<td>FCL</td>" +
                            "<td>"+deliveryFcl.cart_ticket_issued+" </td>" +
                            "<td>"+deliveryFcl.gate_pass_issued+"</td>" +
                            "<td>"+deliveryFcl.gate_pass_used+"</td>";
                        dataTodayFcl+="</tr>";
                        $(".dataDeliveryFcl").html(dataDeliveryFcl);
                    }
                }
            });
        }
        runOnestop();
        window.setInterval(runOnestop, Interval);

        function runBudgetPosition() {
            $.ajax({
                url: "/cdb/budget-position",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var rowData = '';
                    var labelData = "<tr><th class='text-center'>Head Name</th><th class=\"text-center\">"+dataResult.header.next_fy_proposed_budget_header+"</th><th class=\"text-center\">"+dataResult.header.curr_fy_revised_budget_header+"</th><th class=\"text-center\">"+dataResult.header.curr_fy_estd_budget_header+"</th><th class=\"text-center\">"+dataResult.header.last_fy_prov_budget_header+"</th></tr>";
                    $.each(dataResult.data, function (index, row) {
                        rowData += "<tr>"
                        rowData +=
                            "<td>"+
                            row.budget_head_name+"</td><td class=\"text-right\">" +
                            row.next_fy_proposed_budget_amount+ "</td><td class=\"text-right\">" +
                            row.curr_fy_revised_budget_amount+ "</td><td class=\"text-right\">" +
                            row.curr_fy_estd_budget_amount + "</td><td class=\"text-right\">" +
                            row.last_fy_prov_budget_amount + "</td>";
                        rowData += "</tr>";
                    })
                    $("#budget_position_header").html(labelData);
                    $("#budget_position_data").html(rowData);
                }
            });
        }
        runBudgetPosition();
        window.setInterval(runBudgetPosition, Interval);

       /* function runSalaryGraph() {
            $.ajax({
                url: "/cdb/salary-graph",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {

                    var salaryCtx = document.getElementById("salary-graph").getContext("2d");

                    var salary_data = {
                        labels: ["Salary", "Provident Fund", "Overtime"],
                        datasets: [{
                            label: "Officer",
                            backgroundColor: "#5A8DEE",
                            data: [
                                dataResult[0].length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                dataResult[1].length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                dataResult[2].length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0
                            ]
                        }, {
                            label: "Staff",
                            backgroundColor: "#4BC0C0",
                            data: [
                                dataResult[0].length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                dataResult[1].length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                dataResult[2].length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0
                            ]
                        }]
                    };

                    var myoption = {
                        tooltips: {
                            enabled: true
                        },
                        hover: {
                            animationDuration: 1
                        },
                        animation: {
                            duration: 1,
                            onComplete: function () {
                                var chartInstance = this.chart,
                                    ctx = chartInstance.ctx;
                                ctx.textAlign = 'center';
                                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                                ctx.textBaseline = 'bottom';
                                // Loop through each data in the datasets
                                this.data.datasets.forEach(function (dataset, i) {
                                    var meta = chartInstance.controller.getDatasetMeta(i);
                                    meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                    });
                                });
                            }
                        }
                    };

                    var salaryBarChart = new Chart(salaryCtx, {
                        type: 'bar',
                        data: salary_data,
                        options: myoption
                    });
                }
            });
        }
        runSalaryGraph();
        window.setInterval(runSalaryGraph, Interval);*/


        function runFRAndAP() {
            $.ajax({
                url: "/cdb/ar_ap",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    $(document).find("#fas_ar").html(dataResult.fas_ar);
                    $(document).find("#fas_ap").html(dataResult.fas_ap);
                }
            });
        }
        runFRAndAP();
        window.setInterval(runFRAndAP, Interval);

        function runMarineDailyPilotageService() {
            $.ajax({
                url: "/cdb/marine-daily/pilotage-service",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    // console.log(dataResult,'here data')
                    var pilotageDetailsCtx = document.getElementById("daily-pilotage-service").getContext("2d");
                    var data = {
                        datasets: [{
                            // data: [0, 0,1],
                            data: [dataResult.inward_vessel, dataResult.outward_vessel,dataResult.shifting_vessel],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB",
                                "#ede7e9",
                                "#36c7eb"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            'Inward Vessel',
                            'Outward Vessel',
                            'Shifting Vessel',
                        ]
                    };

                    var pieOptions = {
                        // events: false,
                        // tooltips: {
                        //     enabled: true
                        // },
                        onClick : function(evt, i) {
                            if(i.length > 0){
                                var activePoint = pie_data.getElementAtEvent(evt)[0];
                                var data = activePoint._chart.data;
                                var datasetIndex = activePoint._datasetIndex;
                                var label = data.datasets[datasetIndex].label;
                                var value = data.datasets[datasetIndex].data[activePoint._index];
                                e = i[0];
                                var x_value = this.data.labels[e._index];
                                window.pop_show(`/cdb/marian-daily-details/${x_value}`)
                            }

                        },
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';


                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }

                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Daily Pilotage Service'
                        }
                    };


                    //var ctx = $('#daily-pilotage-service');
                    var pie_data = new Chart(pilotageDetailsCtx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                        plugins: [{
                        afterDraw: function(chart) {
                            let dataChart = chart.data.datasets[0].data.filter(val => val !== "0");
                            if (dataChart.length === 0) {
                                // No data is present
                                const ctx = chart.canvas.getContext('2d');
                                // var ctx = chart.chart.ctx;
                                var width = chart.chart.width;
                                var height = chart.chart.height;
                                let radius = 10;
                                chart.clear();

                                ctx.save();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.font = "25px normal 'Helvetica Nueue'";

                                // chart.options.title.text <=== gets title from chart
                                // width / 2 <=== centers title on canvas
                                // 18 <=== aligns text 18 pixels from top, just like Chart.js
                                ctx.fillText('Daily Pilotage Service', width / 2, 30); // <====   ADDS TITLE

                                ctx.font = "30px Verdana";
                                // ctx.fillRect(0, 0,width,height);
                                // Fill with gradient
                                ctx.lineWidth = 2;
                                ctx.beginPath();
                                ctx.strokeStyle = '#283593';
                                ctx.fillStyle = '#eee';
                                ctx.arc(400, 210, 150, 0, 5 * Math.PI);
                                ctx.stroke();
                                ctx.fill();

                                ctx.lineDashOffset = 1;
                               // ctx.strokeRect(200, 100, width/2, height/2);
                                ctx.strokeText('No data to found', width / 2, height / 2, 140);

                                ctx.restore();
                            }
                        }
                        }]
                    });

                }
            });
        }
        runMarineDailyPilotageService();
        window.setInterval(runMarineDailyPilotageService, Interval);

        function runMarineMonthlyPilotageService() {
            $.ajax({
                url: "/cdb/marine-monthly/pilotage-service",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            // data: [0, 0,1],
                            data: [dataResult.inward_vessel, dataResult.outward_vessel,dataResult.shifting_vessel],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB",
                                "#ede7e9",
                                "#36c7eb"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            'Inward Vessel',
                            'Outward Vessel',
                            'Shifting Vessel',
                        ]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }

                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Monthly Pilotage Service'
                        }
                    };


                    var ctx = $('#monthly-pilotage-service');
                    var data = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        runMarineMonthlyPilotageService();
        window.setInterval(runMarineMonthlyPilotageService, Interval);


        function runMarineMonthlyPilotageServiceLineChart() {
            $.ajax({
                url: "/cdb/marine-monthly/pilotage-service/line-chart",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var ctx = document.getElementById("monthly-pilotage-service-line-chart").getContext('2d');
                    let label_data=[];
                    let inward_data=[];
                    let shifting_data=[];
                    let outward_data=[];
                    for (var i=1;i<=dataResult.cur_mon_last_day;i++){
                        label_data.push(i);
                    }
                    for (var i=0;i<=dataResult.inward_data.length;i++){
                        inward_data.push(dataResult.inward_data[i]);
                    }
                    for (var i=0;i<=dataResult.outward_data.length;i++){
                        outward_data.push(dataResult.outward_data[i]);
                    }
                    for (var i=0;i<=dataResult.shifting_data.length;i++){
                        shifting_data.push(dataResult.shifting_data[i]);
                    }
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: label_data,
                            datasets: [
                                {
                                    label: 'Inward', // Name the series
                                    // data: [0,5,3,1,	8,	10,	1,12,5, 7], // Specify the data values array
                                    data: inward_data, // Specify the data values array
                                    fill: false,
                                    borderColor: '#2196f3', // Add custom color border (Line)
                                    backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                                    borderWidth: 1 // Specify bar border width
                                },
                                {
                                    label: 'Outward', // Name the series
                                    // data: [10,5,3,9,	28,	5,	11,4,5, 7], // Specify the data values array
                                    data: outward_data, // Specify the data values array
                                    fill: false,
                                    borderColor: '#f32121', // Add custom color border (Line)
                                    backgroundColor: '#f32152', // Add custom color background (Points and Fill)
                                    borderWidth: 1 // Specify bar border width
                                },
                                {
                                    label: 'Shifting', // Name the series
                                    // data: [5,4,7,8,9,5,	1,11,7, 7], // Specify the data values array
                                    data: shifting_data, // Specify the data values array
                                    fill: false,
                                    borderColor: '#f3c521', // Add custom color border (Line)
                                    backgroundColor: '#f3b821', // Add custom color background (Points and Fill)
                                    borderWidth: 1 // Specify bar border width
                                }
                            ]},
                        options: {
                            responsive: true, // Instruct chart js to respond nicely.
                            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
                            title: {
                                display: true,
                                text: 'Monthly Pilotage Service'
                            }
                        }
                    });
                }
            });
        }
        runMarineMonthlyPilotageServiceLineChart();
        window.setInterval(runMarineMonthlyPilotageServiceLineChart, Interval);

        /*function runMarineDailyMooringService() {
            $.ajax({
                url: "/cdb/marine-daily/mooring-service",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            data: [dataResult[0].tug, dataResult[0].boat,dataResult[0].container],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB",
                                "#ede7e9",
                                "#36c7eb"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            'Tug',
                            'Boat',
                            'Container',
                        ]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Daily Mooring Service'
                        }
                    };


                    var ctx = $('#daily-mooring-service');
                    var trainingPie = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        runMarineDailyMooringService();
        window.setInterval(runMarineDailyMooringService, Interval);*/

        function runMarineMonthlyMooringService() {
            $.ajax({
                url: "/cdb/marine-monthly/mooring-service",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var ctx = document.getElementById("monthly-mooring-service").getContext('2d');
                    let label_data=[];
                    let collection_date=[];
                    let total_amount=[];
                    for (var i=1;i<=dataResult.cur_mon_last_day;i++){
                        label_data.push(i);
                    }
                    for (var i=0;i<=dataResult.collection_date.length;i++){
                        collection_date.push(dataResult.collection_date[i]);
                    }
                    for (var i=0;i<=dataResult.total_amount.length;i++){
                        total_amount.push(dataResult.total_amount[i]?dataResult.total_amount[i]:0);
                    }
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: label_data,
                            datasets: [
                               /* {
                                    label: 'Outward', // Name the series
                                    // data: [10,5,3,9,	28,	5,	11,4,5, 7], // Specify the data values array
                                    data: collection_date, // Specify the data values array
                                    fill: false,
                                    borderColor: '#f32121', // Add custom color border (Line)
                                    backgroundColor: '#f32152', // Add custom color background (Points and Fill)
                                    borderWidth: 1 // Specify bar border width
                                },*/
                                {
                                    label: 'Total Amount', // Name the series
                                    // data: [10,5,3,9,	28,	5,	11,4,5, 7], // Specify the data values array
                                    data: total_amount, // Specify the data values array
                                    fill: false,
                                    borderColor: '#f32121', // Add custom color border (Line)
                                    backgroundColor: '#f32152', // Add custom color background (Points and Fill)
                                    borderWidth: 1 // Specify bar border width
                                },
                            ]},
                        options: {
                            responsive: true, // Instruct chart js to respond nicely.
                            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
                            title: {
                                display: true,
                                text: 'Monthly Mooring Service'
                            }
                        }
                    });
                }
            });
        }
        runMarineMonthlyMooringService();
        window.setInterval(runMarineMonthlyMooringService, Interval);


        /*function runMarineMonthlyMooringService() {
            $.ajax({
                url: "/cdb/marine-monthly/mooring-service",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    var data = {
                        datasets: [{
                            data: [dataResult[0].tug, dataResult[0].boat,dataResult[0].container],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB",
                                "#ede7e9",
                                "#36c7eb"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            'Tug',
                            'Boat',
                            'Container',
                        ]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Monthly Mooring Service'
                        }
                    };


                    var ctx = $('#monthly-mooring-service');
                    var trainingPie = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: pieOptions,
                    });
                }
            });
        }
        runMarineMonthlyMooringService();
        window.setInterval(runMarineMonthlyMooringService, Interval);*/

        function runMarineDailyDuesCollection() {
            $.ajax({
                url: "/cdb/marine-daily/dues-collection",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {

                    var dataCtx = document.getElementById("daily-dues-collection").getContext("2d");
                    let label_data=[];
                    let license_bill=[];
                    let other_dues=[];
                    let river_dues=[];
                    for (var i=0;i<dataResult.lc_office.length;i++){
                        label_data.push(dataResult.lc_office[i]);
                    }
                    for (var i=0;i<dataResult.license_bill.length;i++){
                        license_bill.push(dataResult.license_bill[i]);
                    }
                    for (var i=0;i<dataResult.other_dues.length;i++){
                        other_dues.push(dataResult.other_dues[i]);
                    }
                    for (var i=0;i<dataResult.river_dues.length;i++){
                        river_dues.push(dataResult.river_dues[i]);
                    }
                    var data = {
                        labels: label_data,
                        datasets: [{
                            label: "River Dues",
                            backgroundColor: "#5A8DEE",
                            data: river_dues
                        },
                            {
                                label: "License Fees",
                                backgroundColor: "#4BC0C0",
                                data: license_bill
                            },
                            {
                                label: "Other Dues",
                                backgroundColor: "#c0ad4b",
                                data: other_dues
                            }
                        ]
                    };

                    var myoption = {
                        tooltips: {
                            enabled: true
                        },
                        hover: {
                            animationDuration: 1
                        },
                        onClick: function(c,i) {
                            e = i[0];
                            console.log(e._index)
                            var x_value = this.data.labels[e._index];
                            var y_value = this.data.datasets[0].data[e._index];
                        },
                        animation: {
                            duration: 1,
                            onComplete: function () {
                                var chartInstance = this.chart,
                                    ctx = chartInstance.ctx;
                                ctx.textAlign = 'center';
                                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                                ctx.textBaseline = 'bottom';
                                // Loop through each data in the datasets
                                this.data.datasets.forEach(function (dataset, i) {
                                    var meta = chartInstance.controller.getDatasetMeta(i);
                                    meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                    });
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Daily Dues Collection'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };
                    Chart.Legend.prototype.afterFit = function() {
                        this.height = this.height + 25;
                    };
                    var employeeDetailsBarChart = new Chart(dataCtx, {
                        type: 'bar',
                        data: data,
                        options: myoption
                    });
                }
            });
        }
        runMarineDailyDuesCollection();
        window.setInterval(runMarineDailyDuesCollection, Interval);





        function runMarineMonthlyDuesCollection() {
            $.ajax({
                url: "/cdb/marine-monthly/dues-collection",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) {

                    var dataCtx = document.getElementById("monthly-dues-collection").getContext("2d");
                    let label_data=[];
                    let license_bill=[];
                    let other_dues=[];
                    let river_dues=[];
                    for (var i=0;i<dataResult.lc_office.length;i++){
                        label_data.push(dataResult.lc_office[i]);
                    }
                    for (var i=0;i<dataResult.license_bill.length;i++){
                        license_bill.push(dataResult.license_bill[i]);
                    }
                    for (var i=0;i<dataResult.other_dues.length;i++){
                        other_dues.push(dataResult.other_dues[i]);
                    }
                    for (var i=0;i<dataResult.river_dues.length;i++){
                        river_dues.push(dataResult.river_dues[i]);
                    }
                    var data = {
                        labels: label_data,
                        datasets: [{
                            label: "River Dues",
                            backgroundColor: "#5A8DEE",
                            data: river_dues
                        },
                        {
                            label: "License Fees",
                            backgroundColor: "#4BC0C0",
                            data: license_bill
                        },
                        {
                            label: "Other Dues",
                            backgroundColor: "#c0ad4b",
                            data: other_dues
                        }
                        ]
                    };

                    var myoption = {
                        tooltips: {
                            enabled: true
                        },
                        hover: {
                            animationDuration: 1
                        },
                        onClick: function(c,i) {
                            e = i[0];
                            console.log(e._index)
                            var x_value = this.data.labels[e._index];
                            var y_value = this.data.datasets[0].data[e._index];
                        },
                        animation: {
                            duration: 1,
                            onComplete: function () {
                                var chartInstance = this.chart,
                                    ctx = chartInstance.ctx;
                                ctx.textAlign = 'center';
                                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                                ctx.textBaseline = 'bottom';
                                // Loop through each data in the datasets
                                this.data.datasets.forEach(function (dataset, i) {
                                    var meta = chartInstance.controller.getDatasetMeta(i);
                                    meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                    });
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Monthly Dues Collection'
                        }
                    };

                    var employeeDetailsBarChart = new Chart(dataCtx, {
                        type: 'bar',
                        data: data,
                        options: myoption
                    });
                }
            });
        }
        runMarineMonthlyDuesCollection();
        window.setInterval(runMarineMonthlyDuesCollection, Interval);

        function runMarineDailyFreshWater() {
            $.ajax({
                url: "/cdb/marine-daily/fresh-water",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    dataResult;
                    var data = '';

                    $.each(dataResult,function(index,row){
                        data+="<tr>"
                        data+="<td>"+dataResult[index].vessel_name+"</td>" +
                            "<td>"+dataResult[index].total_qty+"</td>" +
                            "<td>"+dataResult[index].water_vessel+"</td>";
                        data+="</tr>";

                    })
                    $("#daily-fresh-water").html(data);
                }
            });
        }
        runMarineDailyFreshWater();
        window.setInterval(runMarineDailyFreshWater, Interval);

        function runMarineMonthlyFreshWater() {
            $.ajax({
                url: "/cdb/marine-monthly/fresh-water",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    var data = '';
                    $.each(dataResult,function(index,row){
                        data+="<tr>"
                        data+="<td>"+dataResult[index].vessel_name+"</td>" +
                            "<td>"+dataResult[index].total_qty+"</td>" +
                            "<td>"+dataResult[index].water_vessel+"</td>";
                        data+="</tr>";

                    })
                    $("#monthly-fresh-water").html(data);
                }
            });
        }
        runMarineMonthlyFreshWater();
        window.setInterval(runMarineMonthlyFreshWater, Interval);

        function runVehicleParticulars() {
            $.ajax({
                url: "/cdb/vehicle-particulars",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    if(typeof(dataResult.capacity) != "undefined"){
                        var data = '';
                        data+="<tr>"
                        data+="<td class='text-center'>"+dataResult.capacity+"</td>" +
                            "<td class='text-center'>"+dataResult.delivery_qty+"</td>" +
                            "<td class='text-center'>"+dataResult.auc_lying+"</td>" +
                            "<td class='text-center'>"+dataResult.total_lying+"</td>";
                        data+="</tr>";
                        $("#vehicle_particulars").html(data);
                    }

                }
            });
        }
        runVehicleParticulars();
        window.setInterval(runVehicleParticulars, Interval);


        function runContainerLyingPosition() {
            $.ajax({
                url: "/cdb/container-lying-position",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult){
                    console.log(dataResult[1].date_on)

                    var label = ''
                    label+="<tr>"
                    label+="<th class='text-center' rowspan='2'>CONT.CAPACITY (IN TEUS)</th>" +
                        "<th colspan='2' class='text-center'>LYING ON</th>"+
                        "<th colspan='2' class='text-center'>CONTAINER DELIVERY</th>";
                    label+="</tr>";
                    label+="<tr>"
                    label+="<td class='text-center text-white' style='background-color: #5A8DEE'>"+new Date(dataResult[1].date_on).toLocaleDateString()+"</td>" +
                        "<td class='text-center text-white' style='background-color: #4BC0C0'>"+new Date(dataResult[0].date_on).toLocaleDateString()+"</td>"+
                        "<td class='text-center text-white' style='background-color: #5A8DEE'>"+new Date(dataResult[1].date_on).toLocaleDateString()+"</td>" +
                        "<td class='text-center text-white' style='background-color: #4BC0C0'>"+new Date(dataResult[0].date_on).toLocaleDateString()+"</td>";
                    label+="</tr>";
                    $("#container_lying_position_label").html(label);

                    var data = '';
                    data+="<tr>"
                    data+="<td class='text-center'>"+dataResult[0].capacity+"</td>" +
                    "<td class='text-center'><a data-date='"+dataResult[1].date_on+"' class='has-second-level-lying' href='#'>"+dataResult[1].lying_on_qty+"</a></td>" +
                    "<td class='text-center'><a data-date='"+dataResult[0].date_on+"' class='has-second-level-lying' href='#'>"+dataResult[0].lying_on_qty+"</a></td>"+
                    "<td class='text-center'>"+dataResult[1].delivery_qty+"</td>" +
                    "<td class='text-center'>"+dataResult[0].delivery_qty+"</td>";
                    data+="</tr>";
                    $("#container_lying_position").html(data);

                    var container_lying_position_pie_data = {
                        datasets: [{
                            data: [dataResult[1].lying_on_qty, dataResult[0].lying_on_qty],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            new Date(dataResult[1].date_on).toLocaleDateString(), new Date(dataResult[0].date_on).toLocaleDateString()
                        ]
                    };

                    var pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Container Lying On'
                        }
                    };


                    var ctx = $('#container_lying_position_canvas');
                    var container_lying_position_pie = new Chart(ctx, {
                        type: 'pie',
                        data: container_lying_position_pie_data,
                        options: pieOptions,
                    });

                    /*var twenty_label = ''
                    twenty_label+="<tr>"
                    twenty_label+= "<td>LAST 24 HOURS</td>" +
                        "<td class='text-center text-white' style='background-color: #5A8DEE'>"+new Date(dataResult[1].date_on).toLocaleDateString()+"</td>" +
                        "<td class='text-center text-white' style='background-color: #4BC0C0'>"+new Date(dataResult[0].date_on).toLocaleDateString()+"</td>";
                    twenty_label+="</tr>";
                    $("#twenty_four_hours_label").html(twenty_label);

                    var twenty_data = '';
                    twenty_data+="<tr>"
                    twenty_data+="<td>Container Delivery</td>" +
                        "<td class='text-center'>"+dataResult[1].delivery_qty+"</td>" +
                        "<td class='text-center'>"+dataResult[0].delivery_qty+"</td>";
                    twenty_data+="</tr>";
                    $("#twenty_four_hours_data").html(twenty_data);*/


                    var twenty_four_hours_pie_data = {
                        datasets: [{
                            data: [dataResult[1].delivery_qty, dataResult[0].delivery_qty],
                            backgroundColor: [
                                "#5A8DEE",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ],
                            label: 'My First Dataset'
                        }],
                        labels: [
                            new Date(dataResult[1].date_on).toLocaleDateString(), new Date(dataResult[0].date_on).toLocaleDateString()
                        ]
                    };

                    var twenty_four_hours_pieOptions = {
                        events: false,
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'bottom';

                                this.data.datasets.forEach(function (dataset) {

                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                            start_angle = model.startAngle,
                                            end_angle = model.endAngle,
                                            mid_angle = start_angle + (end_angle - start_angle) / 2;

                                        var x = mid_radius * Math.cos(mid_angle);
                                        var y = mid_radius * Math.sin(mid_angle);

                                        ctx.fillStyle = '#000';
                                        if (i == 3) { // Darker text color for lighter background
                                            ctx.fillStyle = '#444';
                                        }

                                        var val = dataset.data[i];
                                        var percent = String(Math.round(val / total * 100)) + "%";

                                        if (val != 0) {
                                            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                            // Display percent in another line, line break doesn't work for fillText
                                            ctx.fillText(percent, model.x + x, model.y + y + 15);
                                        }
                                    }
                                });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Container Delivery'
                        }
                    };


                    var ctx = $('#twenty_four_hours_canvas');
                    var twenty_four_hours_pie = new Chart(ctx, {
                        type: 'pie',
                        data: twenty_four_hours_pie_data,
                        options: twenty_four_hours_pieOptions,
                    });

                }
            });
        }
        runContainerLyingPosition();
        window.setInterval(runContainerLyingPosition, Interval);


        $(document).on('click', '.has-second-level', function(e) {
            e.preventDefault();
            var status = $(this).data('status');
            pop_show('/cdb/house-allot-pop-data/'+status);
        });

        $(document).on('click', '.has-second-level-lying', function(e) {
            e.preventDefault();
            var date = $(this).data('date');
            pop_show('/cdb/lying-details-pop-data/'+date);
        });
        $(document).on('click', '.training_second_level', function(e) {
            e.preventDefault();
            var type = $(this).data('type');
            pop_show('/cdb/training-details-pop-data/'+type);
        });
    });


})(jQuery);


