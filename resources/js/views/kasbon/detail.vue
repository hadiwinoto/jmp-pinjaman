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
          <h4 class="mb-0 font-size-18">Detail</h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">Detail Pinjaman</li>
            </ol>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <vue-element-loading
            :active="isLoadingContent"
            spinner="line-scale"
          />
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 col-7">
                <h4 class="card-title" style="text-transform: uppercase">
                  {{ karyawan.nama_karyawan }}
                </h4>
                <span class="text-muted"
                  ><h6>{{ karyawan.kode_karyawan }}</h6></span
                >
              </div>
              <div class="col-md-8 col-3">
                <ul class="list-inline user-chat-nav text-end mb-0">
                  <li class="list-inline-item d-none d-sm-inline-block">
                    <div>
                      <img
                        v-if="karyawan.foto == null"
                        width="150px"
                        height="100px"
                        src="https://www.praxisemr.com/images/testimonials_images/dr_profile.jpg"
                        alt=""
                        class="img-thumbnail"
                      />
                      <img
                        v-else
                        :src="'/storage/images/foto/' + karyawan.foto"
                        width="150px"
                        height="150px"
                        alt=""
                      />
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="row mb-5">
              <h5 class="font-size-15 mb-3">Daftar Piutang</h5>
              <div class="row">
                <div class="col-md-4 col-9">
                  <p class="text-muted mb-0">
                    Sisa Piutang :
                    <span
                      class="badge badge-pill badge-soft-danger font-size-11"
                    >
                      Rp . {{ numberWithCommas(sisa_piutang) }}
                    </span>
                    <!-- <span
                      v-else
                      class="badge badge-pill badge-soft-success font-size-11"
                    >
                      Lunas
                    </span> -->
                  </p>
                </div>
                <div class="col-md-8 col-3">
                  <ul class="list-inline user-chat-nav text-end mb-0">
                    <li class="list-inline-item d-none d-sm-inline-block">
                      <button
                        @click="showModal = true"
                        type="button"
                        style="align: right"
                        data-toggle="modal"
                        data-target="#exampleModal"
                        class="btn btn-primary btn-sm"
                      >
                        Pinjaman Langsung
                      </button>
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                      <button
                        @click="showModalBayar = true"
                        type="button"
                        style="align: right"
                        class="btn btn-primary btn-sm waves-effect waves-light"
                      >
                        Bayar Langsung
                      </button>
                    </li>
                    <li class="list-inline-item">
                      <a
                        :href="'/data/pinjaman/karyawan/export/' + id_karyawan"
                        target="_blank"
                        type="button"
                        style="align: right"
                        class="btn btn-primary btn-sm waves-effect waves-light"
                      >
                        <i class="bx bx-cloud-download"></i> Unduh Rekap</a
                      >
                    </li>
                  </ul>
                </div>

                <!-- modal bayar -->
                <b-modal
                  id="modal-standard"
                  v-model="showModal"
                  title="Pinjaman Langsung"
                  top
                >
                  <!-- <label>Pinjaman Langsung</label> -->
                  <form>
                    <div class="row mb-4">
                      <label
                        for="horizontal-firstname-input"
                        class="col-sm-3 col-form-label"
                      >
                        Tanggal <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <datepicker
                          v-model="kasbon.tanggal"
                          :bootstrap-styling="true"
                          :language="languages['id']"
                          format="d MMMM yyyy"
                          required
                        >
                        </datepicker>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label
                        for="horizontal-email-input"
                        class="col-sm-3 col-form-label"
                        >Jumlah <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <input
                          v-model="kasbon.tambah_pinjaman"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label"
                        >Keterangan <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <textarea
                          type="text"
                          v-model="kasbon.keterangan"
                          rows="5"
                          class="form-control"
                          required
                        ></textarea>
                      </div>
                    </div>
                  </form>
                  <template v-slot:modal-footer>
                    <button
                      :disabled="buttondisabled"
                      type="button"
                      @click="onSubmitPinjamanLangsung"
                      class="btn btn-primary w-md"
                    >
                      <span
                        :class="buttonloading"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      Submit
                    </button>
                    <b-button variant="secondary" @click="showModal = false">Close</b-button>
                  </template>
                </b-modal>


                 <b-modal
                  id="modal-standard"
                  v-model="showModalEdit"
                  title="Edit"
                  top
                >
                  <!-- <label>Pinjaman Langsung</label> -->
                  <form>
                     <vue-element-loading
                      :active="isLoadingContentEdit"
                      spinner="spinner"
                    />
                    <div class="row mb-4">
                      <label
                        for="horizontal-firstname-input"
                        class="col-sm-3 col-form-label"
                      >
                        Tanggal <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <datepicker
                          v-model="edit.tanggal"
                          :bootstrap-styling="true"
                          :language="languages['id']"
                          format="d MMMM yyyy"
                          required
                        >
                        </datepicker>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label
                        for="horizontal-email-input"
                        class="col-sm-3 col-form-label"
                        >Jumlah <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <input
                          v-model="edit.tambah_pinjaman"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label
                        for="horizontal-email-input"
                        class="col-sm-3 col-form-label"
                        >Pembayaran <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <input
                          v-model="edit.pembayaran"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label"
                        >Keterangan <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <textarea
                          type="text"
                          v-model="edit.keterangan"
                          rows="5"
                          class="form-control"
                          required
                        ></textarea>
                      </div>
                    </div>
                  </form>
                  <template v-slot:modal-footer>
                    <button
                      :disabled="buttondisabled"
                      type="button"
                      @click="onSubmitEditData"
                      class="btn btn-primary w-md"
                    >
                      <span
                        :class="buttonloading"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      Submit
                    </button>
                    <b-button variant="secondary" @click="showModalEdit = false">Close</b-button>
                  </template>
                </b-modal>

                <b-modal
                  id="modal-standard"
                  v-model="showModalBayar"
                  title="Bayar Langsung"
                  top
                >
                  <!-- <label>Pinjaman Langsung</label> -->
                  <form>
                    <div class="row mb-4">
                      <label
                        for="horizontal-firstname-input"
                        class="col-sm-3 col-form-label"
                      >
                        Tanggal <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <datepicker
                          :bootstrap-styling="true"
                          v-model="bayar.tanggal"
                          :language="languages['id']"
                          format="d MMMM yyyy"
                          required
                        >
                        </datepicker>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label
                        for="horizontal-email-input"
                        class="col-sm-3 col-form-label"
                        >Jumlah <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <input
                          type="number"
                          v-model="bayar.pembayaran"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label"
                        >Keterangan <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <textarea
                          type="text"
                          v-model="bayar.keterangan"
                          rows="5"
                          class="form-control"
                          required
                        ></textarea>
                      </div>
                    </div>
                  </form>
                  <template v-slot:modal-footer>
                    <button
                      @click="onSubmitBayarLangsung"
                      type="button"
                      :disabled="buttondisabled"
                      class="btn btn-primary w-md"
                    >
                      <span
                        :class="buttonloading"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      Submit
                    </button>
                    <b-button
                      variant="secondary"
                      @click="showModalBayar = false"
                      >Close</b-button
                    >
                  </template>
                </b-modal>




                 <b-modal
                  id="modal-standard"
                  v-model="showModalEditBayar"
                  title="Bayar Langsung"
                  top
                >
                  <!-- <label>Pinjaman Langsung</label> -->
                  <form>
                    <vue-element-loading
                      :active="isLoadingContentEdit"
                      spinner="spinner"
                    />
                    <div class="row mb-4">
                      <label
                        for="horizontal-firstname-input"
                        class="col-sm-3 col-form-label"
                      >
                        Tanggal <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <datepicker
                          :bootstrap-styling="true"
                          v-model="edit.tanggal"
                          :language="languages['id']"
                          format="d MMMM yyyy"
                          required
                          readonly
                        >
                        </datepicker>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label
                        for="horizontal-email-input"
                        class="col-sm-3 col-form-label"
                        >Jumlah <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <input
                          type="number"
                          v-model="edit.pembayaran"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label"
                        >Keterangan <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <textarea
                          type="text"
                          v-model="edit.keterangan"
                          rows="5"
                          class="form-control"
                          required
                          readonly
                        ></textarea>
                      </div>
                    </div>
                  </form>
                  <template v-slot:modal-footer>
                    <button
                      @click="onSubmitEditData"
                      type="button"
                      :disabled="buttondisabled"
                      class="btn btn-primary w-md"
                    >
                      <span
                        :class="buttonloading"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      Submit
                    </button>
                    <b-button
                      variant="secondary"
                      @click="showModalEditBayar = false"
                      >Close</b-button
                    >
                  </template>
                </b-modal>
              
              
                 <b-modal
                  id="modal-standard"
                  v-model="showModalEditPinjaman"
                  title="Pinjaman Langsung"
                  top
                >
                  <!-- <label>Pinjaman Langsung</label> -->
                  <form>
                    <vue-element-loading
                      :active="isLoadingContentEdit"
                      spinner="spinner"
                    />
                    <div class="row mb-4">
                      <label
                        for="horizontal-firstname-input"
                        class="col-sm-3 col-form-label"
                      >
                        Tanggal <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <datepicker
                          :bootstrap-styling="true"
                          v-model="edit.tanggal"
                          :language="languages['id']"
                          format="d MMMM yyyy"
                          required
                          readonly
                        >
                        </datepicker>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label
                        for="horizontal-email-input"
                        class="col-sm-3 col-form-label"
                        >Pinjaman <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <input
                          type="number"
                          v-model="edit.tambah_pinjaman"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label"
                        >Keterangan <span class="text-danger">*</span></label
                      >
                      <div class="col-sm-9">
                        <textarea
                          type="text"
                          v-model="edit.keterangan"
                          rows="5"
                          class="form-control"
                          required
                          readonly
                        ></textarea>
                      </div>
                    </div>
                  </form>
                  <template v-slot:modal-footer>
                    <button
                      @click="onSubmitEditData"
                      type="button"
                      :disabled="buttondisabled"
                      class="btn btn-primary w-md"
                    >
                      <span
                        :class="buttonloading"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      Submit
                    </button>
                    <b-button
                      variant="secondary"
                      @click="showModalEditPinjaman = false"
                      >Close</b-button
                    >
                  </template>
                </b-modal>
              
              </div>
              
            </div>

            

            <div
              v-if="pinjaman.length === 0"
              class="alert alert-info alert-dismissible fade show mb-0"
              role="alert"
            >
              <i class="mdi mdi-alert-circle-outline me-2"></i>
              Data Tidak Di temukan
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
              ></button>
            </div>
            <div v-else class="table-responsive">
              <table class="table table-striped mb-0">
                <thead class="table-light">
                  <tr>
                    <th class="align-middle">Tanggal</th>
                    <th class="align-middle">Jenis</th>
                    <th class="align-middle">Keterangan</th>
                    <th class="align-middle">Tambah Pinjaman</th>
                    <th class="align-middle">Pembayaran</th>
                    <th class="align-middle">Sisa Pinjaman</th>
                    <th class="text-center">
                      <i class="bx bxs-cog"></i>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(pnj, idxpnj) in pinjaman.data" :key="idxpnj">
                    <td>
                      {{ formattglindo(pnj.tanggal) }}
                    </td>
                    <td>
                      {{ pnj.jenis }}
                    </td>
                    <td>
                      {{ pnj.keterangan }}
                    </td>
                    <td>
                      <span
                        v-if="pnj.tambah_pinjaman > 0"
                        class="badge badge-pill badge-soft-primary font-size-11"
                      >
                        <a @click="openModalEditPinjaman(pnj.hashid)">{{ numberWithCommas("Rp . " + pnj.tambah_pinjaman) }}</a>
                        
                      </span>
                      <span v-else> - </span>
                    </td>
                    <td>
                      <span
                        v-if="pnj.pembayaran > 0"
                        class="badge badge-pill badge-soft-success font-size-11"
                      >
                      <a @click="openModalEditPembayaran(pnj.hashid)"> {{ numberWithCommas(" Rp . " + pnj.pembayaran) }} </a>
                        
                      </span>
                      <span v-else> - </span>
                    </td>
                    <td>
                      <span
                        class="badge badge-pill badge-soft-danger font-size-11"
                        >Rp . {{ numberWithCommas(pnj.sisa_pinjaman) }}</span
                      >
                    </td>
                    <td class="text-center">
                        <!-- <a  @click="fetchById(pnj.hashid)" type="button" v-tooltip="'Lihat Detail'" class="text-primary">
                            <i class="dripicons-document-edit" style="font-size: 1.20em;"></i>
                        </a> -->
                        <a  @click="open(pnj.hashid)" type="button" v-tooltip="'Lihat Detail'" class="text-danger">
                             <i class="bx bx-trash-alt" style="font-size: 1.20em;"></i>
                        </a>
                    </td>
                  </tr>
                </tbody>
              </table>
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
import Datepicker from "vuejs-datepicker";
import * as lang from "vuejs-datepicker/src/locale";
import moment from "moment";
import { VMoney } from "v-money";

