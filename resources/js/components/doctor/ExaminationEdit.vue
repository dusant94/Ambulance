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
                <label>Patient</label>
                <div class="col-md-8">
                    <p v-if="user.role == 'doctor' && data">{{ patient.name }}</p>
                  <select v-if="user.role !== 'doctor'" class="form-control square" v-model="patient">
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
                <label>Doctor</label>
                <div class="col-md-8" >
                    <p v-if="user.role == 'doctor' && data">{{ doctor.name }}</p>
                  <select v-if="user.role !== 'doctor'" class="form-control square" v-model="doctor">
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
                  <div class="col-md-12">
                <span>Diagnosis</span>
              </div>
             <div class="col-md-12">
                <textarea class="form-control square" v-model="diagnosis"></textarea>
              </div>
                 <div class="col-sm-12 data-field-col">
                <label>Performed</label>
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
  name: "examintaions-edit",
  props: ["data"],
  data() {
    return {
      url: this.data ? "/api/examinations/" + this.data.id : "/api/examinations/",
      diagnosis: this.data ? this.data.diagnosis : null,
      performed: this.data ? this.data.performed : false,
      patient: this.data ? this.data.patient : null,
      doctor: this.data ? this.data.doctor : null,
      doctors: [],
      patients: [],
      user: this.$store.state.auth.user,
    };
  },
  mounted() {
    axios.get("/api/doctors/table").then((response) => {
      this.doctors = response.data;
    });
    axios.get("/api/patients/table").then((response) => {
      this.patients = response.data;
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
        diagnosis: this.diagnosis,
        parformed: this.performed,
        patient_id: this.patient.id,
        doctor_id: this.doctor.id,
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
