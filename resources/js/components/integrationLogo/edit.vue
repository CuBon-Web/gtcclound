<template>
    <div>
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên đối tác/hệ thống <span style="color:red">*</span></label>
                            <vs-input type="text" placeholder="VD: GetFly CRM" class="w-100" v-model="objData.name" />
                        </div>
                        <div class="form-group">
                            <label>Nhóm tích hợp <span style="color:red">*</span></label>
                            <vs-select v-model="objData.group_key" class="w-100">
                                <vs-select-item
                                    v-for="(label, key) in groups"
                                    :key="key"
                                    :value="key"
                                    :text="label"
                                />
                            </vs-select>
                        </div>
                        <div class="form-group">
                            <label>Logo <span style="color:red">*</span></label>
                            <image-upload
                                v-model="objData.image"
                                type="avatar"
                                :title="'integration-logo-'"
                            ></image-upload>
                            <small style="color: #666">Khuyến nghị logo nền trong suốt, kích thước ~ 200x80px.</small>
                        </div>
                        <div class="form-group">
                            <label>Link (tùy chọn)</label>
                            <vs-input type="text" placeholder="https://..." class="w-100" v-model="objData.link" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Vị trí (số nhỏ hiển thị trước)</label>
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
    name: "editIntegrationLogo",
    data() {
        return {
            errors: [],
            groups: {
                crm: "Tích hợp hệ thống CRM",
                landline: "Tích hợp đầu số cố định",
                mobile: "Tích hợp đầu số di động",
            },
            objData: {
                id: this.$route.params.id,
                name: "",
                image: "",
                link: "",
                group_key: "crm",
                position: 0,
                status: 1,
            },
        };
    },
    methods: {
        ...mapActions(["addIntegrationLogo", "detailIntegrationLogo", "loadings"]),
        loadDetail() {
            this.loadings(true);
            this.detailIntegrationLogo({ id: this.$route.params.id })
                .then(response => {
                    this.loadings(false);
                    if (response.groups) this.groups = response.groups;
                    if (response.data) {
                        this.objData = {
                            id: response.data.id,
                            name: response.data.name || "",
                            image: response.data.image || "",
                            link: response.data.link || "",
                            group_key: response.data.group_key || "crm",
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
            if (!this.objData.name) this.errors.push("Tên không được để trống");
            if (!this.objData.image) this.errors.push("Logo URL không được để trống");
            if (!this.objData.group_key) this.errors.push("Vui lòng chọn nhóm tích hợp");
            if (this.errors.length > 0) {
                this.errors.forEach(value => this.$error(value));
                return;
            }
            this.loadings(true);
            this.addIntegrationLogo(this.objData)
                .then(() => {
                    this.loadings(false);
                    this.$router.push({ name: "listIntegrationLogo" });
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
