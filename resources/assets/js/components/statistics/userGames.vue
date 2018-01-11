<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">User Statistics:</div>
        <div class="panel-body">
            <div v-model="games" id="barchartUserGames" style="width: 100%; height: 150px;"></div>
        </div>      
    </div>
</div>
</template>

<script>
    "use strict";
    export default {
        props: ['games'],
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

                        var chart = new google.visualization.PieChart(document.getElementById('barchartUserGames'));
                        chart.draw(data, options);
                    });   
                },
                
            populateChart: function(records){//Adds BarChart 
               google.charts.setOnLoadCallback(()=>{
    
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Type');
                        data.addColumn('number', 'Games');
                        
                        //Adds rows based on games
                        records.forEach(function(record){
                            data.addRow([record.type, record.games]);
                        });


                        var options = {
                            legend: {position: 'none'},
                            series: {
                                0: { color: '#e2431e' }
                            }
                        };

                        var chart = new google.visualization.BarChart(document.getElementById('barchartUserGames'));
                        chart.draw(data, options);
                    });
            }
            
        },
        watch: {
            	games: function(records){
                    if (records==null || records.length==0) this.noDataChart();
                    else this.populateChart(records);                   
                },    
            },
        mounted() {
           
        }
    }
</script>
