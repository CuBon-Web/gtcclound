<template>
    <div>
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tiêu đề <span style="color:red">*</span></label>
                            <vs-input
                                type="text"
                                placeholder="VD: Tính linh hoạt"
                                class="w-100"
                                v-model="objData.title"
                            />
                        </div>
                        <div class="form-group">
                            <label>Icon (FontAwesome class)</label>
                            <vs-input
                                type="text"
                                placeholder="VD: fa-solid fa-bolt"
                                class="w-100"
                                v-model="objData.icon"
                            />
                            <small style="color: #666">
                                Xem icon tại
                                <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com/icons</a>.
                                Preview:
                                <i v-if="objData.icon" :class="objData.icon" style="font-size:20px;margin-left:6px"></i>
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <vs-textarea v-model="objData.description" rows="4" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Vị trí (số càng nhỏ hiển thị trước)</label>
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
    name: "editWhyChoose",
    data() {
        return {
            errors: [],
            objData: {
                id: this.$route.params.id,
                title: "",
                icon: "",
                description: "",
                position: 0,
                status: 1,
            },
        };
    },
    methods: {
        ...mapActions(["addWhyChoose", "detailWhyChoose", "loadings"]),
        loadDetail() {
            this.loadings(true);
            this.detailWhyChoose({ id: this.$route.params.id })
                .then(response => {
                    this.loadings(false);
                    if (response.data) {
                        this.objData = {
                            id: response.data.id,
                            title: response.data.title || "",
                            icon: response.data.icon || "",
                            description: response.data.description || "",
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
            this.addWhyChoose(this.objData)
                .then(() => {
                    this.loadings(false);
                    this.$router.push({ name: "listWhyChoose" });
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
