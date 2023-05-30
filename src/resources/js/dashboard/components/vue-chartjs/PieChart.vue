<script>
    import { Pie } from "vue-chartjs";

    export default {
        extends: Pie,
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
            labels: function (val) {
                this.renderChart(
                    {
                        labels: val,
                        datasets: [
                            {
                                backgroundColor: [
                                    this.gradient,
                                    this.gradient2,
                                    this.gradient3,
                                    this.gradient4,
                                    this.gradient5,
                                    this.gradient6,
                                    this.gradient7,
                                    this.gradient8,
                                    this.gradient9,
                                    this.gradient10,
                                    this.gradient11,
                                    this.gradient12,
                                    this.gradient13,
                                    this.gradient14,
                                    this.gradient15,
                                    this.gradient16,
                                    this.gradient17,
                                    this.gradient18,
                                    this.gradient19,
                                    this.gradient20,
                                    "#00D8FF"
                                ],
                                data: this.data,
                                label: this.label,
                            }
                        ]
                    },
                    { responsive: true, maintainAspectRatio: false }
                );
            }
        },
        mounted() {
            this.gradient = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient2 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient3 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient4 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient5 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient6 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient7 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient8 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient9 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient10 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient11 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient12 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient13 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient14 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient15 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient16 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient17 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient18 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient19 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);
            this.gradient20 = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 450);

            this.gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
            this.gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
            this.gradient.addColorStop(1, "rgba(255, 0, 0, 0)");
            this.gradient2.addColorStop(0, "rgba(0, 231, 255, 0.9)");
            this.gradient2.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
            this.gradient2.addColorStop(1, "rgba(0, 231, 255, 0)");
            this.gradient3.addColorStop(0, "rgba(0, 0,10, 0.5)");
            this.gradient3.addColorStop(0.5, "rgba(0, 10, 0, 0.25)");
            this.gradient3.addColorStop(1, "rgba(0, 0, 10, 0)");
            this.gradient4.addColorStop(0, "rgba(0, 91, 37, 1)");
            this.gradient4.addColorStop(0.5, "rgba(0, 91, 37, 1)");
            this.gradient4.addColorStop(1, "rgba(0, 91, 37, 1)");
            this.gradient5.addColorStop(0, "rgba(137, 142, 0, 0.75)");
            this.gradient5.addColorStop(0.5, "rgba(137, 142, 0, 0.75)");
            this.gradient5.addColorStop(1, "rgba(137, 142, 0, 0.75)");
            this.gradient6.addColorStop(0, "rgba(137, 86, 0, 0.75)");
            this.gradient6.addColorStop(0.5, "rgba(137, 86, 0, 0.75)");
            this.gradient6.addColorStop(1, "rgba(137, 86, 0, 0.75)");
            this.gradient7.addColorStop(0, "rgba(0, 157, 79, 0.74)");
            this.gradient7.addColorStop(0.5, "rgba(0, 157, 79, 0.74)");
            this.gradient7.addColorStop(1, "rgba(0, 157, 79, 0.74)");
            this.gradient8.addColorStop(0, "rgba(93, 91, 92, 0.35)");
            this.gradient8.addColorStop(0.5, "rgba(93, 91, 92, 0.35)");
            this.gradient8.addColorStop(1, "rgba(93, 91, 92, 0.35)");
            this.gradient9.addColorStop(0, "rgba(93, 91, 92, 0.79)");
            this.gradient9.addColorStop(0.5, "rgba(93, 91, 92, 0.79)");
            this.gradient9.addColorStop(1, "rgba(93, 91, 92, 0.79)");
            this.gradient10.addColorStop(0, "rgba(93, 91, 224, 1)");
            this.gradient10.addColorStop(0.5, "rgba(93, 91, 224, 1)");
            this.gradient10.addColorStop(1, "rgba(93, 91, 224, 1)");
            this.gradient11.addColorStop(0, "rgba(93, 171, 224, 1)");
            this.gradient11.addColorStop(0.5, "rgba(93, 171, 224, 1)");
            this.gradient11.addColorStop(1, "rgba(93, 171, 224, 1)");
            this.gradient12.addColorStop(0, "rgba(93, 255, 224, 1)");
            this.gradient12.addColorStop(0.5, "rgba(93, 255, 224, 1)");
            this.gradient12.addColorStop(1, "rgba(93, 255, 224, 1)");
            this.gradient13.addColorStop(0, "rgba(255, 214, 255, 1)");
            this.gradient13.addColorStop(0.5, "rgba(255, 214, 255, 1)");
            this.gradient13.addColorStop(1, "rgba(255, 214, 255, 1)");
            this.gradient14.addColorStop(0, "rgba(250, 49, 224, 1)");
            this.gradient14.addColorStop(0.5, "rgba(250, 49, 224, 1)");
            this.gradient14.addColorStop(1, "rgba(250, 49, 224, 1)");
            this.gradient15.addColorStop(0, "rgba(117, 49, 224, 1)");
            this.gradient15.addColorStop(0.5, "rgba(117, 49, 224, 1)");
            this.gradient15.addColorStop(1, "rgba(117, 49, 224, 1)");
            this.gradient16.addColorStop(0, "rgba(117, 49, 224, 0.38)");
            this.gradient16.addColorStop(0.5, "rgba(117, 49, 224, 0.38)");
            this.gradient16.addColorStop(1, "rgba(117, 49, 224, 0.38)");
            this.gradient17.addColorStop(0, "rgba(0, 152, 89, 1)");
            this.gradient17.addColorStop(0.5, "rgba(0, 152, 89, 1)");
            this.gradient17.addColorStop(1, "rgba(0, 152, 89, 1)");
            this.gradient18.addColorStop(0, "rgba(0, 152, 255, 0.24)");
            this.gradient18.addColorStop(0.5, "rgba(0, 152, 255, 0.24)");
            this.gradient18.addColorStop(1, "rgba(0, 152, 255, 0.24)");
            this.gradient19.addColorStop(0, "rgba(0, 2, 255, 0.23)");
            this.gradient19.addColorStop(0.5, "rgba(0, 2, 255, 0.23)");
            this.gradient19.addColorStop(1, "rgba(0, 2, 255, 0.23)");
            this.gradient20.addColorStop(0, "rgba(178, 154, 255, 0.23)");
            this.gradient20.addColorStop(0.5, "rgba(178, 154, 255, 0.23)");
            this.gradient20.addColorStop(1, "rgba(178, 154, 255, 0.23)");





        }
    };
</script>
