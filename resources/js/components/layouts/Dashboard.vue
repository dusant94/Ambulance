<template>
  <div>
      <Navbar/>
    <Sidebar/>



      <!-- <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li>
          <a href="#" class="nav-link px-2 link-dark">
            <router-link v-if="user.role == 'admin'" :to="{ name: 'doctors' }"
              >Doctors
            </router-link>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link px-2 link-dark">
            <router-link v-if="user.role == 'admin'" :to="{ name: 'patients' }"
              >Patients
            </router-link>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link px-2 link-dark">
            <router-link
              v-if="user.role == 'doctor'"
              :to="{ name: 'examinations' }"
              >Examinations</router-link
            >
          </a>
        </li>
      </ul> -->


    <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
      <router-view></router-view>

             </div>
        </div>

         <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';

export default {
    components: {
    Sidebar,
    Navbar
  },
  name: "dashboard-layout",
  data() {
    return {
      user: this.$store.state.auth.user,
    };
  },
  methods: {
    ...mapActions({
      signOut: "auth/logout",
    }),
    async logout() {
      await axios.post("/api/logout").then(({ data }) => {
        this.signOut();
        this.$router.push({ name: "login" });
      });
    },
  },
};
</script>
