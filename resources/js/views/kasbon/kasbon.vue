<template>
  <Layout>
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Kelola Pinjaman</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">Kelola Pinjaman</li>
            </ol>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <vue-element-loading :active="isLoadingContent" spinner="line-scale" />
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-5 mt-2">
                <label>Total Piutang Karyawan : {{'Rp.' + numberWithCommas(totalpiutang)}}</label> <br>
                <label class="mt-2">Total Terbayar : {{'Rp.' + numberWithCommas(totalterbayar)}}</label> <br>
                <label class="mt-2">Sisa Piutang : {{'Rp.' + numberWithCommas(totalpiutang - totalterbayar)}}</label>
              </div>
              <div class="col-2">
                <!-- <input
                  type="text"
                  class="form-control"
                  v-model="filter.nama_karyawan"
                  @keyup="getDataKaryawan"
                  placeholder="Cari Berdasarkan Nama"
                  style="float: right"
                /> -->
              </div>
              <div class="col-2">
                <!-- <select type="text" class="form-control" v-model="filter.bagian" @input="onChangeBagian($event)" style="float: right">
                   <option v-for="(bag,idx) in optionsbagian" :key="idx" selected>{{bag}}</option>
                </select> -->
              </div>
              <div class="col-3 mt-1" style="float: right">
                <a
                  href="/data/pinjaman/karyawan/export"
                  target="_blank"
                  type="button"
                  class="btn btn-sm btn-primary"
                  style="float: right"
                >
                  <i class="bx bx-cloud-download"></i> Download Rekap
                </a>
              </div>
            </div>
            <div class="row mb-5">
                <div class="col-2">
                  <label>Nama</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="filter.nama_karyawan"
                  @keyup="getDataKaryawan"
                  placeholder="Nama"
                  style="float: right"
                />
              </div>
              <div class="col-2">
                 <label>Group</label>
                 <v-select :options="optionsgroup" v-model="filter.group" @input="onChangeGroup($event)"></v-select>
              </div>
              <div class="col-2">
                 <label> Bagian </label>
                  <v-select :options="optionsbagian" v-model="filter.bagian" @input="onChangeBagian($event)"></v-select>
              </div>
              <div class="col-2">
                 <label> Pekerjaan </label>
                  <v-select :options="optionspekerjaan" v-model="filter.pekerjaan" @input="onChangePekerjaan($event)"></v-select>
              </div>
            </div>

            <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-block-helper me-2"></i>
                  Data Tidak di Temukan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> -->
            <div  class="table-responsive">
              <table class="table mb-0">
                <thead class="table-light">
                  <tr>
                    <th class="align-middle">Foto</th>
                    <th class="align-middle">Nama Karyawan</th>
                    <th class="align-middle">Group</th>
                    <th class="align-middle">Pekerjaan</th>
                    <th class="align-middle">Bagian</th>
                    <th class="align-middle">Tanggal Bayar Terakhir</th>
                    <th class="align-middle">Sisa Piutang</th>
                    <th class="align-right">
                      <i class="bx bxs-cog"></i>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(kry, idxk) in karyawan.data" :key="idxk">
                    <td>
                      <img
                        v-if="kry.foto == null"
                        src="https://www.praxisemr.com/images/testimonials_images/dr_profile.jpg"
                        alt=""
                        class="avatar-md h-auto d-block rounded"
                      />
                      <img
                        v-else
                        :src="'storage/images/foto/'+ kry.foto"
                        alt=""
                        class="avatar-md d-block rounded"
                        height="70px"
                      />
                    </td>
                    <td>
                      <h5 class="font-size-13 text-truncate mt-3">
                        {{ kry.nama_karyawan }}
                      </h5>
                    </td>
                    <td>
                      <h5 class="font-size-13 text-truncate mt-3">
                        {{ kry.group }}
                      </h5>
                    </td>
                    <td>
                      <h5 class="font-size-13 text-truncate mt-3">
                        {{ kry.pekerjaan }}
                      </h5>
                    </td>
                    <td>
                      <h5 class="font-size-13 text-truncate mt-3">
                        {{ kry.bagian }}
                      </h5>
                    </td>
                    <td>
                      <h5 class="font-size-13 text-truncate mt-3">
                        {{ kry.one_pinjaman == null ? 'Belum Ada data Pembayaran' : formattglindo(kry.one_pinjaman.tanggal) }}
                      </h5>
                    </td>
                    <td>
                      <h5 class="font-size-13 text-truncate mt-3">
                        <span class="badge badge-pill badge-soft-danger font-size-11">
                          Rp .  {{ kry.one_pinjaman == null ? ' - ' : numberWithCommas(kry.one_pinjaman.sisa_pinjaman) }}
                        </span>
                      </h5>
                    </td>
                    <td>
                      <a  :href="'/kasbon/detail/' + kry.hashid" type="button" v-tooltip="'Lihat Detail'" class="text-primary mt-3">
                          <i class="dripicons-document-edit" style="font-size: 1.20em;"></i>
                      </a>
                    <span class="text-success mt-3">
                        <a :href="'/data/pinjaman/karyawan/export/' + kry.hashid" target="_blank" type="button">
                          <i class="mdi mdi-download" style="font-size: 1.63em;"></i>
                        </a>
                    </span>
                      
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination
                  class="pagination pagination-rounded justify-content-center mt-4"
                  :data="karyawan"
                  @pagination-change-page="getDataKaryawan"
                  :limit="3"
             ></pagination>
            </div>
               
            <!-- end table-responsive -->
          </div>
        </div>
      </div>
    </div>

    <!-- end page title -->
  </Layout>
