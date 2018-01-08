<template>    
<div>
	<div class="panel panel-default">
	    <div class="panel-heading">Global Statistics:</div>
        <div class="panel-body">
        	<div id="donutchart" style="width: 100%; height: 200px"></div>
        </div>      
	</div>
</div>
</template>

<script>
    "use strict";
    export default {
        props: ['globalStatistics'],
            data: function () {
                return {
                
                }
            },

            methods: {
                //Opens edit form
                callDrawChart: function(records){
                    google.charts.load("current", {packages:["corechart"]});
                    google.charts.setOnLoadCallback(()=>{
    
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Type');
                        data.addColumn('number', 'Games');
                        
                        //Adds rows based in the amount given by the parent
                        records.forEach(function(record){
                            data.addRow([record.type, record.games]);
                        });

                    
                        var options = {
                          is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                        chart.draw(data, options);
                    });
                
                },
            },
            mounted() {
                //Gives no data, becase at the time the dad didnt had the data
                this.callDrawChart(this.globalStatistics);

                //Everytime the new data is loaded callDrawChart will be called
                this.$parent.$on('loadGlobalStatistics', this.callDrawChart);
            }
        }
</script>
