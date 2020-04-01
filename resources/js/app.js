require("./bootstrap");

window.Vue = require("vue");

//Custom components
import PCreateButton from "./components/buttons/PCreateButton";
import PDeleteButton from "./components/buttons/PDeleteButton";
import PLinkButton from "./components/buttons/PLinkButton";
Vue.component("p-create-button", PCreateButton);
Vue.component("p-delete-button", PDeleteButton);
Vue.component("p-link-button", PLinkButton);

import PCategoryForm from "./components/forms/PCategoryForm.vue";
import PProductForm from "./components/forms/PProductForm";
Vue.component("p-category-form", PCategoryForm);
Vue.component("p-product-form", PProductForm);

import PSelectInput from "./components/inputs/PSelectInput";
import PTextInput from "./components/inputs/PTextInput";
Vue.component("p-select-input", PSelectInput);
Vue.component("p-text-input", PTextInput);

import PCategoriesTable from "./components/models/category/PCategoriesTable";
import PCategoryDetails from "./components/models/category/PCategoryDetails";
import PCreateCategory from "./components/models/category/PCreateCategory";
import PUpdateCategory from "./components/models/category/PUpdateCategory";
Vue.component("p-create-category", PCreateCategory);
Vue.component("p-update-category", PUpdateCategory);
Vue.component("p-category-details", PCategoryDetails);
Vue.component("p-categories-table", PCategoriesTable);

import PCreateProduct from "./components/models/product/PCreateProduct";
import PProductDetails from "./components/models/product/PProductDetails";
import PProductsTable from "./components/models/product/PProductsTable";
import PUpdateProduct from "./components/models/product/PUpdateProduct";
Vue.component("p-create-product", PCreateProduct);
Vue.component("p-product-details", PProductDetails);
Vue.component("p-products-table", PProductsTable);
Vue.component("p-update-product", PUpdateProduct);

import PStakeholdersTable from "./components/models/stakeholder/PStakeholdersTable";
Vue.component("p-stakeholders-table", PStakeholdersTable);

import PCrudModal from "./components/PCrudModal";
import PModalFooter from "./components/PModalFooter";
Vue.component("p-crud-modal", PCrudModal);
Vue.component("p-modal-footer", PModalFooter);

//Custom formatters
import { percentageFormatter } from "./formatter";
import { moneyFormatter } from "./formatter";
import { dateTimeFormatter } from "./formatter";

Vue.filter("percentage", percentageFormatter);
Vue.filter("money", moneyFormatter);
Vue.filter("dateTime", dateTimeFormatter);

// Bootstrap-vue
import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);

//Vee-Validate
import VeeValidate from "vee-validate";
Vue.use(VeeValidate);

// Vue-font-awesome
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faEye,
    faEdit,
    faTrash,
    faTimes,
    faSave,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faEye, faEdit, faTrash, faTimes, faSave);

Vue.component("font-awesome-icon", FontAwesomeIcon);

//Translation
import _ from "lodash";
window.Vue.prototype.trans = (string) => _.get(window.i18n, string);

window.Vue.prototype.transChoice = (string, plural, args) => {
    let value = _.get(window.i18n, string);

    if (plural === 1) {
        value = value.split("|")[0];
    } else if (plural === 0 || plural > 1) {
        value = value.split("|")[1];
    }

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});
