<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-card>
        <b-card-header header-bg-variant="dark" header-text-variant="white">Module</b-card-header>
        <b-card-body class="border">
          <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <b-row>
              <b-col>
                <b-form-group
                  label="Module Name"
                  label-cols-md="2"
                  label-for="module_name"
                >
                  <b-form-input id="module_name" v-model.trim="$v.formData.module_name.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.module_name.$error && !$v.formData.module_name.required}">Module name is required!</div>
                </b-form-group>
                <b-form-group
                  label="মডিউলের নাম"
                  label-cols-md="2"
                  label-for="module_name_bng"
                >
                  <b-form-input id="module_name_bng" v-model.trim="$v.formData.module_name_bng.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.module_name_bng.$error && !$v.formData.module_name_bng.required}">Module name (bengali) is required!</div>
                </b-form-group>
                <b-form-group
                  label="Enable Status"
                  label-cols-md="2"
                  label-for="enabled"
                >
                  <b-form-radio-group
                    id="enabled"
                    v-model="$v.formData.enabled.$model"
                    :options="[{text: 'YES', value: 'Y'}, {text: 'NO', value: 'N'}]"
                  ></b-form-radio-group>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.enabled.$error && !$v.formData.enabled.required}">Enable status is required!</div>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col class="d-flex justify-content-end">
                <b-button type="submit" class="mr-1" variant="primary">Submit</b-button>
                <b-button type="reset">Reset</b-button>
              </b-col>
            </b-row>


          </b-form>
        </b-card-body>
      </b-card>
      <b-card>
        <b-card-header header-bg-variant="dark" header-text-variant="white">Modules</b-card-header>
        <b-card-body class="border">
          <Datatable :fields="fields" :items="loadModules" :totalList="totalList" :perPage="perPage" :update="update" @refreshed="update = false">
            <template v-slot:actions="{rows}">
              <b-link @click="edit(rows.item)" title="Edit"><i class="bx bx-edit cursor-pointer"></i></b-link>
            </template>
            <template v-slot:action2="{rows}">
              <span class="text-primary bx bx-check" v-if="rows.item.enabled == 'Y'"></span>
              <span class="text-danger bx bx-x-circle" v-else></span>
            </template>
          </Datatable>
        </b-card-body>
      </b-card>
    </div>
  </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable";
    import vSelect from "vue-select";
    import vcss from "vue-select/dist/vue-select.css";
    import ApiRepository from "../../../Repository/ApiRepository";
    const {required} = require("vuelidate/lib/validators");

    export default {
        name: "Modules",
        components: {Datatable, vSelect, vcss},
        data() {
            return {
                update: false,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'module_name', label: 'Module'},
                    {key: 'module_name_bng', label: 'মডিউল'},
                    {key: 'action2', label: 'Enabled', class: 'text-center'},
                    {key: 'action', class: 'text-center'}
                ],
                items: [],
                totalList: 0,
                perPage: 10,
                formData: {
                    module_id: null,
                    module_name: null,
                    module_name_bng: null,
                    enabled: 'Y'
                }
            }
        },
        validations: {
            formData: {
                module_id: {},
                module_name: {required},
                module_name_bng: {},
                enabled: {required}
            }
        },
        mounted() {

        },
        methods: {
            provider(items) {
            },
            loadModules(ctx, callback){
                if(callback != undefined ){
                    this.provider = callback
                } else {
                    this.provider = this.provider
                }
                ctx.currentPage = ctx.currentPage == undefined ? 1 : ctx.currentPage
                ctx.perPage = ctx.perPage == undefined ? this.perPage : ctx.perPage
                ctx.filter = ctx.filter == undefined ? null : ctx.filter
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/modules-datatable'+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter).then(response => {
                    let items = response.data.data
                    this.totalList = response.data.total
                    this.perPage = response.data.per_page
                    this.provider(items)
                })
            },
            onSubmit(){
                this.$v.$touch();
                this.$v.formData.$touch();
                if (!this.$v.formData.$invalid){
                    if(!this.formData.module_id){
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/module', this.formData).then(response => {
                            this.onReset()
                            this.$notify({group: 'pmis', text: 'Data inserted successfully!', type: 'success'})
                            this.update = true
                        })
                    }else {
                        ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/module/${this.formData.module_id}`, this.formData).then(response => {
                            this.onReset()
                            this.$notify({group: 'pmis', text: 'Data updated successfully!', type: 'success'})
                            this.update = true
                        })
                    }

                }
            },
            edit(module){
                this.formData = {
                    module_id: module.module_id,
                    module_name: module.module_name,
                    module_name_bng: module.module_name_bng,
                    enabled: module.enabled
                }
            },
            onReset(){
                this.formData = {
                    module_id: null,
                    module_name: null,
                    module_name_bng: null,
                    enabled: 'Y'
                }
                this.$v.$reset()
            }
        }
    }
</script>

<style scoped>

</style>
