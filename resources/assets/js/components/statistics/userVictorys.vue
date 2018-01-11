<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">User Statistics:</div>
        <div class="panel-body">
            <div id="barchartUserVictorys" style="width: 100%; height: 150px;"></div>
        </div>      
    </div>

</div>
</template>

<script>
    "use strict";
    export default {
        props: ['victorys'],
            data: function () {
                return {
                    nothing:[]
                }
            },
        methods: {
            noDataChart: function(){//Adds fancy no Data Message
                    google.charts.load("current", {packages:["corechart"]});
                    google.charts.setOnLoadCallback(()=>{
    
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Type');
                        data.addColumn('number', 'Games');
                           
                        var options = {
                          is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('barchartUserVictorys'));
                        chart.draw(data, options);
                    });   
                },
                
            populateChart: function(records){//Adds ColumnChart 
                console.log("I ENTER HERE");
                google.charts.setOnLoadCallback(()=>{
    
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Type');
                        data.addColumn('number', 'Games');
                        
                        //Adds rows based on victorys
                        records.forEach(function(record){
                            data.addRow([record.type, record.games]);
                        });

                    
                        var options = {
                            legend: {position: 'none'}
                        };

                        var chart = new google.visualization.ColumnChart(document.getElementById('barchartUserVictorys'));
                        chart.draw(data, options);
                    });
            }
            
        },
        watch: {
                victorys: function(records){
                    if (records==null || records.length==0) this.noDataChart();
                    else this.populateChart(records);         
                },
            },
        mounted() {
        }
    }
</script>
