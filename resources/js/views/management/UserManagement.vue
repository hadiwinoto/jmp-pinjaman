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
          ">
          <h4 class="mb-0 font-size-18">KARYAWAN</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">Data Karyawan</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-2">
                <div>
                  <label class="form-label">Nama</label>
                  <input
                    class="form-control"
                    v-model="filter.nama_karyawan"
                    @keyup="getDataKaryawan"
                    type="text"
                    placeholder="Nama"
                  />
                </div>
              </div>
              <div class="col-lg-2">
                <div>
                  <label class="form-label">Group</label>
                  <v-select
                    :options="optionsgroup"
                    v-model="filter.group"
                    @input="onChangeGroup($event)"
                  ></v-select>
                </div>
              </div>
              <div class="col-lg-2">
                <div>
                  <label class="form-label">Pekerjaan</label>
                  <v-select
                    :options="optionspekerjaan"
                    v-model="filter.pekerjaan"
                    @input="onChangePekerjaan($event)"
                  ></v-select>
                </div>
              </div>
               <div class="col-lg-2">
                <div>
                  <label class="form-label">Bagian</label>
                  <v-select
                    :options="optionsbagian"
                    v-model="filter.bagian"
                    @input="onChangeBagian($event)"
                  ></v-select>
                </div>
              </div>
              <div class="col-lg-2">
                <div>
                  <label class="form-label">Kode Karyawan</label>
                  <input
                    class="form-control"
                    v-model="filter.kode_karyawan"
                    @keyup="getDataKaryawan"
                    type="text"
                  />
                </div>
              </div>
              <div class="col-lg-2">
                <div class="mt-2">
                  <br />
                  <label class="form-label">&nbsp;</label>
                  <button
                    type="button"
                    @click="showModal = true"
                    data-toggle="modal"
                    data-target="#exampleModal"
                    class="btn btn-primary"
                  >
                    <i class="bx bx-user-plus mr-2"></i>Tambah
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <vue-element-loading :active="isLoadingContent" spinner="line-scale" />

      <div class="col-lg-12">
        <!--<div
          v-if="karyawan.data.length == 0"
          class="alert alert-danger alert-dismissible fade show"
          role="alert"
        >
          <i class="mdi mdi-block-helper me-2"></i>
          Data Tidak di Temukan
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
        </div> -->
        
        <div  class="row">
          <template v-for="(kry, idxkry) in karyawan.data">
            <div :key="idxkry" class="col-xl-3 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="rounded avatar-lg mx-auto mb-4">
                    <span
                      v-if="kry.foto == null"
                      class="
                        avatar-title
                        rounded
                        bg-primary bg-soft
                        text-primary
                        font-size-16
                        mt-3
                      "
                    >
                      <img
                        src="https://www.praxisemr.com/images/testimonials_images/dr_profile.jpg"
                        width="320px"
                        height="130px"
                      />
                    </span>
                    <span
                      v-else
                      class="
                        avatar-title
                        rounded
                        bg-primary bg-soft
                        text-primary
                        font-size-16
                        mt-3
                      "
                    >
                      <img
                        :src="'storage/images/foto/' + kry.foto"
                        width="320px"
                        height="130px"
                      />
                    </span>
                  </div>
                  <h5 class="font-size-15 mb-1">
                    <a href="javascript: void(0);" class="text-dark">{{
                      kry.nama_karyawan
                    }}</a>
                  </h5>
                  <p class="text-muted">{{ kry.kode_karyawan }}</p>

                  <div>
                    <a
                      href="javascript: void(0);"
                      class="badge bg-primary font-size-11 m-1"
                      >{{ kry.pekerjaan }}</a
                    >
                    <a
                      href="javascript: void(0);"
                      class="badge bg-primary font-size-11 m-1"
                      >{{ kry.bagian }}</a
                    >
                  </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                  <div class="contact-links d-flex font-size-20">
                    <div class="flex-fill">
                      <a
                        class="text-primary"
                        type="button"
                        @click="getDataProfile(kry.hashid)"
                        data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-center"
                        ><i class="bx bx-user-circle"></i
                      ></a>
                    </div>

                    <div class="flex-fill">
                      <a
                        type="button"
                        @click="getDataByid(kry.hashid)"
                        data-toggle="modal"
                        data-target="#exampleModal"
                        ><i class="bx bxs-edit-alt"></i
                      ></a>
                    </div>
                    <div class="flex-fill">
                       <el-button type="text" @click="open(kry.hashid)"><i class="bx bx-trash-alt"></i></el-button>
                      <!-- <a
                        class="text-danger"
                        type="button"
                        @click="deleteData(kry.hashid)"
                        data-toggle="modal"
                        data-target="#exampleModal"
                        >
                        <i class="bx bx-trash-alt"></i>
                      </a> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>

      <b-modal
        id="modal-standard"
        v-model="showModal"
        title="Tambah Data Karyawan"
        top
      >
        <!-- <label>Pinjaman Langsung</label> -->
        <form>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Nama Karyawan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input
                type="text"
                v-model="user.nama_karyawan"
                class="form-control"
              />
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Group <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <v-select
                type="text"
                :options="optionsgroup"
                v-model="user.group"
              ></v-select>
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Kode Karyawan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input
                type="text"
                v-model="user.kode_karyawan"
                class="form-control"
              />
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Pekerjaan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <v-select
                type="text"
                :options="optionspekerjaan"
                v-model="user.pekerjaan"
              ></v-select>
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Bagian <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input type="text" v-model="user.bagian" class="form-control" />
            </div>
          </div>

          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Foto <span class="text-danger"></span></label
            >
            <div class="col-sm-9">
              <input
                type="file"
                ref="file"
                @change="handleFileUpload()"
                class="form-control"
              />
            </div>
          </div>
        </form>
        <template v-slot:modal-footer>
          <button
            type="button"
            @click="uploadAttachment"
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
          <b-button variant="secondary" @click="showModal = false"
            >Close</b-button
          >
        </template>
      </b-modal>

      <b-modal
        id="modal-standard"
        v-model="showModaledit"
        title="Edit Data Karyawan"
        top
      >
        <!-- <label>Pinjaman Langsung</label> -->
        <form>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Nama Karyawan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input
                type="text"
                v-model="user.nama_karyawan"
                class="form-control"
              />
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Group <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <v-select
                type="text"
                :options="optionsgroup"
                v-model="user.group"
              ></v-select>
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Kode Karyawan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input
                type="text"
                v-model="user.kode_karyawan"
                class="form-control"
              />
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Pekerjaan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
               <v-select
                type="text"
                :options="optionspekerjaan"
                v-model="user.pekerjaan"
              ></v-select>
            </div>
          </div>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Bagian <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input type="text" v-model="user.bagian" class="form-control" />
            </div>
          </div>

          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Foto <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input
                type="file"
                ref="file"
                @change="handleFileUpload()"
                class="form-control"
              />
            </div>
          </div>
        </form>
        <template v-slot:modal-footer>
          <button
            type="button"
            @click="uploadAttachment"
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
          <b-button variant="secondary" @click="showModaledit = false"
            >Close</b-button
          >
        </template>
      </b-modal>

      <b-modal
        id="modal-dialog modal-dialog-centered"
        v-model="showModalProfile"
        title="Profile"
        top
      >
        <div class="table-responsive">
          <table class="table table-nowrap mb-0">
            <tbody>
              <tr>
                <th scope="row">Nama</th>
                <td>{{ user.nama_karyawan }}</td>
              </tr>
              <tr>
                <th scope="row">Kode Karyawan</th>
                <td>{{ user.kode_karyawan }}</td>
              </tr>
              <tr>
                <th scope="row">Bagian</th>
                <td>{{ user.bagian }}</td>
              </tr>
              <tr>
                <th scope="row">Pekerjaan</th>
                <td>{{ user.pekerjaan }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </b-modal>
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
      id: null,
      title: "User Managament",
      isLoadingContent: false,
      buttondisabled: false,
      buttonloading: "",
      showModal: false,
      showModaledit: false,
      showModalProfile: false,
      karyawan: [],
      optionsbagian: [],
      optionspekerjaan:[],
      optionsgroup:[],
      file: null,
      user: {
        kode_karyawan: "",
        group: "",
        nama_karyawan: "",
        pekerjaan: "",
        bagian: "",
      },
      filter: {
        nama_karyawan: "",
        group: "",
        pekerjaan:"",
        bagian: "",
        kode_karyawan: "",
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
        .get("/profile/user/all?page=" + page, {
          params: {
            nama_karyawan: this.filter.nama_karyawan,
            group: this.filter.group,
            bagian: this.filter.bagian,
            kode_karyawan: this.filter.kode_karyawan,
            pekerjaan: this.filter.pekerjaan
          },
        })
        .then((response) => {

          this.karyawan = response.data.data;
          this.optionsbagian = response.data.optionsbagian;
          this.optionsgroup = response.data.optionsgroup;
          this.optionspekerjaan = response.data.optionspekerjaan;
          this.isLoadingContent = false;

        });
    },
    getDataByid(id) {
      this.showModaledit = true;
      this.id = id;
      this.$http
        .get("/profile/user/byid", {
          params: {
            id: id,
          },
        })
        .then((response) => {
          this.user = response.data.data;
        });
    },
    getDataProfile(id) {
      this.showModalProfile = true;
      this.id = id;
      this.$http
        .get("/profile/user/byid", {
          params: {
            id: id,
          },
        })
        .then((response) => {
          this.user = response.data.data;
        });
    },
    open(id) {
        this.id = id;
        this.$confirm('Non Aktifkan Karyawan Berikut. Lanjutkan ?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.onDeleteKaryawan(this.id);
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Canceled'
          });          
        });
    },
    onDeleteKaryawan(id){
      this.id = id;
      let datasubmit = {
        id: this.id,
      };
      this.$http
        .post("/master-data/non-aktifkan", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil Non Aktifkan Karyawan Data");
          this.getDataKaryawan();
          this.id = null;
        })
        .catch((error) => {
          this.$awn.alert("Gagal Non Aktifkan Karyawan Data");
        });

    },
    onChangeGroup(event) {
      if (event === null) {
        this.filter.group = null;
      } else {
        this.filter.group = event;
      }
      this.getDataKaryawan();
    },
    onChangePekerjaan(event) {
      if (event === null) {
        this.filter.pekerjaan = null;
      } else {
        this.filter.pekerjaan = event;
      }
      this.getDataKaryawan();
    },
    onChangeBagian(event) {
      if (event === null) {
        this.filter.bagian = null;
      } else {
        this.filter.bagian = event;
      }
      this.getDataKaryawan();
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    uploadAttachment() {
      let formData = new FormData();
      formData.append("id", this.id);
      formData.append("file", this.file);
      formData.append("user", JSON.stringify(this.user));

      this.buttonloading = "spinner-border spinner-border-sm";
      this.buttondisabled = true;
      this.$http
        .post("/profile/user/submit/foto", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$awn.success("Berhasil submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.showModal = false;
          this.showModaledit = false;
          this.getDataKaryawan();
          this.user = {};
          console.log("Sukses");
        })
        .catch((error) => {
          this.$awn.alert("Gagal Submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.showModal = false;
          this.showModaledit = false;
          this.user = {};
          console.log("error");
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
