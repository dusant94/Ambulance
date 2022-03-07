<template>
  <div>
    <Navbar />
    <Sidebar />

    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
        <router-view></router-view>
      </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <notifications position="bottom left" group="foo" />

  </div>
</template>

<script>
import { mapActions } from "vuex";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";

export default {
  components: {
    Sidebar,
    Navbar,
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
