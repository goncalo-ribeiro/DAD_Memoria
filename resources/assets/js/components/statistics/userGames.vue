<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">User Statistics:</div>
        <div class="panel-body">
            <div id="barchartUserGames" style="width: 100%; height: 150px;"></div>
        </div>      
    </div>
</div>
</template>

<script>
    "use strict";
    export default {
            data: function () {
                return {
                    nothing:[]
                }
            },
        methods: {
                //Opens edit form
                callDrawChart: function(records){
                    console.log("HAHHA");
                    google.charts.setOnLoadCallback(()=>{
    
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Type');
                        data.addColumn('number', 'Games');
                        
                        //Adds rows based in the amount given by the parent
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
                
                },
            },
        mounted() {
            //Gives no data, because at the time the dad didnt had the data
            this.callDrawChart(this.nothing);

            //Everytime the new data is loaded callDrawChart will be called
            this.$parent.$on('loadUserGames', this.callDrawChart);
        }
    }
</script>
