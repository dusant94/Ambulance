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
                <label>Type</label>
                <div class="col-md-8">
                  <select class="form-control square" v-model="type">
                    <option
                      :value="type"
                      v-for="type in types"
                      :key="type.id"
                    >
                      {{ type.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 data-field-col">
                <label>Username</label>
                <input type="text" class="form-control" v-model="username" />
              </div>
              <div class="col-sm-12 data-field-col">
                <label>Password</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="password"
                />
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
  name: "doctors-create",
  props: ["data"],
  data() {
    return {
      url: this.data ? "/api/doctors/" + this.data.id : "/api/doctors/",
      name: this.data ? this.data.name : null,
      last_name: this.data ? this.data.last_name : null,
      type: this.data ? this.data.type : null,
      username: this.data ? this.data.username : null,
      password: null,
      types: null,
    };
  },
  mounted() {
    axios.get("/api/doctors/types").then((response) => {
      this.types = response.data;
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
        type: this.type,
        username: this.username,
        password: this.password,
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
