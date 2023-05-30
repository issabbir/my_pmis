<script>
    import { Line } from "vue-chartjs";

    export default {
        extends: Line,
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
            },
            label:{
                type: String,
                default: ""
            },
            backgroundColor:{
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
                                data: this.data,
                                borderColor: "rgba(1, 116, 188, 0.50)",
                                pointBackgroundColor: "rgba(171, 71, 188, 1)"
                            }
                        ]
                    },
                    {
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: true,
                            text: this.label
                        }
                    }
                );
            }
        },
    };
</script>
