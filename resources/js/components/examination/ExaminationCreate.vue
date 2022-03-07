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
              <div class="col-sm-12 data-field-col">
                <div class="col-md-12">
                  <label>Time of Examination </label>
                </div>
                <div class="col-md-12">
                  <b v-if="user.role == 'doctor' && data">{{
                    time_of_examination
                  }}</b>
                  <flat-pickr
                    v-if="user.role !== 'doctor'"
                    v-model="time_of_examination"
                    :config="configforpicker"
                    class="form-control"
                    style="background-color: #10163a"
                    placeholder="Select date"
                    name="date"
                  />
                </div>
              </div>
              <div class="col-sm-12 data-field-col">
                <div class="col-md-12">
                  <label>Patient </label>
                </div>
                <div class="col-md-12">
                  <b v-if="user.role == 'doctor' && data">{{ patient.name }}</b>
                  <select
                    v-if="user.role !== 'doctor'"
                    class="form-control square"
                    v-model="patient"
                  >
                    <option
                      :value="patient"
                      v-for="patient in patients"
                      :key="patient.id"
                    >
                      {{ patient.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 data-field-col">
                <div class="col-md-12">
                  <label>Doctor</label>
                </div>

                <div class="col-md-12">
                  <b v-if="user.role == 'doctor' && data">{{ doctor.name }}</b>
                  <select
                    v-if="user.role !== 'doctor'"
                    class="form-control square"
                    v-model="doctor"
                  >
                    <option
                      :value="doctor"
                      v-for="doctor in doctors"
                      :key="doctor.id"
                    >
                      {{ doctor.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 data-field-col">
                <div class="col-md-12">
                  <label>Diagnosis</label>
                </div>

                <div class="col-md-12">
                  <textarea
                    class="form-control square"
                    v-model="diagnosis"
                  ></textarea>
                </div>
                <div class="col-sm-12 data-field-col">
                  <div class="col-md-12">
                    <label>Performed</label>
                  </div>

                  <div class="col-md-12">
                    <fieldset class="checkbox">
                      <div class="vs-checkbox-con vs-checkbox-primary">
                        <input type="checkbox" v-model="performed" />
                        <span class="vs-checkbox">
                          <span class="vs-checkbox--check">
                            <i class="vs-icon feather icon-check"></i>
                          </span>
                        </span>
                      </div>
                    </fieldset>
                  </div>
                </div>
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
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

export default {
  components: { flatPickr },
  name: "examintaions-create",
  props: ["data"],
  data() {
    return {
      url: this.data
        ? "/api/examinations/" + this.data.id
        : "/api/examinations/",
      diagnosis: this.data ? this.data.diagnosis : null,
      performed: this.data ? this.data.performed : false,
      patient: this.data ? this.data.patient : null,
      doctor: this.data ? this.data.doctor : null,
      time_of_examination: this.data ? this.data.time_of_examination : null,
      doctors: [],
      patients: [],
      user: this.$store.state.auth.user,
      configforpicker: {
        wrap: true,
        altFormat: "d.m.Y H:i",
        altInput: true,
        dateFormat: "d.m.Y H:i",
        enableTime: true,
        time_24hr: true,
      },
    };
  },
  created() {
    axios.get("/api/doctors/table").then((response) => {
      this.doctors = response.data;
    });
    axios.get("/api/patients/table").then((response) => {
      this.patients = response.data;
    });
  },
  methods: {
    save() {
      let data = {
        diagnosis: this.diagnosis,
        performed: this.performed,
        patient_id: this.patient ? this.patient.id : null,
        doctor_id: this.doctor ? this.doctor.id : null,
        time_of_examination: this.time_of_examination,
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
