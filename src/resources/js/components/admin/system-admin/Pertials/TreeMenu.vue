<template>
    <div>
    <ul id="myUL">
        <li v-for="menu in menus">
                <b-form-checkbox
                        :id="'menu_'+menu.menu_id"
                        v-model="menu.permitted"
                        :name="'menu_'+menu.menu_id"
                        value=true
                        unchecked-value=""
                >
                    {{menu.menu_name}}
                </b-form-checkbox>
            <ul v-if="menu.sub_menus.length>0" :class="{active:menu.permitted}" class="nested">
                <li v-for="sub_menu in menu.sub_menus">
                        <b-form-checkbox
                                :id="'sub_menu_'+sub_menu.submenu_id"
                                v-model="sub_menu.permitted"
                                :name="'sub_menu'+sub_menu.submenu_id"
                                value=true
                                unchecked-value="">
                            {{sub_menu.submenu_name}}
                        </b-form-checkbox>
                    <ul v-if="sub_menu.submenus.length>0" :class="{active:sub_menu.permitted}" class="nested" >
                        <li v-for="submenu in sub_menu.submenus">
                            <b-form-checkbox
                                    :id="'submenu_'+submenu.submenu_id"
                                    v-model="submenu.permitted"
                                    :name="'submenu'+submenu.submenu_id"
                                    value=true
                                    unchecked-value="">
                                {{submenu.submenu_name}}
                            </b-form-checkbox>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    </div>
</template>

<script>
    import ApiRepository from "../../../../Repository/ApiRepository";

    export default {
        props:['menus'],
        data() {
            return {
            }
        },
        mounted() {
        }
    }

</script>
<style scoped>

    /* Remove default bullets */
    ul, #myUL {
        list-style-type: none;
    }

    /* Remove margins and padding from the parent ul */
    #myUL {
        margin: 0;
        padding: 0;
    }

    /* Style the caret/arrow */
    .caret {
        cursor: pointer;
        user-select: none; /* Prevent text selection */
        float:left;
    }

    /* Create the caret/arrow with a unicode, and style it */
    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    /* Rotate the caret/arrow icon when clicked on (using JavaScript) */
    .caret-down::before {
        transform: rotate(90deg);
    }

    /* Hide the nested list */
    .nested {
        display: none;
    }

    /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
    .active {
        display: block;
    }
</style>
