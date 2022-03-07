<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h3>Examinations</h3>
          </div>
          <div class="card-body">
            <p class="mb-0">List</p>
          </div>
          <table class="table table-hover-animation">
            <thead>
              <tr>
                <th>ID</th>
                <th>Diagnosis</th>
                <th>Doctor</th>
                <th>Patient</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="examination in examinations" :key="examination.id">
                <td>{{ examination.id }}</td>
                <td class="product-name">{{ examination.diagnosis }}</td>
                <td class="product-name">{{ examination.doctor.name }}</td>
                <td class="product-name">{{ examination.patient.name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "dashboard",
  data() {
    return {
      user: this.$store.state.auth.user,
      examinations: [],
    };
  },
  mounted() {
    axios.get("/api/examinations/table").then((response) => {
      this.examinations = response.data;
    });
  },
};
</script>
