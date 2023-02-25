<template>
  <Layout>
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div
          class="
            page-title-box
            d-flex
            align-items-center
            justify-content-between
          "
        >
          <h4 class="mb-0 font-size-18">Profile</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">Profile</li>
            </ol>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        
      </div>

  
    </div>
    
    <!-- end page title -->
  </Layout>
</template>
<script>
import Layout from "../../layouts/main.vue";

/**
 * Dashboard Component
 */
export default {
  components: { Layout },
  data() {
    return {
      title: "User Managament",
      isLoadingContent: false,
      karyawan: [],
    };
  },
  created() {
    // this.id = window.location.href.split("/")[7];
    // this.id_karyawan = window.location.href.split('/').pop();
    this.getDataPinjaman();
  },
  methods: {
    getDataPinjaman(page = 1) {
      this.isLoadingContent = true;
      this.$http
        .get("/api/get/data/pinjaman/karyawan/kasbon?page=" + page, {
          params: {
            id_karyawan: this.id_karyawan,
          },
        })
        .then((response) => {
          this.karyawan = response.data.karyawan;
          this.isLoadingContent = false;
        });
    },
    numberWithCommas(num) {
      if (typeof num === "undefined" || num === null) {
        // Do stuff
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      }
    },
  },
};
</script>
