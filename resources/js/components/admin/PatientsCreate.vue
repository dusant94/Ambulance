<template>
  <div>
    <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
      <div>
        <h4 class="text-uppercase">
          {{ data ? "Edit" : "Create" }}
        </h4>
      </div>
      <div class="hide-data-sidebar" @click="closeSidebar">
        <i class="feather icon-x"></i>
      </div>
    </div>
    <div class="data-items pb-3">
      <div class="data-items pb-3">
        <div class="data-fields px-2 mt-3">
          <div class="row">
            <div class="row">
              <div class="col-sm-6 data-field-col">
                <label>Name</label>
                <input type="text" class="form-control" v-model="name" />
              </div>
              <div class="col-sm-6 data-field-col">
                <label>Last name</label>
                <input type="text" class="form-control" v-model="last_name" />
              </div>
              <div class="col-sm-12 data-field-col">
                <label>Locations</label>
                <div class="col-md-8">
                  <select class="form-control square" v-model="location">
                    <option
                      :value="location"
                      v-for="location in locations"
                      :key="location.id"
                    >
                      {{ location.address }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 data-field-col">
                <label>JMBG</label>
                <input type="text" class="form-control" v-model="jmbg" />
              </div>
              <div class="col-md-12">
                <span>Note</span>
              </div>
              <div class="col-md-12">
                <textarea class="form-control square" v-model="note"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="add-data-footer d-flex justify-content-around px-3">
      <div class="add-data-btn">
        <button class="btn btn-primary" @click="save">
          {{ data ? "Update " : "Create " }}
        </button>
      </div>
      <div class="cancel-data-btn">
        <button class="btn btn-outline-danger" @click="closeSidebar">
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "patients-create",
  props: ["data"],
  data() {
    return {
      url: this.data ? "/api/patients/" + this.data.id : "/api/patients/",
      name: this.data ? this.data.name : null,
      last_name: this.data ? this.data.last_name : null,
      location: this.data ? this.data.location : null,
      jmbg: this.data ? this.data.jmbg : null,
      note: this.data ? this.data.note : null,
      locations: null,
    };
  },
  mounted() {
    axios.get("/api/locations").then((response) => {
      this.locations = response.data;
    });
  },
  methods: {
    // validateForm() {
    //     this.errors = [];
    //     if (!this.chassis_number)
    //         this.errors.push(this.__('validations.chassis_number'));

    //     if (this.errors.length === 0) return false;
    //     else
    //         this.errors.forEach((error) => {
    //             toastr.error(error);
    //         });
    //     return true;
    // },
    save() {
      // if (this.validateForm()) {
      //     return;
      // }
      let data = {
        name: this.name,
        last_name: this.last_name,
        location_id: this.location.id,
        note: this.note,
        jmbg: this.jmbg,
      };
      if (this.data) {
        axios.put(this.url, data).then((response) => {
          this.$emit("refreshData");
        });
      } else {
        axios.post(this.url, data).then((response) => {
          this.$emit("refreshData");
        });
      }
    },
    closeSidebar() {
      this.$emit("closeSidebar");
    },
  },
};
</script>
