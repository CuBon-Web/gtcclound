<template>
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách "Vì sao chọn chúng tôi"</h4>
                        <vs-button
                            type="gradient"
                            style="float:right;"
                            :disabled="!$hasPermission('whychoose.create')"
                            @click="$goIfAllowed('whychoose.create', { name: 'addWhyChoose' }, 'Bạn không có quyền thêm mới.')"
                        >Thêm mới</vs-button>
                        <vs-input icon="search" placeholder="Tìm theo tiêu đề" v-model="keyword" @keyup="searchItems" />
                        <vs-table stripe :data="list" max-items="15" pagination>
                            <template slot="thead">
                                <vs-th>STT</vs-th>
                                <vs-th>Icon</vs-th>
                                <vs-th>Tiêu đề</vs-th>
                                <vs-th>Mô tả</vs-th>
                                <vs-th>Vị trí</vs-th>
                                <vs-th>Trạng thái</vs-th>
                                <vs-th>Hành động</vs-th>
                            </template>
                            <template slot-scope="{ data }">
                                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                                    <vs-td>{{ indextr + 1 }}</vs-td>
                                    <vs-td>
                                        <i v-if="tr.icon" :class="tr.icon" style="font-size: 22px;"></i>
                                        <span v-else>—</span>
                                    </vs-td>
                                    <vs-td>{{ tr.title }}</vs-td>
                                    <vs-td>
                                        <div class="line_2" style="max-width: 360px;">{{ tr.description }}</div>
                                    </vs-td>
                                    <vs-td>{{ tr.position }}</vs-td>
                                    <vs-td>
                                        <vs-chip v-if="tr.status == 1" color="success">Hiện</vs-chip>
                                        <vs-chip v-else color="danger">Ẩn</vs-chip>
                                    </vs-td>
                                    <vs-td>
                                        <router-link :to="{ name: 'editWhyChoose', params: { id: tr.id } }">
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
            keyword: "",
            id_item: "",
            timer: null,
        };
    },
    methods: {
        ...mapActions(['listWhyChoose', 'loadings', 'deleteWhyChoose']),
        loadList() {
            this.loadings(true);
            this.listWhyChoose({ keyword: this.keyword })
                .then(response => {
                    this.loadings(false);
                    this.list = response.data;
                })
                .catch(err => {
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
                text: 'Xóa mục này khỏi danh sách',
                accept: this.destroy,
            });
        },
        destroy() {
            this.deleteWhyChoose({ id: this.id_item }).then(() => {
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
