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
            data:{
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
                                data: this.data
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
