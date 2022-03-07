<template>
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center mt-2">
        <li class="page-item first">
          <a
            @click="firstPage()"
            href="#"
            class="page-link"
            :class="`page-item ${pageNumber === 1 ? 'disabled' : ''}`"
            >First</a
          >
        </li>
        <li class="page-item prev-item">
          <a
            @click="previousPage()"
            class="page-link"
            :class="`page-item ${pageNumber === 1 ? 'disabled' : ''}`"
            href="#"
          ></a>
        </li>
        <li
          v-for="(number, index) in paginationList"
          :class="`page-item ${pageNumber === number ? 'active' : ''}`"
          :key="index"
        >
          <a @click="clickPage(number)" class="page-link" href="#"
            >{{ number }}
          </a>
        </li>

        <li class="page-item next-item">
          <a
            @click="nextPage()"
            class="page-link"
            :class="`page-item ${
              pageCount === 0 || pageNumber >= pageCount ? 'disabled' : ''
            }`"
            href="#"
          ></a>
        </li>
        <li class="page-item last">
          <a
            @click="lastPage()"
            href="#"
            class="page-link"
            :class="`page-item ${
              pageCount === 0 || pageNumber >= pageCount ? 'disabled' : ''
            }`"
            >Last</a
          >
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  name: "pagination",
  props: ["values", "url"],
  data() {
    return {
      paginationList: [],
      activeValues: null,
      pageNumber: 1,
      pageCount: 1,
    };
  },
  mounted() {
      this.pagination();
   },
  methods: {
    nextPage() {
      this.pageNumber++;
      this.pagination();
    },
    previousPage() {
      this.pageNumber--;
      this.pagination();
    },
    firstPage() {
      this.pageNumber = 1;
      this.pagination();
    },
    lastPage() {
      this.pageNumber = this.pageCount;
      this.pagination();
    },
    clickPage(number) {
      this.pageNumber = number;
      this.pagination();
    },
    pagination() {
      let url = this.url;
      let self = this;
      axios
        .post(url, {
          page: self.pageNumber,
        })
        .then((response) => {
          self.activeValues = response.data.data;
          console.log(self.activeValues)
          self.pageCount = response.data.last_page;
          this.$emit("refreshData", self.activeValues);
          this.createPaginationList();
        })
        .catch((error) => {});
    },
    createPaginationList() {
      this.paginationList = [];
      if (this.pageNumber < 3 || this.pageCount <= 4) {
        let i = 1;
        while (i < 5 && i <= this.pageCount) {
          this.paginationList.push(i);
          i++;
        }
      } else if (this.pageNumber > this.pageCount - 3) {
        let i = this.pageCount - 3;
        while (i <= this.pageCount) {
          this.paginationList.push(i);
          i++;
        }
      } else {
        let i = this.pageNumber;
        let j = 1;
        while (j < 5) {
          this.paginationList.push(i);
          i++;
          j++;
        }
      }
    },
  },
};
</script>
<style>
.disabled {
  pointer-events: none;
  opacity: 0.6;
}
</style>