/**
 * Dashboard Component
 */
export default {
  components: { Layout, Datepicker, VMoney },
  data() {
    return {
      id: null,
      label: "Test",
      languages: lang,
      title: "Detail",
      id_karyawan: null,
      isLoadingContent: false,
      showModal: false,
      showModalBayar: false,
      showModalEdit:false,
      showModalEditBayar:false,
      showModalEditPinjaman: false,
      buttondisabled: false,
      isLoadingContentEdit:false,
      buttonloading: "",
      karyawan: {},
      pinjaman: [],
      validasi:'',
      kasbon: {
        tanggal: null,
        tambah_pinjaman: null,
        keterangan: null,
      },
      edit: {
        tanggal: null,
        pembayaran: null,
        tambah_pinjaman:null,
        keterangan: null,
      },
      bayar: {
        tanggal: "",
        pembayaran: 0,
        keterangan: "",
      },
      nama: "",
      money: {
        decimal: ",",
        thousands: ".",
        precision: 0,
        masked: false,
      },
      sisa_piutang:0,
    };
  },
  created() {
    // this.id = window.location.href.split("/")[7];
    this.id_karyawan = window.location.href.split("/").pop();
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
          this.pinjaman = response.data.pinjaman;
          this.sisa_piutang =  response.data.sisa_piutang;
          this.isLoadingContent = false;
        });
    },
    checkFormKasbon(){
      if(this.kasbon.tanggal && this.kasbon.keterangan !== null){
        this.validasi = 'oke'; 
      }else{
        this.validasi = 'null';
      }
    },
    checkFormBayar(){
      if(this.bayar.tanggal && this.bayar.keterangan !== null){
        this.validasi = 'oke'; 
      }else{
        this.validasi = 'null';
      }
    },
    onSubmitPinjamanLangsung() {
      this.checkFormKasbon();
      if(this.validasi === 'oke'){
              let datasubmit = {
                id_karyawan: this.id_karyawan,
                data: this.kasbon,
              };
              this.buttonloading = "spinner-border spinner-border-sm";
              this.buttondisabled = true;
              this.$http
                .post("/api/pinjaman/langsung", datasubmit)
                .then((response) => {
                  this.$awn.success("Berhasil submit Data");
                  this.buttonloading = "";
                  this.buttondisabled = false;
                  this.showModal = false;
                  this.getDataPinjaman();
                })
                .catch((error) => {
                  this.$awn.alert("Error");
                  this.buttonloading = "";
                  this.buttondisabled = false;
                });
      }else{
            this.$awn.alert("Semua Field Wajib diisi");
      }
    },

    openModalEditPembayaran(id){
        this.fetchById(id);
        this.showModalEditBayar = true;
        this.isLoadingContentEdit = true;
    },
    openModalEditPinjaman(id){
        this.fetchById(id);
        this.showModalEditPinjaman = true;
        this.isLoadingContentEdit = true;
    },
    fetchById(id){
      // this.showModalEdit = true;
      this.isLoadingContentEdit = true;
      this.$http
        .get("/api/get/data/pinjaman/karyawan/kasbonbyid",{
          params: {
            id: id,
          },
        })
        .then((response) => {
          this.edit = response.data.data;
          this.isLoadingContentEdit = false;
        });
    },
    onSubmitBayarLangsung() {
      this.checkFormBayar();
      if(this.validasi === 'oke'){
         let datasubmit = {
            id_karyawan: this.id_karyawan,
            data: this.bayar,
         };
        this.buttonloading = "spinner-border spinner-border-sm";
        this.buttondisabled = true;
        this.$http
          .post("/api/bayar/langsung", datasubmit)
          .then((response) => {
            this.$awn.success("Berhasil submit Data");
            this.buttonloading = "";
            this.buttondisabled = false;
            this.showModalBayar = false;
            this.getDataPinjaman();
          })
          .catch((error) => {
            // this.$awn.alert("Error");
            this.buttonloading = "";
            this.buttondisabled = false;
          });
      }else{
          this.$awn.alert("Semua Field Wajib Diisi");
      }
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
    onSubmitEditData(){
         let datasubmit = {
            id_karyawan: this.id_karyawan,
            data: this.edit,
         };
        this.buttonloading = "spinner-border spinner-border-sm";
        this.buttondisabled = true;
        this.$http
          .post("/api/datakasbon/edit", datasubmit)
          .then((response) => {
            this.$awn.success("Berhasil submit Data");
            this.buttonloading = "";
            this.buttondisabled = false;
            this.showModalEditPinjaman = false;
            this.showModalEditBayar = false;
            this.getDataPinjaman();
          })
          .catch((error) => {
            this.$awn.alert("Error");
            this.buttonloading = "";
            this.buttondisabled = false;
            this.showModalEditPinjaman = false;
            this.showModalEditBayar = false;
          });

    },
    open(id) {
        this.id = id;
        this.$confirm('Hapus Data Berikut ?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.deleteData(this.id);
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Canceled'
          });          
        });
    },
    deleteData(id){
      this.id = id;
      let datasubmit = {
        id: this.id,
      };
      this.$http
        .post("/api/datakasbon/delete", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil Hapus Data");
          this.getDataPinjaman();
          this.id = null;
        })
        .catch((error) => {
          this.$awn.alert("Gagal Hapus Data");
        });
    }


  },
};
</script>
