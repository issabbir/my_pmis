<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-card>
        <b-card-header header-bg-variant="dark" header-text-variant="white">Menu</b-card-header>
        <b-card-body class="border">
          <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <b-row>
              <b-col>
                <b-form-group
                  label="Menu Name"
                  label-cols-md="3"
                  label-for="menu_name"
                >
                  <b-form-input id="menu_name" v-model.trim="$v.formData.menu_name.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.menu_name.$error && !$v.formData.menu_name.required}">Menu name is required!</div>
                </b-form-group>
                <b-form-group
                  label="Menu Text"
                  label-cols-md="3"
                  label-for="menu_text_eng"
                >
                  <b-form-input id="menu_text_eng" v-model.trim="$v.formData.menu_text_eng.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.menu_text_eng.$error && !$v.formData.menu_text_eng.required}">Menu Text is required!</div>
                </b-form-group>
                <b-form-group
                  label="Menu Text (Bengali)"
                  label-cols-md="3"
                  label-for="menu_text_bng"
                >
                  <b-form-input id="menu_text_bng" v-model.trim="$v.formData.menu_text_bng.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.menu_text_bng.$error && !$v.formData.menu_text_bng.required}">Menu text (bengali) is required!</div>
                </b-form-group>
                <b-form-group
                  label="Module"
                  label-cols-md="3"
                  label-for="module_id"
                >
                  <v-select
                    v-model="selectedModule"
                    :options="moduleOptions"
                    name="module_id"
                    id="module_id"
                    label="module_name"
                    class="uppercase">
                    <template #search="{attributes, events}">
                      <input class="vs__search" v-bind="attributes" v-on="events"/>
                    </template>
                  </v-select>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.module_id.$error && !$v.formData.module_id.required}">Module is required!</div>
                </b-form-group>
                <b-form-group
                  label="Order Number"
                  label-cols-md="3"
                  label-for="menu_order_no"
                >
                  <b-form-input
                    id="menu_order_no"
                    v-model.trim="$v.formData.menu_order_no.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.menu_order_no.$error && !$v.formData.menu_order_no.required}">Order number is required!</div>
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group
                  label="Base URL"
                  label-cols-md="3"
                  label-for="base_url"
                >
                  <b-form-input
                    id="base_url"
                    v-model.trim="$v.formData.base_url.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.base_url.$error && !$v.formData.base_url.required}">Base URL is required!</div>
                </b-form-group>
                <b-form-group
                  label="Base Path"
                  label-cols-md="3"
                  label-for="base_path"
                >
                  <b-form-input
                    id="base_path"
                    v-model.trim="$v.formData.base_path.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.base_path.$error && !$v.formData.base_path.required}">Base path is required!</div>
                </b-form-group>
                <b-form-group
                  label="Icon"
                  label-cols-md="3"
                  label-for="icon"
                >
                  <b-form-input
                    id="icon"
                    v-model.trim="$v.formData.icon.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.icon.$error && !$v.formData.icon.required}">Icon is required!</div>
                </b-form-group>
                <b-form-group
                  label="BG Color"
                  label-cols-md="3"
                  label-for="bg_color"
                >
                  <b-form-input
                    id="bg_color"
                    v-model.trim="$v.formData.bg_color.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.bg_color.$error && !$v.formData.bg_color.required}">Background color is required!</div>
                </b-form-group>

                <b-form-group
                  label="Active Status"
                  label-cols-md="3"
                  label-for="active_yn"
                >
                  <b-form-radio-group
                    id="active_yn"
                    v-model="$v.formData.active_yn.$model"
                    :options="[{text: 'YES', value: 'Y'}, {text: 'NO', value: 'N'}]"
                  ></b-form-radio-group>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.active_yn.$error && !$v.formData.active_yn.required}">Active status is required!</div>
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
        <b-card-header header-bg-variant="dark" header-text-variant="white">Menus</b-card-header>
        <b-card-body class="border">
          <Datatable :fields="fields" :items="loadMenus" :totalList="totalList" :perPage="perPage" responsive bordered :update="update" @refreshed="update = false">
            <template v-slot:actions="{rows}">
              <b-link @click="edit(rows.item)" title="Edit"><i class="bx bx-edit cursor-pointer"></i></b-link>
            </template>
            <template v-slot:action2="{rows}">
              <span class="text-primary bx bx-check" v-if="rows.item.active_yn == 'Y'"></span>
              <span class="text-danger bx bx-x-circle" v-else></span>
            </template>
            <template v-slot:action3="{rows}">
              <div :style="'color:white; background-color:'+ rows.item.bg_color" v-html="rows.item.icon"></div>
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
        name: "Menus",
        components: {Datatable, vSelect, vcss},
        data() {
            return {
                update: false,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'menu_name', label: 'Menu'},
                    {key: 'menu_text_eng', label: 'Menu Text'},
                    {key: 'menu_text_bng', label: 'Menu Text (Bengali)'},
                    {key: 'module.module_name', label: 'module'},
                    {key: 'menu_order_no', label: 'Order No.'},
                    {key: 'base_url', label: 'Base URL'},
                    /*{key: 'bg_color', label: 'BG Color'},*/
                    {key: 'base_path', label: 'Base Path'},
                    {key: 'action3', label: 'Icon & BG Color'},
                    {key: 'action2', label: 'Active', class: 'text-center'},
                    {key: 'action', class: 'text-center'}
                ],
                items: [],
                totalList: 0,
                perPage: 10,
                formData: {
                    menu_id: null,
                    menu_name: null,
                    menu_text_eng: null,
                    menu_text_bng: null,
                    module_id: null,
                    menu_order_no: null,
                    active_yn: 'Y',
                    base_url: null,
                    icon: null,
                    bg_color: null,
                    base_path: null
                },
                moduleOptions: [],
                selectedModule: {
                    module_id: null,
                    module_name: null
                }
            }
        },
        validations: {
            formData: {
                menu_id: {},
                menu_name: {required},
                menu_text_eng: {},
                menu_text_bng: {},
                module_id: {required},
                menu_order_no: {required},
                active_yn: {},
                base_url: {},
                icon: {},
                bg_color: {},
                base_path: {}
            }
        },
        mounted() {
            this.loadModules()
        },
        watch: {
            selectedModule(val, oldVal){
                if(val.module_id){
                    this.formData.module_id = val.module_id
                }else {
                    this.formData.module_id = null
                }
            }
        },
        methods: {
            loadModules(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/modules').then(response => {
                    this.moduleOptions = response.data
                })
            },
            provider(items) {

            },
            loadMenus(ctx, callback){
                if(callback != undefined ){
                    this.provider = callback
                } else {
                    this.provider = this.provider
                }
                ctx.currentPage = ctx.currentPage == undefined ? 1 : ctx.currentPage
                ctx.perPage = ctx.perPage == undefined ? this.perPage : ctx.perPage
                ctx.filter = ctx.filter == undefined ? null : ctx.filter
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/menus-datatable'+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter).then(response => {
                    let items = response.data.data
                    this.totalList = response.data.total
                    this.perPage = response.data.per_page
                    this.provider(items)
                })
                return null
            },
            onSubmit(){
                this.$v.$touch();
                this.$v.formData.$touch();
                if (!this.$v.formData.$invalid){
                    if(!this.formData.menu_id){
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/menu', this.formData).then(response => {
                            this.onReset()
                            this.$notify({group: 'pmis', text: 'Data inserted successfully!', type: 'success'})
                            this.update = true
                            this.loadMenus()
                        })
                    }else {
                        ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/menu/${this.formData.menu_id}`, this.formData).then(response => {
                            this.onReset()
                            this.$notify({group: 'pmis', text: 'Data updated successfully!', type: 'success'})
                            this.update = true
                            this.loadMenus()

                        })
                    }

                }
            },
            edit(menu){
                this.formData = {
                    menu_id: menu.menu_id,
                    menu_name: menu.menu_name,
                    menu_text_eng: menu.menu_text_eng,
                    menu_text_bng: menu.menu_text_bng,
                    module_id: menu.module_id,
                    menu_order_no: menu.menu_order_no,
                    active_yn: menu.active_yn,
                    base_url: menu.base_url,
                    icon: menu.icon,
                    bg_color: menu.bg_color,
                    base_path: menu.base_path
                }
                this.selectedModule = {
                    module_id: menu.module ? menu.module.module_id : null,
                    module_name: menu.module ? menu.module.module_name: null
                }
            },
            onReset(){
                this.formData = {
                    menu_id: null,
                    menu_name: null,
                    menu_text_eng: null,
                    menu_text_bng: null,
                    module_id: null,
                    menu_order_no: null,
                    active_yn: 'Y',
                    base_url: null,
                    icon: null,
                    bg_color: null,
                    base_path: null
                }
                this.selectedModule = {
                    module_id: null,
                    module_name: null
                }
                this.$v.$reset()
            }
        }
    }
</script>

<style scoped>

</style>