</template>
<script>
import Layout from "../../layouts/main.vue";
import moment from "moment";


/**
 * Dashboard Component
 */
export default {
  components: { Layout},
  data() {
    return {
      title: "Kasbon",
      isLoadingContent: false,
      karyawan: [],
      optionsbagian:[],
      optionsgroup:[],
      optionspekerjaan:[],
      totalpiutang:0,
      totalterbayar:0,
       meta: {
        current_page: 0,
        per_page: 0,
        total: "",
      },
      filter:{
        nama_karyawan:'',
        group:'',
        bagian:'',
        kode_karyawn:'',
      },
    };
  },
  created() {
    this.getDataKaryawan();
  },
  methods: {
    getDataKaryawan(page = 1) {
      this.isLoadingContent = true;
      this.$http
        .get("/api/get/data/karyawan/kasbon?page=" + page, {
          params: {
            nama_karyawan: this.filter.nama_karyawan,
            group : this.filter.group,
            bagian: this.filter.bagian,
            kode_karyawn: this.filter.kode_karyawn
          },
        })
        .then((response) => {
          this.karyawan       = response.data.data;
          this.meta.total     = response.data.data.total;
          this.totalpiutang =  response.data.totalpiutang;
          this.totalterbayar =  response.data.totalterbayar;
          this.optionsbagian = response.data.optionsbagian;
          this.optionspekerjaan = response.data.optionspekerjaan;
          this.optionsgroup = response.data.optionsgroup;
          this.isLoadingContent = false;
        });
    },
    onChangeGroup(event){
        if (event === null) {
          this.filter.group = null;
        } else {
          this.filter.group = event;
        }
          this.getDataKaryawan();
    },
    onChangeBagian(event){
      if (event === null) {
        this.filter.bagian = null;
      } else {
        this.filter.bagian = event;
      }
      this.getDataKaryawan();
     
    },
    onChangePekerjaan(event){
       if (event === null) {
        this.filter.pekerjaan = null;
      } else {
        this.filter.pekerjaan = event;
      }
      this.getDataKaryawan();
    },
    formattglindo(value) {
      return moment(value).locale("id").format("LL");
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