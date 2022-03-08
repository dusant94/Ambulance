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

                  <multiselect
                    v-if="user.role !== 'doctor'"
                    v-model="patient"
                    :options="patients"
                    :show-labels="false"
                    placeholder=""
                    label="name"
                    track-by="name"
                    :showNoResults="false"
                    :custom-label="PatientName"
                  >
                  </multiselect>
                </div>
              </div>
              <div class="col-sm-12 data-field-col">
                <div class="col-md-12">
                  <label>Doctor</label>
                </div>

                <div class="col-md-12">
                  <b v-if="user.role == 'doctor' && data">{{ doctor.name }}</b>
                  <multiselect
                    v-if="user.role !== 'doctor'"
                    v-model="doctor"
                    :options="doctors"
                    :show-labels="false"
                    placeholder=""
                    label="name"
                    track-by="name"
                    :showNoResults="false"
                    :custom-label="DoctorName"
                  >
                  </multiselect>
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
import Multiselect from "vue-multiselect";

export default {
  components: { flatPickr, Multiselect },
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
    DoctorName({ name, last_name }) {
      return `${name}  ${last_name}`;
    },
    PatientName({ name, last_name }) {
      return `${name}  ${last_name}`;
    },
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
// <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.multiselect {
  box-sizing: content-box;
  display: block;
  position: relative;
  width: 100%;
  min-height: 40px;
  text-align: left;
  color: #070707;
  font-family: inherit;
  font-size: 12px;
  touch-action: manipulation;
}
.multiselect__element {
  display: block;
  background-color: #ffffff;
}
.multiselect__tags {
  min-height: 40px;
  display: block;
  padding: 8px 40px 0 8px;
  border-radius: 5px;
  border: 1px solid #ebebeb;
  background: #ebebeb;
  font-size: 12px;
}
.multiselect__input {
  font-family: inherit;
  font-size: 12px;
  touch-action: manipulation;
  position: relative;
  display: inline-block;
  min-height: 20px;
  line-height: 20px;
  border: none;
  border-radius: 5px;
  background: #ebebeb;
  padding: 0 0 0 5px;
  width: 100%;
  transition: border 0.1s ease;
  box-sizing: border-box;
  margin-bottom: 8px;
  vertical-align: top;
}

.multiselect__single {
  font-family: inherit;
  font-size: 12px;
  touch-action: manipulation;
  position: relative;
  display: inline-block;
  min-height: 20px;
  line-height: 20px;
  border: none;
  border-radius: 5px;
  background: #ebebeb;
  padding: 0 0 0 5px;
  width: 100%;
  transition: border 0.1s ease;
  box-sizing: border-box;
  margin-bottom: 8px;
  vertical-align: top;
}
.multiselect--active {
  z-index: 50;
}
.multiselect__option--highlight {
  background: #acaeb8;
  outline: none;
  color: rgb(0, 0, 0);
}
.multiselect__option--selected {
  background: #acaeb8;
  color: rgb(0, 0, 0);
}
.multiselect__option--selected.multiselect__option--highlight {
  background: #acaeb8;
  color: rgb(0, 0, 0);
}

.multiselect__content {
  list-style: none;
  display: inline-block;
  padding: 0;
  margin: 0;
  min-width: 100%;
  vertical-align: top;
}
</style>
