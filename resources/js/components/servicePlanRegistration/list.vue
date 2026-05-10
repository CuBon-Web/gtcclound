<template>
  <div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Đăng ký bảng giá dịch vụ</h4>
            <p class="card-description">Khách đăng ký từ trang dịch vụ (nút Đăng ký ngay trên từng gói).</p>
            <div class="row mb-3">
              <div class="col-md-6">
                <vs-input
                  class="w-100"
                  v-model="keyword"
                  placeholder="Tìm theo tên, SĐT, email, gói, địa chỉ..."
                  @keyup.enter="loadList"
                />
              </div>
              <div class="col-md-6 d-flex align-items-end">
                <vs-button type="filled" color="primary" @click="loadList">Tìm kiếm</vs-button>
                <vs-button type="border" color="primary" class="ml-2" @click="resetKeyword">Xóa lọc</vs-button>
              </div>
            </div>
            <vs-table max-items="10" pagination :data="list">
              <template slot="thead">
                <vs-th>ID</vs-th>
                <vs-th>Danh mục</vs-th>
                <vs-th>Gói</vs-th>
                <vs-th>Họ tên</vs-th>
                <vs-th>SĐT</vs-th>
                <vs-th>Email</vs-th>
                <vs-th>Địa chỉ</vs-th>
                <vs-th>IP</vs-th>
                <vs-th>Ngày</vs-th>
                <vs-th>Hành động</vs-th>
              </template>
              <template slot-scope="{ data }">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                  <vs-td :data="tr.id">{{ tr.id }}</vs-td>
                  <vs-td :data="tr.service_category_id">
                    <span v-if="tr.category">{{ tr.category.name }}</span>
                    <span v-else class="text-muted">—</span>
                  </vs-td>
                  <vs-td :data="tr.plan_title">{{ tr.plan_title || "—" }}</vs-td>
                  <vs-td :data="tr.full_name">{{ tr.full_name }}</vs-td>
                  <vs-td :data="tr.phone">{{ tr.phone }}</vs-td>
                  <vs-td :data="tr.email">{{ tr.email }}</vs-td>
                  <vs-td :data="tr.address">
                    <span class="spr-address" :title="tr.address">{{ truncate(tr.address, 48) }}</span>
                  </vs-td>
                  <vs-td :data="tr.ip">{{ tr.ip || "—" }}</vs-td>
                  <vs-td :data="tr.created_at">{{ formatDate(tr.created_at) }}</vs-td>
                  <vs-td :data="tr.id">
                    <vs-button
                      vs-type="gradient"
                      size="lagre"
                      color="red"
                      icon="delete_forever"
                      :disabled="!$hasPermission('service.delete')"
                      @click="$goIfAllowed('service.delete', () => confirmDestroy(tr.id), 'Bạn không có quyền xóa đăng ký.')"
                    ></vs-button>
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
      keyword: "",
      list: [],
      id_item: null,
    };
  },
  methods: {
    ...mapActions(["listServicePlanRegistrations", "destroyServicePlanRegistration", "loadings"]),
    truncate(s, n) {
      if (!s) return "—";
      const t = String(s);
      return t.length <= n ? t : t.slice(0, n) + "…";
    },
    formatDate(val) {
      if (!val) return "—";
      try {
        const d = new Date(val);
        if (isNaN(d.getTime())) return val;
        return d.toLocaleString("vi-VN", {
          year: "numeric",
          month: "2-digit",
          day: "2-digit",
          hour: "2-digit",
          minute: "2-digit",
        });
      } catch (e) {
        return val;
      }
    },
    loadList() {
      this.loadings(true);
      this.listServicePlanRegistrations({ keyword: this.keyword || "" })
        .then((response) => {
          this.loadings(false);
          this.list = response.data || [];
        })
        .catch(() => {
          this.loadings(false);
        });
    },
    resetKeyword() {
      this.keyword = "";
      this.loadList();
    },
    destroy() {
      if (!this.id_item) return;
      this.loadings(true);
      this.destroyServicePlanRegistration({ id: this.id_item })
        .then(() => {
          this.loadList();
          this.loadings(false);
          this.$success("Xóa đăng ký thành công");
        })
        .catch(() => {
          this.loadings(false);
        });
    },
    confirmDestroy(id) {
      this.id_item = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Bạn có chắc chắn",
        text: "Xóa đăng ký này? Hành động không hoàn tác.",
        accept: this.destroy,
      });
    },
  },
  mounted() {
    this.loadList();
  },
};
</script>

<style scoped>
.spr-address {
  display: inline-block;
  max-width: 220px;
  vertical-align: top;
}
</style>
