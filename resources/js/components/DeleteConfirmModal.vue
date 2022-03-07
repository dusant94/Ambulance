<template>
    <div>
        <div
            class="modal dark-backdrop show"
            id="exampleModalCenter"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            style="padding-right: 17px; display: block"
            aria-modal="true"
            data-backdrop="true"
        >
            <div
                class="
          modal-dialog
          modal-dialog-centered
          modal-dialog-centered
          modal-dialog-scrollable
        "
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header bg-danger white">
                        <h5 class="modal-title" id="exampleModalCenterTitle">
                            Are you sure?
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="closeModal"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group text-body text-white">
                                    <span>Do you want to delete  {{ modal_message }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button
                            type="button"
                            class="btn btn-relief-danger square mr-1 mb-1 waves-effect waves-light"
                            @click="confirm(id)"
                            data-dismiss="modal"
                        >
                            Delete
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-warning square mr-1 mb-1 waves-effect waves-light"
                            @click="closeModal"
                        >
                            Cancel
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "delete-modal",
    props: ["id", "modal_message"],
    methods: {
        confirm(id) {
            this.$emit("confirm", id);
        },
        closeModal() {
            this.$emit("closeDeleteModal");
        },
    },
};
</script>
