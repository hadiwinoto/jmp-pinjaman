import Vue from "vue";
// Use it to import all Vue file containing this folder as Components
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("home", require("./home").default);
Vue.component("kasbon", require("./kasbon/kasbon").default);
Vue.component("detail", require("./kasbon/detail").default);
Vue.component("user-management", require("./management/UserManagement").default);
Vue.component("user-profile", require("./management/Profile").default);
Vue.component("master-data", require("./management/MasterData").default);

Vue.component("login", require("./account/login").default);
Vue.component("register", require("./account/register").default);
Vue.component("forgot-password", require("./account/forgot-password").default);
Vue.component("reset-password", require("./account/reset-password").default);

Vue.component("pages-404", require("./utility/404").default);
Vue.component("pages-500", require("./utility/500").default);
