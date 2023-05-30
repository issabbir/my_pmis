(function($){
   $(document).ready(function () {
       var Interval = 100000;
       Chart.Legend.prototype.afterFit = function() {
           this.height = this.height + 25;
       };
       function runVesselHistory() {
           $.ajax({
               url: "/cdb/vessel-history",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function (dataResult) {
                   var dataCtx = document.getElementById("workable-vessel-history").getContext("2d");
                   var nonWorkableDataCtx = document.getElementById("non-workable-vessel-history").getContext("2d");
                   let label_data = []
                   let oa_work = []
                   let oa_not_work = []
                   let berth_work = []
                   let berth_not_work = []
                   let jetty_work = []
                   let jetty_not_work = []

                   let non_label_data = []
                   let non_oa_not_work = []
                   let non_berth_not_work = []
                   let non_jetty_not_work = []

                   var data = ''
                   var workable_oa_work_total = 0
                   var workable_oa_not_work_total = 0
                   var workable_spl_berth_work_total = 0
                   var workable_spl_berth_not_work_total = 0
                   var workable_jetty_work_total = 0
                   var workable_jetty_not_work_total = 0
                   var title = dataResult.workable.length>0?dataResult.workable[0].updated_at:''
                   $("#vessel_history_title").html('Commodity Wise Vessels Particulars in Port - '+ title );
                   $.each(dataResult.workable,function(index,row){
                       label_data.push(row.name)
                       oa_work.push(row.oa_work)
                       oa_not_work.push(row.oa_not_work)
                       berth_work.push(row.spl_berth_work)
                       berth_not_work.push(row.spl_berth_not_work)
                       jetty_work.push(row.jetty_work)
                       jetty_not_work.push(row.jetty_not_work)

                       workable_oa_work_total = workable_oa_work_total + Number(row.oa_work)
                       workable_oa_not_work_total = workable_oa_not_work_total + Number(row.oa_not_work)
                       workable_spl_berth_work_total = workable_spl_berth_work_total + Number(row.spl_berth_work)
                       workable_spl_berth_not_work_total = workable_spl_berth_not_work_total + Number(row.spl_berth_not_work)
                       workable_jetty_work_total = workable_jetty_work_total + Number(row.jetty_work)
                       workable_jetty_not_work_total = workable_jetty_not_work_total + Number(row.jetty_not_work)
                       data+="<tr>"
                       data+="<td>"+row.name+"</td>" +
                           "<td class='text-center'>"+row.oa_work+"</td>" +
                           "<td class='text-center'>"+row.oa_not_work+"</td>" +
                           "<td class='text-center bg-success text-white'>"+Number(Number(row.oa_work)+Number(row.oa_not_work))+"</td>" +
                           "<td class='text-center'>"+row.spl_berth_work+"</td>" +
                           "<td class='text-center'>"+row.spl_berth_not_work+"</td>" +
                           "<td class='text-center bg-success text-white'>"+Number(Number(row.spl_berth_work)+Number(row.spl_berth_not_work))+"</td>" +
                           "<td class='text-center'>"+row.jetty_work+"</td>" +
                           "<td class='text-center'>"+row.jetty_not_work+"</td>" +
                           "<td class='text-center bg-success text-white'>"+Number(Number(row.jetty_work)+Number(row.jetty_not_work))+"</td>"+
                           "<td class='text-center'>"+Number(Number(row.oa_work)+Number(row.oa_not_work)+Number(row.spl_berth_work)+Number(row.spl_berth_not_work)+Number(row.jetty_work)+Number(row.jetty_not_work))+"</td>";
                       data+="</tr>";

                   })
                   data+="<tr>"
                   data+="<td class='text-center bg-success text-white'>WORKABLE VESSEL</td>" +
                       "<td class='text-center bg-success text-white'>"+workable_oa_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+workable_oa_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+Number(workable_oa_work_total+workable_oa_not_work_total)+"</td>" +
                       "<td class='text-center bg-success text-white'>"+workable_spl_berth_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+workable_spl_berth_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+Number(workable_spl_berth_work_total+workable_spl_berth_not_work_total)+"</td>" +
                       "<td class='text-center bg-success text-white'>"+workable_jetty_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+workable_jetty_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+Number(workable_jetty_work_total+workable_jetty_not_work_total)+"</td>"+
                       "<td class='text-center bg-success text-white'>"+Number(workable_oa_work_total+workable_oa_not_work_total+workable_spl_berth_work_total+workable_spl_berth_not_work_total+workable_jetty_work_total+workable_jetty_not_work_total)+"</td>";
                   data+="</tr>";
                   var non_workable_oa_not_work_total = 0
                   var non_workable_spl_berth_not_work_total = 0
                   var non_workable_jetty_not_work_total = 0
                   $.each(dataResult.non_workable,function(index,row){
                       non_label_data.push(row.name)
                       non_oa_not_work.push(row.oa_not_work)
                       non_berth_not_work.push(row.spl_berth_not_work)
                       non_jetty_not_work.push(row.jetty_not_work)

                       non_workable_oa_not_work_total = non_workable_oa_not_work_total + Number(row.oa_not_work)
                       non_workable_spl_berth_not_work_total = non_workable_spl_berth_not_work_total + Number(row.spl_berth_not_work)
                       non_workable_jetty_not_work_total = non_workable_jetty_not_work_total + Number(row.jetty_not_work)
                       data+="<tr>"
                       data+="<td>"+row.name+"</td>" +
                           "<td class='text-center'></td>" +
                           "<td class='text-center'>"+row.oa_not_work+"</td>" +
                           "<td class='text-center bg-success text-white'>"+Number(row.oa_not_work)+"</td>" +
                           "<td class='text-center'></td>" +
                           "<td class='text-center'>"+row.spl_berth_not_work+"</td>" +
                           "<td class='text-center bg-success text-white'>"+Number(row.spl_berth_not_work)+"</td>" +
                           "<td class='text-center'></td>" +
                           "<td class='text-center'>"+row.jetty_not_work+"</td>" +
                           "<td class='text-center bg-success text-white'>"+Number(row.jetty_not_work)+"</td>"+
                           "<td class='text-center'>"+Number(Number(row.oa_not_work)+Number(row.spl_berth_not_work)+Number(row.jetty_not_work))+"</td>";
                       data+="</tr>";

                   })
                   data+="<tr>"
                   data+="<td class='text-center bg-success text-white'>NON WORKABLE VESSEL</td>" +
                       "<td class='text-center bg-success text-white'>0</td>" +
                       "<td class='text-center bg-success text-white'>"+non_workable_oa_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+non_workable_oa_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>0</td>" +
                       "<td class='text-center bg-success text-white'>"+non_workable_spl_berth_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+non_workable_spl_berth_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>0</td>" +
                       "<td class='text-center bg-success text-white'>"+non_workable_jetty_not_work_total+"</td>" +
                       "<td class='text-center bg-success text-white'>"+non_workable_jetty_not_work_total+"</td>"+
                       "<td class='text-center bg-success text-white'>"+Number(non_workable_oa_not_work_total+non_workable_spl_berth_not_work_total+non_workable_jetty_not_work_total)+"</td>";
                   data+="</tr>";
                   data+="<tr>"
                   data+="<td class='text-center bg-primary text-white'>TOTAL VESSEL</td>" +
                       "<td class='text-center bg-primary text-white'>"+workable_oa_work_total+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_oa_not_work_total+non_workable_oa_not_work_total)+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_oa_work_total+workable_oa_not_work_total+non_workable_oa_not_work_total)+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+workable_spl_berth_work_total+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_spl_berth_not_work_total+non_workable_spl_berth_not_work_total)+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_spl_berth_work_total+workable_spl_berth_not_work_total+non_workable_spl_berth_not_work_total)+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+workable_jetty_work_total+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_jetty_not_work_total+non_workable_jetty_not_work_total)+"</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_jetty_work_total+workable_jetty_not_work_total+non_workable_jetty_not_work_total)+"</td>"+
                       "<td class='text-center bg-primary text-white'>"+Number(workable_oa_work_total+workable_oa_not_work_total+workable_spl_berth_work_total+workable_spl_berth_not_work_total+workable_jetty_work_total+workable_jetty_not_work_total+non_workable_oa_not_work_total+non_workable_spl_berth_not_work_total+non_workable_jetty_not_work_total)+"</td>";
                   data+="</tr>";

                   $("#workable_and_nonworkable_data").html(data);

                   $workable_vessel_data = ''
                   $workable_vessel_data+="<tr >"
                   $workable_vessel_data+="<td style=\"border-left:1px solid #5A8DEE!important\">TOTAL WORKING VESSEL</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_oa_work_total+workable_spl_berth_work_total+workable_jetty_work_total)+"</td>";
                   $workable_vessel_data+="</tr>";
                   $workable_vessel_data+="<tr>"
                   $workable_vessel_data+="<td style=\"border-left:1px solid #5A8DEE!important\">TOTAL NOT WORKING VESSEL</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_oa_not_work_total+workable_spl_berth_not_work_total+workable_jetty_not_work_total)+"</td>";
                   $workable_vessel_data+="</tr>";
                   $workable_vessel_data+="<tr>"
                   $workable_vessel_data+="<td style=\"border-left:1px solid #5A8DEE!important\">TOTAL WORKABLE VESSEL</td>" +
                       "<td class='text-center bg-primary text-white'>"+Number(workable_oa_work_total+workable_spl_berth_work_total+workable_jetty_work_total+workable_oa_not_work_total+workable_spl_berth_not_work_total+workable_jetty_not_work_total)+"</td>";
                   $workable_vessel_data+="</tr>";

                   $("#workable_vessel").html($workable_vessel_data);

                   var data = {
                       labels: label_data,
                       datasets: [
                           {
                               label: "OA Work",
                               backgroundColor: "#5A8DEE",
                               data: oa_work
                           },
                           {
                               label: "OA Not Work",
                               backgroundColor: "#4BC0C0",
                               data: oa_not_work
                           },
                           {
                               label: "Berth Work",
                               backgroundColor: "#6ff542",
                               data: berth_work
                           },
                           {
                               label: "Berth Not Work",
                               backgroundColor: "#e0f542",
                               data: berth_not_work
                           },
                           {
                               label: "Jetty Work",
                               backgroundColor: "#f5a742",
                               data: jetty_work
                           },
                           {
                               label: "Jetty Not Work",
                               backgroundColor: "#f56642",
                               data: jetty_not_work
                           }
                       ]
                   };


                   var non_data = {
                       labels: non_label_data,
                       datasets: [
                           {
                               label: "OA Not Work",
                               backgroundColor: "#4BC0C0",
                               data: non_oa_not_work
                           },
                           {
                               label: "Berth Not Work",
                               backgroundColor: "#e0f542",
                               data: non_berth_not_work
                           },
                           {
                               label: "Jetty Not Work",
                               backgroundColor: "#f56642",
                               data: non_jetty_not_work
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
                           text: 'Workable Vessel History'
                       },
                       scales: {
                           yAxes: [{
                               ticks: {
                                   min: 0
                               }
                           }]
                       }
                   };
                   var nonWorkableOption = {
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
                           text: 'Non-Workable Vessel History'
                       },
                       scales: {
                           yAxes: [{
                               ticks: {
                                   min: 0
                               }
                           }]
                       }
                   };

                   var workableVesselHistoryBarChart = new Chart(dataCtx, {
                       type: 'bar',
                       data: data,
                       options: myoption
                   });

                   var nonWorkableVesselHistoryBarChart = new Chart(nonWorkableDataCtx, {
                       type: 'bar',
                       data: non_data,
                       options: nonWorkableOption
                   });
               }
           });
       }
       runVesselHistory();
       window.setInterval(runVesselHistory, Interval);

       function runNotWorkingVesselOuter() {
           $.ajax({
               url: "/cdb/not-working-vessel-outer",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function(dataResult){
                   var data = '';
                   $.each(dataResult,function(index,row){
                       data+="<tr>"
                       data+="<td class='bg-primary text-white'>"+row.title+"</td>" +
                           "<td>"+row.content+"</td>";
                       data+="</tr>";
                   })
                   $("#non_workable_vessel").html(data);
               }
           });
       }
       runNotWorkingVesselOuter();
       window.setInterval(runNotWorkingVesselOuter, Interval);


       function runVacantBerth() {
           $.ajax({
               url: "/cdb/vacant-berth",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function(dataResult){
                   var data = '';
                   $.each(dataResult,function(index,row){
                       if(row.content)
                            var contentArr = row.content.split(',')
                       else
                           var contentArr = []
                       var span = ''
                       $.each(contentArr, function (idx, item) {
                           span+="<span class='badge badge-pill badge-primary' style='margin-right: 3px'>"+item+"</span>"
                       })
                       data+="<tr>"
                       data+="<td>"+span+"</td>"+
                           "<td class='text-center'>"+contentArr.length+"</td>";
                       data+="</tr>";
                   })
                   $("#vacant_berth").html(data);
               }
           });
       }
       runVacantBerth();
       window.setInterval(runVacantBerth, Interval);


       function runRecruitment() {
           $.get('/cdb/recruitment', function (res) {
               $(document).find("#recruitment-data").html(res.html);
           });
       }
       runRecruitment();
       window.setInterval(runRecruitment, Interval);

       function runCase() {
           $.get('/cdb/cases', function (res) {
               $(document).find("#case-data").html(res.html);
               var data = res.current_year;
               $(document).find("#yr-total").text(data.total);

               $(document).find("#yr-closed").text(data.completed);

               var closed_percent = (parseInt(data.completed * 100)) / parseInt(data.total);
               $(document).find("#yr-closed-graph").css('width', closed_percent);


               var ongoing = parseInt(data.in_progress) + parseInt(data.new);
               var ongoing_percent = (ongoing * 100) / parseInt(data.total);
               $(document).find("#yr-ongoing").text(ongoing);
               $(document).find("#yr-ongoing-graph").css('width', ongoing_percent);
           });
       }
       runCase();
       window.setInterval(runCase,Interval);

       function runHA() {
           $.get('/cdb/house-allotment', function (res) {
               $(document).find("#house-allotment-data").html(res.html);
           });
       }
       window.setInterval(runHA, Interval);
       runHA();

       function runCE() {
           $.get('/cdb/civil-engineering', function (res) {
               $(document).find("#civil-engineering-data").html(res.html);
           });
       }
       runCE();
       window.setInterval(runCE,Interval);


       $(document).on('click', '.zoom-on',function(e) {
            e.preventDefault();
            let modal = $(this).parents('.zoom');
            if ($(this).find('i').hasClass('bx-fullscreen')) {
                $(this).find('i').attr('class', 'ficon bx bx-exit-fullscreen');
                modal.addClass('modal fade');
                //modal.css({'background':'#ccc', 'opacity':0.5});
                modal.find('.dialog').addClass('modal-dialog modal-xl modal-dialog-centered modal-dialog-zoom').removeClass('h-100');
                modal.find('.m-content').addClass('modal-content').removeClass('h-100');
                modal.modal({show: true, backdrop:'static'});
            }
            else {
                prevID = ''
                $(this).find('i').attr('class', 'ficon bx bx-fullscreen');
                modal.find('.dialog').attr('class', 'dialog h-100');
                modal.find('.m-content').attr('class', 'm-content h-100');
                modal.attr('class', 'zoom h-100');
                modal.modal('hide');
                modal.removeAttr('style');
                modal.removeAttr('aria-modal');
            }
       });

       var prevID = '';
       $('.quick-access').on("click", 'i,img, a.text-menu', function() {
          var id = $(this).data('target');
          if (id == prevID)
              prevID = '';

          if (prevID != '' ) {
             $(prevID).find(".zoom-on").trigger('click');
          }
          prevID =  id;
          $(id).find(".zoom-on").trigger('click');
       });

       $('.quick-access').on("click", '.checkboxPos, .checkboxPosMenu', function() {
           var id =  $(this).data('target');
           if($(this).is(':checked'))
           {
               $(id).fadeIn();
           }
           else {
               $(id).fadeOut();
           }
       });

       function dailyContHand() {
           $.ajax({
               url: "/cdb/daily-cont-hand",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function(dataResult){
                   dataResult;
                   var data = '';

                   $.each(dataResult,function(index,row){
                       data+="<tr>"
                       if(dataResult[index].total_container == null)
                           data+="<td>"+dataResult[index].title+"</td>" +
                               "<td class='text-center'>"+ 0 +"</td>";
                       else{
                           data+="<td>"+dataResult[index].title+"</td>" +
                               "<td class='text-center'>"+ dataResult[index].total_container +"</td>";
                       }
                       data+="</tr>";
                   })
                   $("#daily-cont-hand").html(data);
               }
           });
       }
       dailyContHand();
       window.setInterval(dailyContHand, Interval);

       function dailyTotalIncoming() {
           $.ajax({
               url: "/cdb/daily-total-incoming",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function(dataResult){
                   dataResult;
                   var data = '';

                   $.each(dataResult,function(index,row){
                       data+="<tr>"
                       data+="<td>"+dataResult[index].title+"</td>" +
                           "<td class='text-center'>"+ dataResult[index].box +"</td>" +
                           "<td class='text-center'>"+ dataResult[index].tues +"</td>";
                       data+="</tr>";
                   })
                   data+="<tr class='bg-primary text-white'>"
                   data+="<td>TOTAL</td>" +
                       "<td class='text-center'>"+ dataResult.map(item => item.box).reduce((prev, next) => Number(prev) + Number(next)) +"</td>" +
                       "<td class='text-center'>"+ dataResult.map(item => item.tues).reduce((prev, next) => Number(prev) + Number(next)) +"</td>";
                   data+="</tr>";

                   $("#daily-total-incoming").html(data);
               }
           });
       }
       dailyTotalIncoming();
       window.setInterval(dailyTotalIncoming, Interval);

       function dailyTotalDesp() {
           $.ajax({
               url: "/cdb/daily-total-desp",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function(dataResult){
                   dataResult;
                   var data = '';

                   $.each(dataResult,function(index,row){
                       data+="<tr>"
                       data+="<td>"+dataResult[index].title+"</td>" +
                           "<td class='text-center'>"+ dataResult[index].box +"</td>" +
                           "<td class='text-center'>"+ dataResult[index].tues +"</td>";
                       data+="</tr>";
                   })
                   data+="<tr class='bg-primary text-white'>"
                   data+="<td>TOTAL</td>" +
                       "<td class='text-center'>"+ dataResult.map(item => item.box).reduce((prev, next) => Number(prev) + Number(next)) +"</td>" +
                       "<td class='text-center'>"+ dataResult.map(item => item.tues).reduce((prev, next) => Number(prev) + Number(next)) +"</td>";
                   data+="</tr>";
                   $("#daily-total-desp").html(data);
               }
           });
       }
       dailyTotalDesp();
       window.setInterval(dailyTotalDesp, Interval);

       function runVesselMovement() {
           $.ajax({
               url: "/cdb/vessel-movement",
               type: "GET",
               cache: false,
               dataType: 'json',
               success: function (dataResult) {
                   dataResult;
                   var movData = '';
                   var start_tm = '';
                   var end_tm = '';

                   $.each(dataResult,function(index,row){
                       if(row.start_time)
                       {
                           start_tm = row.start_time;
                       }
                       else
                       {
                           start_tm = '';
                       }

                       if(row.end_time)
                       {
                           end_tm = row.end_time;
                       }
                       else
                       {
                           end_tm = '';
                       }

                       movData+="<tr>"
                       movData+="<td>"+row.title+"</td>" +
                           "<td class='text-center'>"+row.nos+"</td>" +
                           "<td>"+start_tm+"</td>" +
                           "<td>"+end_tm+"</td>"
                       movData+="</tr>";
                   })
                   $("#vessel_move_data").html(movData);
               }
           });
       }
       runVesselMovement();
       window.setInterval(runVesselMovement, Interval);
   });


    window.pop_show = function(data_src) {
        var pop = $("#second_pop_modal");
        pop.modal({show: true});
        pop.find('#pop_content').html("Loading....")
        $.get(data_src, function(data) {
            pop.find('#pop_content').html(data);
        });
    }
    // window.oneStop_pop_show = function(data_src) {
    //     var pop = $("#second_pop_modal");
    //     pop.modal({show: true});
    //     pop.find('#pop_content').html("Loading....")
    //     $.get(data_src, function(data) {
    //         pop.find('#pop_content').html(data);
    //         loadTable()
    //     });
    // }
    $(document).on("click", '.containerDetails', function(e) {
        e.preventDefault();
            let data_src = $(this).attr('href');
            var pop = $("#oneStopModel");
            pop.modal({show: true});
            pop.find('#onestop_pop_content').html("Loading....")
            $.get(data_src, function(data) {
                pop.find('#onestop_pop_content').html(data.html);
            });
    });

    var loadTable = function () {
        $(document).find('#table_training').DataTable();
        $(document).find('#table_tour').DataTable();
        $(document).find('#table_late_attendance').DataTable();
        $(document).find('#table_on_leave').DataTable();
    }
    window.detail = function (data_src) {
        $.get(data_src, function(data) {
            $(document).find('#table_content').html(data);
            loadTable()
        });
    }


    $(document).on('click', '.case-second-level', function(e) {
        e.preventDefault();
        var status = $(this).data('status');
        var year = $(this).data('year');
        var url = "/cdb/cases/details/"+status+"?year="+year+"";
        pop_show(url);
    })

    $(document).on('click', '.audit-second-level', function(e) {
        e.preventDefault();
        var status = $(this).data('status');
        var year = $(this).data('year');
        var url = "/cdb/audit/details/"+status+"/"+year;
        pop_show(url);
    })

    $(document).on('click', '.vehicle-second-level', function(e) {
        e.preventDefault();
        let status = $(this).data('status');
        let url = "/cdb/vehicles/details/"+status+"";
        pop_show(url);
    })



})(jQuery);
