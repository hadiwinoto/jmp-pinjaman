<template>
  <Layout>
   <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                            <i class="bx bx-copy-alt"></i>
                                                        </span>
                                                    </div>
                                                    <h5 class="font-size-14 mb-0">Total Piutang Karyawan</h5>
                                                </div>
                                                <div class="text-muted mt-4">
                                                    <h4> {{numberWithCommas('Rp. ' + totalpiutang)}}</h4>
                                                    <div class="d-flex">
                                                        <span class="badge badge-soft-success font-size-12"> </span> <span class="ms-2 text-truncate"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                            <i class="bx bx-archive-in"></i>
                                                        </span>
                                                    </div>
                                                    <h5 class="font-size-14 mb-0">Pinjaman Terbesar</h5>
                                                </div>
                                                <div class="text-muted mt-4">
                                                    <h4>
                                                        {{numberWithCommas('Rp. ' + pinjamanterbesar.nominal_kasbon)}}
                                                    </h4>
                                                    <div class="d-flex">
                                                        <span class="badge badge-soft-success font-size-12"> </span> <span class="ms-2 text-truncate"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                            <i class="bx bx-purchase-tag-alt"></i>
                                                        </span>
                                                    </div>
                                                    <h5 class="font-size-14 mb-0">Pinjaman Terakhir</h5>
                                                </div>
                                                <div class="text-muted mt-4">
                                                    <h4 v-if="pinjamanterakhir.tanggal != null">
                                                       {{formattglindo(pinjamanterakhir.tanggal)}}
                                                    </h4>
                                                    <h4 class="text-danger" v-else>
                                                       Data tidak di temukan !!
                                                    </h4>
                                                    <div class="d-flex">
                                                        <span class="badge badge-soft-warning font-size-12"></span> <span class="ms-2 text-truncate"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>

                       
                        <!-- end row -->

                    </div>


  
  </Layout>
</template>
<script>
import Layout from "../layouts/main";
import Datepicker from "vuejs-datepicker";
import * as lang from "vuejs-datepicker/src/locale";
import moment from "moment";

/**
 * Dashboard Component
 */
export default {
  components: { Layout, Datepicker },
  data() {
    return {
      title: "Dashboard",
      totalpiutang:0,
      pinjamanterbesar:0,
      pinjamanterakhir:[],
    };
  },
  mounted() {

  },
  created(){
    this.getDataDashboard();
  },
  methods:{
    getDataDashboard() {
      this.isLoadingContent = true;
      this.$http
        .get("/data/dashboard")
        .then((response) => {
          this.totalpiutang = response.data.totalpiutang;
          this.pinjamanterbesar = response.data.pinjamanterbesar;
          this.pinjamanterakhir = response.data.pinjamanterakhir;
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
    formattglindo(value) {
      return moment(value).locale("id").format("LL");
    },
  }
};
</script>
