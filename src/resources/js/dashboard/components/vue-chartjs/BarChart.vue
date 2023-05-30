<script>
    import { Bar } from "vue-chartjs";
    export default {
        extends: Bar,
        props: {
            labels:{
                type: Array,
                default: () => {
                    return [];
                }
            },
            datasets:{
                type: Array,
                default: () => {
                    return [];
                }
            }, series:{
                type: Array,
                default: () => {
                    return [];
                }
            }, label:{
                type: String,
                default: ""
            }, backgroundColor:{
                type: String,
                default: ""
            }
        },

        watch: {
            labels: function ( val ) {
                this.renderChart({labels:  val,
                        datasets: [
                            {
                                label: this.label,
                                backgroundColor: this.backgroundColor,
                                data: this.series
                            }
                        ]
                    },
                    { responsive: true, maintainAspectRatio: false }
                );
            }
        },
        mounted() {
        }
    };
</script>
