<template>
  <div
    class="main-menu menu-fixed menu-light menu-accordion menu-shadow expanded"
    data-scroll-to-active="true"
    style="
      touch-action: none;
      user-select: none;
      -webkit-user-drag: none;
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    "
  >
    <div class="navbar-header expanded">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
          <a
            class="navbar-brand"
            href="../../../html/ltr/vertical-menu-template-dark/index.html"
          >
            <div class="brand-logo"></div>
            <h2 class="brand-text mb-0">Ambulante</h2>
          </a>
        </li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"
            ><i
              class="
                icon-x
                d-block d-xl-none
                font-medium-4
                primary
                toggle-icon
                feather
                icon-disc
              "
            ></i
            ><i
              class="
                toggle-icon
                icon-disc
                font-medium-4
                d-none d-xl-block
                collapse-toggle-icon
                primary
                feather
              "
              data-ticon="icon-disc"
            ></i
          ></a>
        </li>
      </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content ps ps--active-y">
      <ul
        class="navigation navigation-main"
        id="main-menu-navigation"
        data-menu="menu-navigation"
      >
        <li class="active nav-item">
          <router-link v-if="user.role == 'admin'" :to="{ name: 'doctors' }"
            ><i class="feather icon-circle"></i
            ><span class="menu-title" data-i18n="Chat"
              >Doctors</span
            ></router-link
          >
        </li>
        <li class="nav-item">
          <router-link v-if="user.role == 'admin'" :to="{ name: 'patients' }"
            ><i class="feather icon-circle"></i
            ><span class="menu-title" data-i18n="Chat"
              >Patients</span
            ></router-link
          >
        </li>
        <li class="active nav-item">
          <router-link v-if="user.role == 'doctor'" :to="{ name: 'examinations' }"
            ><i class="feather icon-circle"></i
            ><span class="menu-title" data-i18n="Chat"
              >Examinations</span
            ></router-link
          >
        </li>
      </ul>
      <div class="ps__rail-x" style="left: 0px; bottom: 0px">
        <div
          class="ps__thumb-x"
          tabindex="0"
          style="left: 0px; width: 0px"
        ></div>
      </div>
      <div class="ps__rail-y" style="top: 0px; height: 638px; right: 0px">
        <div
          class="ps__thumb-y"
          tabindex="0"
          style="top: 0px; height: 162px"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "sidebar",
  data() {
    return {
      user: this.$store.state.auth.user,
    };
  },
};
</script>
