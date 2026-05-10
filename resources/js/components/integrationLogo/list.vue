<template>
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Logo đối tác tích hợp</h4>
                        <vs-button
                            type="gradient"
                            style="float:right;"
                            :disabled="!$hasPermission('integrationlogo.create')"
                            @click="$goIfAllowed('integrationlogo.create', { name: 'addIntegrationLogo' }, 'Bạn không có quyền thêm mới.')"
                        >Thêm mới</vs-button>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <vs-input icon="search" placeholder="Tìm theo tên" v-model="keyword" @keyup="searchItems" class="w-100" />
                            </div>
                            <div class="col-md-6">
                                <vs-select v-model="filterGroup" @change="loadList" placeholder="Lọc theo nhóm" class="w-100">
                                    <vs-select-item value="" text="Tất cả nhóm" />
                                    <vs-select-item
                                        v-for="(label, key) in groups"
                                        :key="key"
                                        :value="key"
                                        :text="label"
                                    />
                                </vs-select>
                            </div>
                        </div>
                        <vs-table stripe :data="list" max-items="20" pagination>
                            <template slot="thead">
                                <vs-th>STT</vs-th>
                                <vs-th>Logo</vs-th>
                                <vs-th>Tên</vs-th>
                                <vs-th>Nhóm</vs-th>
                                <vs-th>Vị trí</vs-th>
                                <vs-th>Trạng thái</vs-th>
                                <vs-th>Hành động</vs-th>
                            </template>
                            <template slot-scope="{ data }">
                                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                                    <vs-td>{{ indextr + 1 }}</vs-td>
                                    <vs-td>
                                        <img v-if="tr.image" :src="tr.image" alt="logo" style="width: 70px; height: 40px; object-fit: contain; background: #f8f9fb; border-radius: 4px;" />
                                        <span v-else>—</span>
                                    </vs-td>
                                    <vs-td>{{ tr.name }}</vs-td>
                                    <vs-td>
                                        <vs-chip color="primary">{{ groups[tr.group_key] || tr.group_key }}</vs-chip>
                                    </vs-td>
                                    <vs-td>{{ tr.position }}</vs-td>
                                    <vs-td>
                                        <vs-chip v-if="tr.status == 1" color="success">Hiện</vs-chip>
                                        <vs-chip v-else color="danger">Ẩn</vs-chip>
                                    </vs-td>
                                    <vs-td>
                                        <router-link :to="{ name: 'editIntegrationLogo', params: { id: tr.id } }">
                                            <vs-button vs-type="gradient" size="lagre" color="success" icon="edit"></vs-button>
                                        </router-link>
                                        <vs-button vs-type="gradient" size="lagre" color="red" icon="delete_forever" @click="confirmDestroy(tr.id)"></vs-button>
                                    </vs-td>
                                </vs-tr>
                            </template>
                        </vs-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
    data() {
        return {
            list: [],
            groups: {},
            keyword: "",
            filterGroup: "",
            id_item: "",
            timer: null,
        };
    },
    methods: {
        ...mapActions(['listIntegrationLogo', 'loadings', 'deleteIntegrationLogo']),
        loadList() {
            this.loadings(true);
            this.listIntegrationLogo({ keyword: this.keyword, group_key: this.filterGroup })
                .then(response => {
                    this.loadings(false);
                    this.list = response.data;
                    if (response.groups) this.groups = response.groups;
                })
                .catch(() => {
                    this.loadings(false);
                });
        },
        searchItems() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.loadList();
            }, 600);
        },
        confirmDestroy(id) {
            this.id_item = id;
            this.$vs.dialog({
                type: 'confirm',
                color: 'danger',
                title: 'Bạn có chắc chắn?',
                text: 'Xóa logo này khỏi danh sách',
                accept: this.destroy,
            });
        },
        destroy() {
            this.deleteIntegrationLogo({ id: this.id_item }).then(() => {
                this.loadList();
                this.$success('Xóa thành công');
            });
        },
    },
    mounted() {
        this.loadList();
    },
};
</script>
