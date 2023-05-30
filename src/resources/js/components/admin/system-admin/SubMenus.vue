<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-card>
        <b-card-header header-bg-variant="dark" header-text-variant="white">Sub-Menu</b-card-header>
        <b-card-body class="border">

          <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <b-row>
              <b-col>
                <b-form-group
                  label="Submenu Name"
                  label-cols-md="3"
                  label-for="submenu_name"
                >
                  <b-form-input id="submenu_name" v-model.trim="$v.formData.submenu_name.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.submenu_name.$error && !$v.formData.submenu_name.required}">Submenu name is required!</div>
                </b-form-group>
                <b-form-group
                  label="Submenu Text"
                  label-cols-md="3"
                  label-for="submenu_text_eng"
                >
                  <b-form-input id="submenu_text_eng" v-model.trim="$v.formData.submenu_text_eng.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.submenu_text_eng.$error && !$v.formData.submenu_text_eng.required}">Submenu Text is required!</div>
                </b-form-group>
                <b-form-group
                  label="Submenu Text (Bengali)"
                  label-cols-md="3"
                  label-for="submenu_text_bng"
                >
                  <b-form-input id="submenu_text_bng" v-model.trim="$v.formData.submenu_text_bng.$model"></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.submenu_text_bng.$error && !$v.formData.submenu_text_bng.required}">Submenu text (bengali) is required!</div>
                </b-form-group>
                <b-form-group
                  label="Parent Submenu"
                  label-cols-md="3"
                  label-for="parent_submenu_id"
                >
                  <v-select
                    v-model="selectedParentSubmenu"
                    :options="parentSubmenuOptions.filter(a=>a.submenu_id != this.formData.submenu_id)"
                    name="parent_submenu_id"
                    id="parent_submenu_id"
                    label="submenu_name"
                    class="uppercase">
                    <template #search="{attributes, events}">
                      <input class="vs__search" v-bind="attributes" v-on="events"/>
                    </template>
                  </v-select>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.parent_submenu_id.$error && !$v.formData.parent_submenu_id.required}">Parent submenu is required!</div>
                </b-form-group>
                <b-form-group
                  label="Menu"
                  label-cols-md="3"
                  label-for="menu_id"
                >
                  <v-select
                    v-model="selectedMenu"
                    :options="menuOptions"
                    name="menu_id"
                    id="menu_id"
                    label="menu_name"
                    class="uppercase">
                    <template #search="{attributes, events}">
                      <input class="vs__search" v-bind="attributes" v-on="events"/>
                    </template>
                  </v-select>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.menu_id.$error && !$v.formData.menu_id.required}">Menu is required!</div>
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group
                  label="Controller Name"
                  label-cols-md="3"
                  label-for="controller_name"
                >
                  <b-form-input
                    id="controller_name"
                    v-model.trim="$v.formData.controller_name.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.controller_name.$error && !$v.formData.controller_name.required}">Controller name is required!</div>
                </b-form-group>
                <b-form-group
                  label="Action Name"
                  label-cols-md="3"
                  label-for="action_name"
                >
                  <b-form-input
                    id="action_name"
                    v-model.trim="$v.formData.action_name.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.action_name.$error && !$v.formData.action_name.required}">Action name is required!</div>
                </b-form-group>
                <b-form-group
                  label="Route Name"
                  label-cols-md="3"
                  label-for="route_name"
                >
                  <b-form-input
                    id="route_name"
                    v-model.trim="$v.formData.route_name.$model"
                  ></b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.route_name.$error && !$v.formData.route_name.required}">Route name is required!</div>
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
        <b-card-header header-bg-variant="dark" header-text-variant="white">Sub-Menus</b-card-header>
        <b-card-body class="border">
          <Datatable :fields="fields" ref="table" :items="loadSubmenus" :totalList="totalList" :perPage="perPage" :update="update" @refreshed="update = false">
            <template v-slot:actions="{rows}">
              <b-link @click="edit(rows.item)" title="Edit"><i class="bx bx-edit cursor-pointer"></i></b-link>
            </template>
            <template v-slot:action2="{rows}">
              <span class="text-primary bx bx-check" v-if="rows.item.active_yn == 'Y'"></span>
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
        name: "SubMenus",
        components: {Datatable, vSelect, vcss},
        data() {
            return {
                update: false,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'submenu_name', label: 'Sub-Menu'},
                    {key: 'submenu_text_eng', label: 'Sub-Menu Text'},
                    {key: 'submenu_text_bng', label: 'Sub-Menu Text (Bengali)'},
                    {key: 'parent_submenu.submenu_name', label: 'Parent Sub-menu'},
                    {key: 'menu.menu_name', label: 'Menu'},
                    {key: 'controller_name', label: 'Controller'},
                    {key: 'action_name', label: 'Action'},
                    {key: 'route_name', label: 'Route'},
                    {key: 'menu_order_no', label: 'Order No.'},
                    {key: 'action2', label: 'Active', class: 'text-center'},
                    {key: 'action', class: 'text-center'}
                ],
                items: [],
                totalList: 0,
                perPage: 10,
                formData: {
                    submenu_id: null,
                    submenu_name: null,
                    submenu_text_eng: null,
                    submenu_text_bng: null,
                    parent_submenu_id: null,
                    menu_id: null,
                    controller_name: null,
                    action_name: null,
                    route_name: null,
                    menu_order_no: null,
                    active_yn: "Y"
                },
                selectedParentSubmenu: {
                    submenu_id: null,
                    submenu_name: null
                },
                selectedMenu: {
                    menu_id: null,
                    menu_name: null
                },
                parentSubmenuOptions: [],
                menuOptions: []
            }
        },
        validations: {
            formData: {
                submenu_id: {},
                submenu_name: {required},
                submenu_text_eng: {},
                submenu_text_bng: {},
                parent_submenu_id: {},
                menu_id: {required},
                controller_name: {},
                action_name: {},
                route_name: {},
                menu_order_no: {required},
                active_yn: {required}
            }
        },
        mounted() {
            this.loadMenus()
            this.loadSubmenuOptions()
        },
        watch: {
            selectedParentSubmenu(val, oldVal){
                if(val.submenu_id){
                    this.formData.parent_submenu_id = val.submenu_id
                }else{
                    this.formData.parent_submenu_id = null
                }
            },
            selectedMenu(val, oldVal){
                if(val.menu_id){
                    this.formData.menu_id = val.menu_id
                }else {
                    this.formData.menu_id = null
                }
            }
        },
        methods: {
            loadMenus(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/menus').then(response => {
                    this.menuOptions = response.data
                })
            },
            provider(items) {
            },
            loadSubmenus(ctx, callback){
                if(callback != undefined ){
                    this.provider = callback
                } else {
                    this.provider = this.provider
                }
                ctx.currentPage = ctx.currentPage == undefined ? 1 : ctx.currentPage
                ctx.perPage = ctx.perPage == undefined ? this.perPage : ctx.perPage
                ctx.filter = ctx.filter == undefined ? null : ctx.filter
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/sub-menus-datatable'+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter).then(response => {
                    let items = response.data.data
                    this.totalList = response.data.total
                    this.perPage = response.data.per_page
                    this.provider(items)
                })
            },
            loadSubmenuOptions(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/sub-menus').then(response => {
                    this.parentSubmenuOptions = response.data
                })
            },
            onSubmit(){
                this.$v.$touch();
                this.$v.formData.$touch();
                if (!this.$v.formData.$invalid){
                    if(!this.formData.submenu_id){
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/sub-menu', this.formData).then(response => {
                            this.onReset()
                            this.$notify({group: 'pmis', text: 'Data inserted successfully!', type: 'success'})
                            this.loadSubmenuOptions()
                            this.update = true
                        })
                    }else {
                        ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/sub-menu/${this.formData.submenu_id}`, this.formData).then(response => {
                            this.onReset()
                            this.$notify({group: 'pmis', text: 'Data updated successfully!', type: 'success'})
                            this.loadSubmenuOptions()
                            this.update = true
                        })
                    }

                }
            },
            edit(submenu){
                this.formData = {
                    submenu_id: submenu.submenu_id,
                    submenu_name: submenu.submenu_name,
                    submenu_text_eng: submenu.submenu_text_eng,
                    submenu_text_bng: submenu.submenu_text_bng,
                    parent_submenu_id: submenu.parent_submenu_id,
                    menu_id: submenu.menu_id,
                    controller_name: submenu.controller_name,
                    action_name: submenu.action_name,
                    route_name: submenu.route_name,
                    menu_order_no: submenu.menu_order_no,
                    active_yn: submenu.active_yn
                }
                this.selectedParentSubmenu = {
                    submenu_id: submenu.parent_submenu ? submenu.parent_submenu.submenu_id : null,
                    submenu_name: submenu.parent_submenu ? submenu.parent_submenu.submenu_name: null
                }
                this.selectedMenu = {
                    menu_id: submenu.menu.menu_id,
                    menu_name: submenu.menu.menu_name
                }
            },
            onReset(){
                this.formData = {
                    submenu_id: null,
                    submenu_name: null,
                    submenu_text_eng: null,
                    submenu_text_bng: null,
                    parent_submenu_id: null,
                    menu_id: null,
                    controller_name: null,
                    action_name: null,
                    route_name: null,
                    menu_order_no: null,
                    active_yn: "Y"
                }
                this.selectedParentSubmenu = {
                    submenu_id: null,
                    submenu_name: null
                }
                this.selectedMenu = {
                    menu_id: null,
                    menu_name: null
                }
                this.$v.$reset()
            }
        }
    }
</script>

<style scoped>

</style>
