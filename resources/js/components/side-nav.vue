<template>
  <div id="sidebar-menu">
    <ul id="side-menu" class="metismenu list-unstyled">
      <template>
        <li class="menu-title">Menu</li>
        <li>
          <a href="/" :class="{ active: isActive('') }" v-on:click="setActive('')">
            <i class="bx bx-home-circle"></i>
            <span>Dashboard</span>
          </a>
          <a href="/kasbon" :class="{ active: isActive('kasbon') }" v-on:click="setActive('kasbon')">
            <i class="bx bx-receipt"></i>
            <span>Kelola Pinjaman</span>
          </a>
          <a href="/user-management" :class="{ active: isActive('user-management') }" v-on:click="setActive('user-management')">
            <i class="bx bx bxs-user-detail"></i>
            <span>Data Karyawan</span>
          </a>
          <a href="/master-data" :class="{ active: isActive('master-data') }" v-on:click="setActive('master-data')">
            <i class="bx bx-receipt"></i>
            <span>Master Data</span>
          </a>
        </li>
      </template>
    </ul>
  </div>
</template>
<script>
export default {
  data() {
    return {
      activeItem: "",
    };
  },
  mounted(){
     this.activeItem = window.location.href.split("/")[3];
     console.log(this.activeItem);
  },
  methods: {
    isActive(menuItem) {
      return this.activeItem === menuItem;
    },
    setActive(menuItem) {
      this.activeItem = menuItem;
    },
    hasItems(item) {
      return item.subItems !== undefined ? item.subItems.length > 0 : false;
    },
  },
};
</script>


<style scoped>
.v-select .dropdown li {
  border-bottom: 1px solid rgba(112, 128, 144, 0.1);
}
.v-select .dropdown li:last-child {
  border-bottom: none;
}
.v-select .dropdown li a {
  padding: 10px 20px;
  width: 100%;
  font-size: 1.25em;
  color: #3c3c3c;
}
.v-select .dropdown-menu .active > a {
  color: #fff;
}
.v-select.open .dropdown-toggle {
  border-color: #009cd1;
}
.v-select input[type="search"],
.v-select input[type="search"]:focus {
  height: 28.3px;
}
.component-fade-enter-active,
.component-fade-leave-active {
  transition: opacity 0.3s ease;
}
.component-fade-enter, .component-fade-leave-to
        /* .component-fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.navigation,
.active {
  background-color: #f5f5f5;
  border-color: #c3c3c3;  
  border-left: #5d78e2 solid 5px;
  font-weight: bold;
  color: #5d78e2;
}
a:hover {
  font-weight: bold;
  background-color: #f5f5f5;
}

.second a:hover {
  color: rgb(0, 183, 255) !important;
}
</style>