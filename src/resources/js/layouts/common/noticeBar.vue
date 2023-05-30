<template>
     <div class="input-group notice">
        <div class="input-group-prepend">
            <span class="input-group-text bg-dark text-white border-0 rounded-0" id="basic-addon1">ALL NEWS &nbsp;
                <span v-if="false">
                    <span v-if="language == 'bn'">
                        BN
                    </span>
                    <a v-else @click="language = 'bn'" href="javascript:void(0)">BN</a>|
                    <span v-if="language == 'en'">
                        EN
                    </span>
                    <a v-else @click="language = 'en'" href="javascript:void(0)">EN</a></span>
                </span>
        </div>
        <marquee class="form-control rounded-0" onmouseover="this.stop();" onmouseout="this.start();">
            <div class="d-flex align-items-center">
                <a @click="showModal(item.news_id)" href="javascript:void(0)" v-for="(item, index) in news" :key="`${index}-${item.news_id}`">
                    <i class="bx bx-label"></i>
                    <span style="color:black" v-if="language == 'en'" >&nbsp;&nbsp; {{item.title}} &nbsp;&nbsp;</span>
                    <span style="color:black" v-else >&nbsp;&nbsp; {{item.title_bn}} &nbsp;&nbsp;</span>
                </a>
            </div>
        </marquee>
         <b-modal ref="newsModal" size="lg" scrollable centered ok-only hide-header ok-title="Close">
            <b-row v-if="language == 'bn'">
                <b-col md="12">
                    <h5 class="mt-0"><i class='bx bx-news'></i> {{modalData.title_bn}}</h5>
                    <hr class="mt-0" />
                    <p class="mb-2 mt-0" v-html="modalData.description_bn">
                    </p>

                    <div v-if="modalData.attachment_filename">
                        <h6  class="mt-0"><i class='bx bx-paperclip' ></i> Attachment</h6>
                        <hr class="mt-0" />
                        <a :href="'/v1/admin/post/attachment/news/'+modalData.news_id">
                            <i class='bx bx-file' ></i> {{modalData.attachment_filename}}
                        </a>
                    </div>
                </b-col>
            </b-row>
             <b-row v-if="language == 'en'">
                 <b-col md="12">
                     <h5><i class='bx bx-news'></i> {{modalData.title}}</h5>
                     <hr />
                     <p class="mb-0" v-html="modalData.description">
                     </p>
                     <div v-if="modalData.attachment_filename">
                         <h6 class="mt-1"> <i class='bx bx-paperclip' ></i> Attachment:</h6>
                         <a :href="'/v1/admin/post/attachment/news/'+modalData.news_id">
                             <i class='bx bx-file' ></i> {{modalData.attachment_filename}}
                         </a>
                     </div>
                 </b-col>
             </b-row>
         </b-modal>
    </div>
</template>
<script>

import ApiRepository from "../../Repository/ApiRepository";

export default {
    data() {
        return {
            name: '',
            news: [],
            language: 'bn',
            modalData: {}
        }
    },
    mounted() {
        this.loadNews();
        setInterval(
            this.loadNews(),
        5000);
    },
    methods: {
        loadNews(){
            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/post/news/active`).then(result => {
                this.news = result.data
            });
        },
        showModal(id) {
            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/post/news/${id}/active`).then(result => {
                this.modalData = result.data.news;
                this.$refs['newsModal'].show();
            });

        },
    }
};
</script>
