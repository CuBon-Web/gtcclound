<template>
    <div>
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tiêu đề <span style="color:red">*</span></label>
                            <vs-input type="text" placeholder="VD: Tiếp nhận yêu cầu" class="w-100" v-model="objData.title" />
                        </div>
                        <div class="form-group">
                            <label>Icon URL</label>
                            <vs-input type="text" placeholder="https://.../process_1_1.svg" class="w-100" v-model="objData.icon" />
                            <small style="color: #666">Dùng URL ảnh SVG/PNG cho icon quy trình.</small>
                            <div v-if="objData.icon" style="margin-top: 12px;">
                                <img :src="objData.icon" alt="icon preview" style="width: 64px; height: 64px; object-fit: contain;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Vị trí</label>
                            <vs-input type="number" min="0" v-model="objData.position" />
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <vs-select v-model="objData.status">
                                <vs-select-item value="1" text="Hiện" />
                                <vs-select-item value="0" text="Ẩn" />
                            </vs-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row fixxed">
            <div class="col-12">
                <div class="saveButton">
                    <vs-button color="primary" @click="submit">Cập nhật</vs-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
    name: "editProcessStep",
    data() {
        return {
            errors: [],
            objData: {
                id: this.$route.params.id,
                title: "",
                icon: "",
                position: 0,
                status: 1,
            },
        };
    },
    methods: {
        ...mapActions(["addProcessStep", "detailProcessStep", "loadings"]),
        loadDetail() {
            this.loadings(true);
            this.detailProcessStep({ id: this.$route.params.id })
                .then(response => {
                    this.loadings(false);
                    if (response.data) {
                        this.objData = {
                            id: response.data.id,
                            title: response.data.title || "",
                            icon: response.data.icon || "",
                            position: response.data.position || 0,
                            status: response.data.status,
                        };
                    }
                })
                .catch(() => {
                    this.loadings(false);
                });
        },
        submit() {
            this.errors = [];
            if (!this.objData.title) this.errors.push("Tiêu đề không được để trống");
            if (this.errors.length > 0) {
                this.errors.forEach(value => this.$error(value));
                return;
            }
            this.loadings(true);
            this.addProcessStep(this.objData)
                .then(() => {
                    this.loadings(false);
                    this.$router.push({ name: "listProcessStep" });
                    this.$success("Cập nhật thành công");
                })
                .catch(() => {
                    this.loadings(false);
                    this.$error("Cập nhật thất bại");
                });
        },
    },
    mounted() {
        this.loadDetail();
    },
};
</script>
