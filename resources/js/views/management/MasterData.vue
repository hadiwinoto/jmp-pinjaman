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
          <h4 class="mb-0 font-size-18">Master Data</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">Master Data</li>
            </ol>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="row">
          <div class="col-xl-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <h5 class="mb-0 card-title flex-grow-1">Group</h5>
                  <div>
                    <el-button
                      @click="showModalGroup = true"
                      data-toggle="modal"
                      data-target="#exampleModal"
                      type="text"
                      >Tambah</el-button
                    >
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                      <thead>
                        <tr>
                          <th width="10px">#</th>
                          <th>Name</th>
                          <th width="20px" class="text-center">
                            <i class="bx bx-cog"></i>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(bg, idxk) in group" :key="idxk">
                          <th scope="row">{{ idxk + 1 }}</th>
                          <td>{{ bg.name }}</td>
                          <td>
                            <ul class="list-unstyled hstack gap-1 mb-0">
                              <span class="text-success">
                                <a
                                  class="btn btn-sm btn-soft-primary"
                                  @click="getDataGroupByid(bg.hashid)"
                                  data-toggle="modal"
                                  data-target="#exampleModal"
                                  ><i class="mdi mdi-pencil-outline"></i
                                ></a>
                              </span>
                              <span class="text-danger">
                                <a
                                  data-bs-toggle="modal"
                                  @click="onDeleteGroup(bg.hashid)"
                                  class="btn btn-sm btn-soft-danger"
                                  ><i class="mdi mdi-delete-outline"></i
                                ></a>
                              </span>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <h5 class="mb-0 card-title flex-grow-1">Pekerjaan</h5>
                  <div>
                    <el-button
                      @click="showModalPekerjaan = true"
                      data-toggle="modal"
                      data-target="#exampleModal"
                      type="text"
                      >Tambah</el-button
                    >
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                      <thead>
                        <tr>
                          <th width="10px">#</th>
                          <th>Name</th>
                          <th width="20px" class="text-center">
                            <i class="bx bx-cog"></i>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(pk, idxp) in pekerjaan" :key="idxp">
                          <th scope="row">{{ idxp + 1 }}</th>
                          <td>{{ pk.name }}</td>
                          <td>
                            <ul class="list-unstyled hstack gap-1 mb-0">
                              <span class="text-success">
                                <a
                                  class="btn btn-sm btn-soft-primary"
                                  @click="getPekerjaanByid(pk.hashid)"
                                  data-toggle="modal"
                                  data-target="#exampleModal"
                                  ><i class="mdi mdi-pencil-outline"></i
                                ></a>
                              </span>
                              <span class="text-danger">
                                <a
                                  data-bs-toggle="modal"
                                  @click="onDeletePekerjaan(pk.hashid)"
                                  class="btn btn-sm btn-soft-danger"
                                  ><i class="mdi mdi-delete-outline"></i
                                ></a>
                              </span>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <h5 class="mb-0 card-title flex-grow-1">Bagian</h5>
                  <div>
                    <el-button
                      @click="showModalBagian = true"
                      data-toggle="modal"
                      data-target="#exampleModal"
                      type="text"
                      >Tambah</el-button
                    >
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                      <thead>
                        <tr>
                          <th width="10px">#</th>
                          <th>Name</th>
                          <th width="20px" class="text-center">
                            <i class="bx bx-cog"></i>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(pk, idxp) in bagian" :key="idxp">
                          <th scope="row">{{ idxp + 1 }}</th>
                          <td>{{ pk.name }}</td>
                          <td>
                            <ul class="list-unstyled hstack gap-1 mb-0">
                              <span class="text-success">
                                <a
                                  class="btn btn-sm btn-soft-primary"
                                  @click="getBagianByid(pk.hashid)"
                                  data-toggle="modal"
                                  data-target="#exampleModal"
                                  ><i class="mdi mdi-pencil-outline"></i
                                ></a>
                              </span>
                              <span class="text-danger">
                                <a
                                  data-bs-toggle="modal"
                                  @click="onDeleteBagian(pk.hashid)"
                                  class="btn btn-sm btn-soft-danger"
                                  ><i class="mdi mdi-delete-outline"></i
                                ></a>
                              </span>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>

      <b-modal id="modal-standard" v-model="showModalGroup" title="Tambah Data" top>
        <form>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label">
              Group <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
              <input type="text" v-model="nama_group" required class="form-control" />
            </div>
          </div>
        </form>
        <template v-slot:modal-footer>
          <button type="button" @click="onSubmitGroup" :disabled="buttondisabled" class="btn btn-primary w-md">
            <span :class="buttonloading"
              role="status"
              aria-hidden="true"
            ></span>
            Submit
          </button>
          <b-button variant="secondary" @click="closeModal"
            >Close</b-button
          >
        </template>
      </b-modal>

      <b-modal id="modal-standard" v-model="showModalPekerjaan" title="Tambah Data" top>
        <form>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Pekerjaan <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input type="text" v-model="nama_pekerjaan" required class="form-control" />
            </div>
          </div>
        </form>
        <template v-slot:modal-footer>
          <button type="button" @click="onSubmitPekerjaan" :disabled="buttondisabled" class="btn btn-primary w-md">
            <span :class="buttonloading" role="status" aria-hidden="true"></span>
            Submit
          </button>
          <b-button variant="secondary" @click="closeModal">Close</b-button>
        </template>
      </b-modal>


       <b-modal id="modal-standard" v-model="showModalBagian" title="Tambah Data" top>
        <form>
          <div class="row mb-4">
            <label for="horizontal-email-input" class="col-sm-3 col-form-label"
              >Bagian <span class="text-danger">*</span></label
            >
            <div class="col-sm-9">
              <input type="text" v-model="nama_bagian" required class="form-control" />
            </div>
          </div>
        </form>
        <template v-slot:modal-footer>
          <button
            type="button"
            @click="onSubmitBagian"
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
          <b-button variant="secondary" @click="closeModal"
            >Close</b-button
          >
        </template>
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
      title: "User Managament",
      id: null,
      isLoadingContent: false,
      bagian: [],
      group:[],
      showModalGroup: false,
      showModalPekerjaan:false,
      showModalBagian:false,
      showModalEdit: false,
      buttondisabled: false,
      buttonloading: false,
      
      //input
      nama_pekerjaan:"",
      nama_group:"",
      nama_bagian: "",
      edit: false,
      pekerjaan:'',
    };
  },
  created() {
    this.getDataAll();
  },
  methods: {
    getDataAll() {
      this.isLoadingContent = true;
      this.$http.get("/master-data/fetchdata").then((response) => {
        this.group = response.data.group;
        this.pekerjaan = response.data.pekerjaan;
        this.bagian = response.data.bagian
        this.isLoadingContent = false;
      });
    },
    getDataGroupByid(id){
      this.showModalGroup = true;
      this.edit = true;
      this.id = id;
      this.$http.get("/master-data/groupbyid", {
          params: {
            id: id,
          },
        })
        .then((response) => {
          this.nama_group = response.data.data.name;
          this.getDataAll();
          this.edit = false;
        });
    },
    onSubmitGroup(){
      let datasubmit = {
        nama_group: this.nama_group,
        edit: this.edit,
        id: this.id,
      };
      this.buttonloading = "spinner-border spinner-border-sm";
      this.buttondisabled = true;
      this.$http
        .post("/master-data/submit", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.nama_group = "";
          this.id = null;
          this.showModalGroup = false;
          this.getDataAll();
        })
        .catch((error) => {
          this.$awn.alert("Gagal Submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.showModalGroup = false;
        });
    },
    onDeleteGroup(id) {
      let datasubmit = {
        id: id,
      };
      this.$http
        .post("/master-data/delete/group", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil Delete Data");
          this.getDataAll();
          this.nama_group = "";
          this.id = null;
        })
        .catch((error) => {
          this.$awn.alert("Gagal Delete Data");
        });
    },
   
    //bagian action
    getBagianByid(id){
      this.showModalBagian = true;
      this.edit = true;
      this.id = id;
      this.$http.get("/master-data/fetchbagianbyid", {
          params: {
            id: id,
          },
        })
        .then((response) => {
          this.nama_bagian = response.data.name;
          this.getDataAll();
          this.edit = false;
        });
    },
    onDeleteBagian(id){
      let datasubmit = {
        id: id,
      };
      this.$http
        .post("/master-data/delete/bagian", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil Delete Data");
          this.getDataAll();
          this.nama_bagian = "";
          this.id = null;
        })
        .catch((error) => {
          this.$awn.alert("Gagal Delete Data");
        });
    },
    onSubmitBagian() {
      let datasubmit = {
        nama_bagian: this.nama_bagian,
        edit: this.edit,
        id: this.id,
      };
      this.buttonloading = "spinner-border spinner-border-sm";
      this.buttondisabled = true;
      this.$http
        .post("/master-data/submit/bagian", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.nama_bagian = "";
          this.id = null;
          this.showModalBagian = false;
          this.getDataAll();
        })
        .catch((error) => {
          this.$awn.alert("Gagal Submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.showModalBagian = false;
        });
    },
    
   
    




    //action pekerjaan
    getPekerjaanByid(id) {
      this.showModalPekerjaan = true;
      this.edit = true;
      this.id = id;
      this.$http
        .get("/master-data/pekerjaanbyid", {
          params: {
            id: id,
          },
        })
        .then((response) => {
          this.nama_pekerjaan = response.data.name;
          this.getDataAll();
          this.edit = false;
        });
    },
    onSubmitPekerjaan(){
      let datasubmit = {
        nama_pekerjaan: this.nama_pekerjaan,
        edit: this.edit,
        id: this.id,
      };
      this.buttonloading = "spinner-border spinner-border-sm";
      this.buttondisabled = true;
      this.$http
        .post("/master-data/submit/pekerjaan", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.nama_pekerjaan = "";
          this.id = null;
          this.showModalPekerjaan = false;
          this.getDataAll();
        })
        .catch((error) => {
          this.$awn.alert("Gagal Submit Data");
          this.buttonloading = "";
          this.buttondisabled = false;
          this.showModalPekerjaan = false;
        });
    },

    onDeletePekerjaan(id) {
      let datasubmit = {
        id: id,
      };
      this.$http
        .post("/master-data/delete/pekerjaan", datasubmit)
        .then((response) => {
          this.$awn.success("Berhasil Delete Data");
          this.getDataAll();
          this.nama_pekerjaan = "";
          this.id = null;
        })
        .catch((error) => {
          this.$awn.alert("Gagal Delete Data");
        });
    },
    closeModal(){
      this.showModalGroup     = false;
      this.showModalBagian    =  false;
      this.showModalPekerjaan =  false;
      this.nama_group     = '';
      this.nama_bagian    = '';
      this.nama_pekerjaan = '';
      this.edit = false;
      this.id = null;
    }
  },
};
</script>
