<template>
  <div class="container">
    <div class="content-header row">
      <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Patients</h2>
            <div class="breadcrumb-wrapper col-12"></div>
          </div>
        </div>
      </div>
      <div
        class="content-header-right text-md-right col-md-3 col-12 d-md-block"
      >
        <div class="form-group breadcrumb-right">
          <a
            href="#/"
            class="btn-icon btn btn-primary"
            @click="openSidebar('patients-create')"
          >
            <i class="feather icon-plus"></i> Add
          </a>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="data-list-view" class="data-list-view-header">
        <div class="table-responsive">
          <table class="table table-hover-animation">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>JMBG</th>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(patient, index) in patients" :key="patient.id">
                <td>{{ index + 1 }}</td>
                <td class="product-name">{{ patient.name }}</td>
                <td class="product-name">{{ patient.last_name }}</td>
                <td class="product-name">{{ patient.location.address }}</td>
                <td class="product-name">{{ patient.jmbg}}</td>

                <td class="product-action fonticon-wrap">
                  <a
                    href="#"
                    class="btn btn-flat-success square"
                    @click="openSidebar('patients-create', patient)"
                    ><i class="feather icon-edit"></i
                  ></a>
                  <a
                    href="#"
                    class="btn btn-flat-danger square"
                    @click="openDeleteModal(patient.id, patient.name)"
                    ><i class="feather icon-trash"></i
                  ></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <right-sidebar
          v-if="sidebar"
          :sidebarComponent="sidebarComponent"
          :data="sidebarData"
          @refreshData="refreshData"
          @closeSidebar="closeSidebar"
        >
        </right-sidebar>
      </section>
    </div>
    <delete-confirm-modal
      v-if="modal"
      :id="id"
      :modal_message="modal_message"
      @closeDeleteModal="closeDeleteModal"
      @confirm="confirm"
    >
    </delete-confirm-modal>
  </div>
</template>

<script>
import RightSidebar from "../layouts/RightSidebar.vue";
import DeleteConfirmModal from "../DeleteConfirmModal.vue";

export default {
  components: {
    RightSidebar,
    DeleteConfirmModal
  },
  name: "patients",
  data() {
    return {
      id: null,
      modal: false,
      modalComponent: null,
      sidebar: false,
      sidebarComponent: null,
      sidebarData: null,
      user: this.$store.state.auth.user,
      patients: [],
    };
  },
  created() {
    axios.get("/api/patients/table").then((response) => {
      this.patients = response.data;
    });
  },
  methods: {
    openDeleteModal(id, modal_message) {
      this.id = id;
      this.modal_message = modal_message;
      this.modal = true;
    },
    closeDeleteModal() {
      this.modal = false;
      this.id = null;
      this.modal_message = null;
    },
    openSidebar(component, data = null) {
      this.sidebarComponent = component;
      this.sidebarData = data;
      this.sidebar = true;
    },
    closeSidebar() {
      this.sidebar = false;
      this.sidebarData = null;
      this.sidebarComponent = null;
    },
    refreshData() {
      axios.get("/api/patients/table").then((response) => {
        this.patients = response.data;
      });
      this.closeSidebar();
    },
    delete(id) {
      axios.delete("/api/patients/" + id).then((response) => {});
      this.refreshData();
    },
    confirm(id) {
      this.delete(id);
      this.closeDeleteModal();
    },
  },
};
</script>
