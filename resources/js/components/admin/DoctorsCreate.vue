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
            <div class="col-sm-6 data-field-col pl-2">
              <label>Name</label>
                 <input type="text" class="form-control" v-model="name" />
             </div>
            <div class="col-sm-6 data-field-col pr-2">
              <label>Last name</label>
                <input type="text" class="form-control" v-model="last_name" />
              </div>
             <div class="col-sm-12 data-field-col">
              <label>Type</label>
              <div class="col-md-8">
                <select class="form-control square" v-model="type">
                  <option :value="type" v-for="type in types" :key="type.id">
                    {{ type.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 data-field-col">
              <label>Username</label>
              <div class="col-md-12">
                <input type="text" class="form-control" v-model="username" />
              </div>
            </div>
            <div class="col-sm-12 data-field-col">
              <label>Password</label>
              <div class="col-md-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="password"
                />
              </div>
            </div>
            <div class="col-sm-12 data-field-col">
              <label>Confirm Password</label>
              <div class="col-md-12">
                <input
                  type="password"
                  class="form-control"
                  v-model="password_confirmation"
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
        <button class="btn btn-danger" @click="closeSidebar">Cancel</button>
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
      password_confirmation: null,
      types: null,
    };
  },
  created() {
    axios.get("/api/doctors/types").then((response) => {
      this.types = response.data;
    });
  },
  methods: {
    save() {
      let data = {
        name: this.name,
        last_name: this.last_name,
        type: this.type.id,
        username: this.username,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };
      if (this.data) {
        axios
          .put(this.url, data)
          .then((response) => {
            this.$emit("refreshData");
          })
          .catch((error) => {
            Object.values(error.response.data.errors).forEach(
              (value, index) => {
                this.$notify({
                  group: "foo",
                  type: "warn",
                  title: "Error",
                  text: value[0],
                });
              }
            );
          });
      } else {
        axios
          .post(this.url, data)
          .then((response) => {
            this.$emit("refreshData");
          })
          .catch((error) => {
            Object.values(error.response.data.errors).forEach(
              (value, index) => {
                this.$notify({
                  group: "foo",
                  type: "warn",
                  title: "Error",
                  text: value[0],
                });
              }
            );
          });
      }
    },
    closeSidebar() {
      this.$emit("closeSidebar");
    },
  },
};
</script>
